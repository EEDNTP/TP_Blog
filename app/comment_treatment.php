<?php
// Vérifie si la méthode de requête est POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifie si les champs 'content' et 'id' sont vides
    if (empty($_POST['content']) || empty($_POST['id'])) {
        die('Le formulaire est incomplet'); // Arrête le script et affiche un message d'erreur si le formulaire est incomplet
    }

    // Récupère et nettoie le contenu du commentaire
    $comment = htmlspecialchars(trim($_POST['content']));
    // Récupère l'identifiant du post
    $id = $_POST['id'];

    // Vérifie si le commentaire dépasse 500 caractères ou si l'identifiant n'est pas un nombre
    if (strlen($comment) > 500 || !is_numeric($id)) {
        die('Les données envoyées sont incorrectes'); // Arrête le script et affiche un message d'erreur si les données sont incorrectes
    }

    // Inclut le fichier de connexion à la base de données
    require 'includes/dbconnect.php';

    // Prépare la requête SQL pour insérer un nouveau commentaire
    $sql = 'INSERT INTO comments (content, posts_id) VALUES (:comment, :posts_id);';

    // Prépare la requête SQL
    $stmt = $pdo->prepare($sql);

    // Lie les valeurs des paramètres à la requête
    $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
    $stmt->bindValue(':posts_id', $id, PDO::PARAM_INT);

    // Exécute la requête
    if ($stmt->execute()) {
        // Redirige vers la page du post après l'insertion du commentaire
        header('Location: post.php?id=' . $id);
        exit;
    }
}
