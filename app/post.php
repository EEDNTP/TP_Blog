<?php
// Vérifie si la méthode de requête est GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Récupère l'identifiant du post depuis les paramètres GET de l'URL
    $id = $_GET['id'];

    // Vérifie si l'identifiant est un nombre
    if (is_numeric($id)) {
        // Inclut le fichier de connexion à la base de données
        require_once 'includes/dbconnect.php';

        // Prépare la requête SQL pour sélectionner les informations du post et de l'auteur associé
        $sql = "SELECT posts.*, authors.firstname, authors.lastname FROM posts INNER JOIN authors ON posts.authors_id = authors.id WHERE posts.id = :id";

        // Prépare la requête SQL
        $stmt = $pdo->prepare($sql);

        // Lie la valeur de l'identifiant à la requête en tant qu'entier
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        // Exécute la requête
        $stmt->execute();

        // Récupère les informations du post
        $post = $stmt->fetch();

        // Vérifie si le post existe
        if (!$post) {
            die('Article inexistant'); // Arrête le script et affiche un message d'erreur si le post n'existe pas
        }

        // Prépare la requête SQL pour sélectionner les commentaires
        $sql = "SELECT * FROM comments WHERE posts_id = :id ORDER BY created_at DESC;";

        // Prépare la requête SQL
        $stmt = $pdo->prepare($sql);

        // Lie la valeur de l'identifiant à la requête en tant qu'entier
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        // Exécute la requête
        $stmt->execute();

        // Récupère les informations des commentaires
        $comments = $stmt->fetchAll();
    }
}
?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= htmlspecialchars($post['title']) ?></title>
</head>

<body>
    <header>
        <?php include_once 'includes/nav.php'; ?>
        <h1><?= htmlspecialchars($post['title']) ?></h1>
    </header>

    <main>
        <!-- Affiche le nom et le prénom de l'auteur de l'article en utilisant htmlspecialchars pour sécuriser l'affichage -->
        <p>Article de <?= htmlspecialchars($post['firstname']) ?> <?= htmlspecialchars($post['lastname']) ?></p>

        <!-- Affiche la date de création de l'article en utilisant htmlspecialchars pour sécuriser l'affichage -->
        <p>Ecrit le <time datetime="<?= htmlspecialchars($post['created_at']) ?>"><?= htmlspecialchars($post['created_at']) ?></time></p>

        <div>
            <!-- Affiche le contenu de l'article -->
            <?= $post['content'] ?>
        </div>

        <section>
            <h2>Commenter l'article</h2>
            <form action="comment_treatment.php" method="post">
                <div>
                    <label for="comment">Commentaire</label>
                    <textarea name="content" id="comment"></textarea>
                </div>
                <input type="hidden" name="id" value="<?= intval($post['id']); ?>">
                <button type="submit">Envoyer</button>
            </form>
        </section>
        <section>
            <h2>Commentaires</h2>
            <?php foreach ($comments as $comment): ?>
                <article>
                    <p><?= htmlspecialchars($comment['content']); ?></p>
                    <p>Ecrit le <time datetime="<?= htmlspecialchars($comment['created_at']) ?>"><?= htmlspecialchars($comment['created_at']) ?></time></p>
                </article>
            <?php endforeach; ?>
        </section>
    </main>
</body>

</html>