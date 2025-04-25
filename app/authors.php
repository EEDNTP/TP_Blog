<?php
// Inclut le fichier de connexion à la base de données
require_once 'includes/dbconnect.php';

// Prépare la requête SQL pour sélectionner tous les auteurs
$sql = 'SELECT * FROM authors;';

// Exécute la requête SQL
$stmt = $pdo->query($sql);

// Récupère tous les résultats de la requête sous forme de tableau associatif
$authors = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des auteurs</title>
</head>

<body>
    <header>
        <?php include_once 'includes/nav.php'; ?>
        <h1>Liste des auteurs</h1>
    </header>

    <main>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Boucle à travers chaque auteur récupéré de la base de données
                foreach ($authors as $author): ?>
                    <tr>
                        <!-- Affiche le nom de famille de l'auteur en utilisant htmlspecialchars pour sécuriser l'affichage -->
                        <td><?= htmlspecialchars($author['lastname']); ?></td>
                        <!-- Affiche le prénom de l'auteur en utilisant htmlspecialchars pour sécuriser l'affichage -->
                        <td><?= htmlspecialchars($author['firstname']); ?></td>
                        <!-- Affiche l'email de l'auteur en utilisant htmlspecialchars pour sécuriser l'affichage -->
                        <td><?= htmlspecialchars($author['email']); ?></td>
                        <!-- Lien pour voir les articles de l'auteur -->
                        <td><a href="author_articles.php?id=<?= intval($author['id']); ?>">Voir les articles</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>

</html>