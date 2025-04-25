<?php
// Inclut le fichier de connexion à la base de données
require_once 'includes/dbconnect.php';

// Prépare la requête SQL pour sélectionner toutes les catégories
$sql = 'SELECT * FROM categories;';

// Exécute la requête SQL
$stmt = $pdo->query($sql);

// Récupère tous les résultats de la requête sous forme de tableau associatif
$categories = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des categories</title>
</head>

<body>
    <header>
        <?php include_once 'includes/nav.php'; ?>
        <h1>Liste des categories</h1>
    </header>

    <main>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Boucle à travers chaque catégorie récupérée de la base de données
                foreach ($categories as $category): ?>
                    <tr>
                        <!-- Affiche le nom de la catégorie en utilisant htmlspecialchars pour sécuriser l'affichage -->
                        <td><?= htmlspecialchars($category['name']); ?></td>
                        <!-- Affiche la description de la catégorie en utilisant htmlspecialchars pour sécuriser l'affichage -->
                        <td><?= htmlspecialchars($category['description']); ?></td>

                        <!-- Liens des actions -->
                        <td>
                            <a href="edit_category.php?id=<?= intval($category['id']); ?>">Modifier</a> - <a href="category_articles.php?id=<?= intval($category['id']); ?>">Voir les articles</a> -
                            <form action="delete_category.php?id=<?= intval($category['id']); ?>" method="post">
                                <button type="submit">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>

</html>