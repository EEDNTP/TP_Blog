<?php
// Vérifie si la méthode de requête est POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupère et nettoie les données du formulaire
    $lastname = htmlspecialchars(trim($_POST['lastname'])); // Nettoie et sécurise le nom de famille
    $firstname = htmlspecialchars(trim($_POST['firstname'])); // Nettoie et sécurise le prénom
    $email = $_POST['email']; // Récupère l'email

    // Vérifie si l'un des champs est vide
    if (empty($lastname) || empty($firstname) || empty($email)) {
        die ('Merci de remplir le formulaire'); // Arrête le script et affiche un message d'erreur
    }

    // Vérifie la validité des champs
    if (strlen($lastname) > 100 || strlen($firstname) > 100 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('Au moins un des champs est incorrect'); // Arrête le script et affiche un message d'erreur
    }

    // Inclut le fichier de connexion à la base de données
    require_once 'includes/dbconnect.php';

    // Prépare la requête SQL pour insérer un nouvel auteur
    $sql = 'INSERT INTO authors (lastname, firstname, email) VALUES(:lastname, :firstname, :email);';
    $stmt = $pdo->prepare($sql); // Prépare la requête

    // Lie les valeurs des paramètres à la requête
    $stmt->bindValue(':lastname', $lastname, PDO::PARAM_STR);
    $stmt->bindValue(':firstname', $firstname, PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);

    // Exécute la requête
    if($stmt->execute()) {
        die('Auteur ajouté avec succès'); // Arrête le script et affiche un message de succès
    }
}
