<?php
// Vérifie si la méthode de requête est POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifie si l'identifiant est présent dans les paramètres GET et si c'est un nombre
    if (!empty($_GET['id']) && is_numeric($_GET['id'])) {
        // Récupère l'identifiant de la catégorie
        $id = $_GET['id'];

        // Inclut le fichier de connexion à la base de données
        require_once 'includes/dbconnect.php';

        // Prépare la requête SQL pour supprimer les associations de la catégorie dans la table posts_categories
        $sql = 'DELETE FROM posts_categories WHERE categories_id = :id';
        $stmt = $pdo->prepare($sql);

        // Lie la valeur de l'identifiant à la requête en tant qu'entier
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        // Exécute la requête pour supprimer les associations
        $stmt->execute();

        // Prépare la requête SQL pour supprimer la catégorie de la table categories
        $sql = 'DELETE FROM categories WHERE id = :id';
        $stmt = $pdo->prepare($sql);

        // Lie la valeur de l'identifiant à la requête en tant qu'entier
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        // Exécute la requête pour supprimer la catégorie
        if ($stmt->execute()) {
            // Redirige vers la page des catégories après la suppression
            header('Location: categories.php');
        }
    }
}
