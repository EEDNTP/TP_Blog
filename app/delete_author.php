<?php
// Vérifie si la méthode de requête est POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifie si l'identifiant est présent dans les paramètres GET et si c'est un nombre
    if (!empty($_GET['id']) && is_numeric($_GET['id'])) {
        // Récupère l'identifiant de l'auteur
        $id = $_GET['id'];

        // Inclut le fichier de connexion à la base de données
        require_once 'includes/dbconnect.php';

        // Prépare la requête SQL pour sélectionner les identifiants des posts de l'auteur
        $sql = 'SELECT id FROM posts WHERE authors_id = :id';
        $stmt = $pdo->prepare($sql);

        // Lie la valeur de l'identifiant à la requête en tant qu'entier
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        // Exécute la requête
        $stmt->execute();

        // Récupère tous les posts de l'auteur
        $posts = $stmt->fetchAll();

        // Parcourt chaque post de l'auteur
        foreach ($posts as $post) {
            // Prépare la requête SQL pour supprimer les commentaires associés au post
            $sql = 'DELETE FROM comments WHERE posts_id = :id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':id', $post['id'], PDO::PARAM_INT);
            $stmt->execute();

            // Prépare la requête SQL pour supprimer les associations de catégories du post
            $sql = 'DELETE FROM posts_categories WHERE posts_id = :id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':id', $post['id'], PDO::PARAM_INT);
            $stmt->execute();

            // Prépare la requête SQL pour supprimer le post
            $sql = 'DELETE FROM posts WHERE id = :id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':id', $post['id'], PDO::PARAM_INT);
            $stmt->execute();
        }

        // Prépare la requête SQL pour supprimer l'auteur
        $sql = 'DELETE FROM authors WHERE id = :id';
        $stmt = $pdo->prepare($sql);

        // Lie la valeur de l'identifiant à la requête en tant qu'entier
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        // Exécute la requête pour supprimer l'auteur
        if ($stmt->execute()) {
            // Redirige vers la page des auteurs après la suppression
            header('Location: authors.php');
        }
    }
}
