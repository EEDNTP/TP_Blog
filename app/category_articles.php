<?php
// Vérifie si l'identifiant dans les paramètres GET est un nombre
if (is_numeric($_GET['id'])) {
    // Récupère l'identifiant de la catégorie
    $id = $_GET['id'];

    // Inclut le fichier de connexion à la base de données
    require_once 'includes/dbconnect.php';

    // Prépare la requête SQL pour sélectionner les articles de la catégorie ainsi que ses informations
    $sql = 'SELECT posts.title, posts.created_at, categories.name FROM categories
            LEFT JOIN posts_categories ON posts_categories.categories_id = categories.id
            LEFT JOIN posts ON posts.id = posts_categories.posts_id
            WHERE categories.id = :id;';

    // Prépare la requête SQL
    $stmt = $pdo->prepare($sql);

    // Lie la valeur de l'identifiant à la requête en tant qu'entier
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);

    // Exécute la requête
    $stmt->execute();

    // Récupère tous les articles de la catégorie
    $posts = $stmt->fetchAll();

    // Récupère le nom de la catégorie à partir du premier résultat et sécurise l'affichage avec htmlspecialchars
    $categoryName = htmlspecialchars($posts[0]['name']);
}
?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Articles dans la catégorie <?= $categoryName ?></title>
</head>

<body>
    <header>
        <?php include_once 'includes/nav.php'; ?>
        <h1>Articles dans la catégorie <?= $categoryName ?></h1>
    </header>
    <main>
        <?php if (!isset($posts[0]['title'])): ?>
            <!-- Affiche un message si la catégorie n'a pas encore d'article -->
            <p>Cette catégorie ne contient pas encore d'article</p>
        <?php else: ?>
            <?php foreach ($posts as $post): ?>
                <article>
                    <!-- Affiche le titre du post en utilisant htmlspecialchars pour sécuriser l'affichage -->
                    <h2><?= htmlspecialchars($post['title']) ?></h2>
                    <!-- Affiche la date de création du post en utilisant htmlspecialchars pour sécuriser l'affichage -->
                    <time datetime="<?= htmlspecialchars($post['created_at']) ?>">
                        <?= htmlspecialchars($post['created_at']) ?>
                    </time>
                </article>
            <?php endforeach; ?>
        <?php endif; ?>
        <!-- Lien pour retourner à la liste des auteurs -->
        <a href="authors.php">Retour vers liste des auteurs</a>
    </main>
</body>

</html>