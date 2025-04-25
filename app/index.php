<?php
// Inclut le fichier de connexion à la base de données
require_once 'includes/dbconnect.php';

// Prépare la requête SQL pour sélectionner tous les articles
$sql = 'SELECT * FROM posts;';

// Exécute la requête SQL
$stmt = $pdo->query($sql);

// Récupère tous les résultats de la requête sous forme de tableau associatif
$posts = $stmt->fetchAll();
?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Liste des articles</title>
</head>

<body>
    <header>
        <?php include_once 'includes/nav.php'; ?>
        <h1>Liste des articles</h1>
    </header>

    <main>
        <?php foreach ($posts as $post): ?>
            <article>
                <!-- Affiche le titre du post avec un lien vers la page du post -->
                <h2>
                    <a href="post.php?id=<?= intval($post['id']) ?>">
                        <?= htmlspecialchars($post['title']) ?>
                    </a>
                </h2>
                <!-- Affiche la date de création du post -->
                <time datetime="<?= htmlspecialchars($post['created_at']) ?>">
                    <?= htmlspecialchars($post['created_at']) ?>
                </time>
            </article>
        <?php endforeach; ?>
    </main>
</body>

</html>