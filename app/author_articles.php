<?php
// Vérifie si l'identifiant dans les paramètres GET est un nombre
if (is_numeric($_GET['id'])) {
    // Récupère l'identifiant de l'auteur
    $id = $_GET['id'];

    // Inclut le fichier de connexion à la base de données
    require_once 'includes/dbconnect.php';

    // Prépare la requête SQL pour sélectionner les articles de l'auteur ainsi que ses informations personnelles
    $sql = 'SELECT posts.title, posts.created_at, authors.lastname, authors.firstname FROM authors LEFT JOIN posts ON posts.authors_id = authors.id WHERE authors.id = :id;';

    // Prépare la requête SQL
    $stmt = $pdo->prepare($sql);

    // Lie la valeur de l'identifiant à la requête en tant qu'entier
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);

    // Exécute la requête
    $stmt->execute();

    // Récupère tous les articles de l'auteur
    $posts = $stmt->fetchAll();

    // Récupère le nom et le prénom de l'auteur à partir du premier résultat
    $authorLastname = $posts[0]['lastname'];
    $authorFirstname = $posts[0]['firstname'];
}

?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Articles écrits par <?= $authorLastname ?> <?= $authorFirstname ?> </title>
</head>

<body>
    <main>
        <h1>Articles écrits par <?= htmlspecialchars($authorLastname) ?> <?= htmlspecialchars($authorFirstname) ?></h1>
        <?php if (!isset($posts[0]['title'])): ?>
            <!-- Affiche un message si l'auteur n'a pas encore écrit d'article -->
            <p>Cet auteur n'a pas encore écrit d'article</p>
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