<?php
// Vérifie si la méthode de requête est POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupère et nettoie les données du formulaire
    $name = htmlspecialchars(trim($_POST['name'])); // Nettoie et sécurise le nom de la catégorie
    $description = htmlspecialchars(trim($_POST['description'])); // Nettoie et sécurise la description
    $id = $_POST['id'];

    // Vérifie si le champ 'name' est vide
    if (empty($name) || empty($id)) {
        die ('Merci de renseigner le nom de la catégorie'); // Arrête le script et affiche un message d'erreur
    }

    // Vérifie la validité des champs
    if (strlen($name) > 50 || strlen($description) > 255 || !is_numeric($id)) {
        die('Au moins un des champs est incorrect'); // Arrête le script et affiche un message d'erreur
    }

    // Inclut le fichier de connexion à la base de données
    require_once 'includes/dbconnect.php';

    // Prépare la requête SQL pour insérer une nouvelle catégorie
    $sql = 'UPDATE categories SET name = :name, description = :description WHERE id = :id;';
    $stmt = $pdo->prepare($sql); // Prépare la requête

    // Lie les valeurs des paramètres à la requête
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':description', $description, PDO::PARAM_STR);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);

    // Exécute la requête
    if ($stmt->execute()) {
        die('La catégorie a été modifiée avec succès.'); // Arrête le script et affiche un message de succès
    }
}
