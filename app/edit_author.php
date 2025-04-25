<?php
// Récupère l'identifiant de l'auteur depuis les paramètres GET de l'URL
$id = $_GET['id'];

// Vérifie si l'identifiant est un nombre
if (is_numeric($id)) {
    // Inclut le fichier de connexion à la base de données
    require_once 'includes/dbconnect.php';

    // Prépare la requête SQL pour sélectionner l'auteur avec l'identifiant donné
    $sql = 'SELECT * FROM authors WHERE id = :id;';

    // Prépare la requête SQL
    $stmt = $pdo->prepare($sql);

    // Lie la valeur de l'identifiant à la requête en tant qu'entier
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);

    // Exécute la requête
    $stmt->execute();

    // Récupère les informations de l'auteur
    $author = $stmt->fetch();

    // Vérifie si l'auteur existe
    if (!$author) {
        die('Auteur inexistant'); // Arrête le script et affiche un message d'erreur si l'auteur n'existe pas
    }
} else {
    die('ID incorrect'); // Arrête le script et affiche un message d'erreur si l'identifiant n'est pas un nombre
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'auteur "<?= htmlspecialchars($author['firstname']); ?> <?= htmlspecialchars($author['lastname']); ?>"</title>
</head>

<body>
    <header>
        <?php include_once 'includes/nav.php'; ?>
        <h1>Modifier l'auteur "<?= htmlspecialchars($author['firstname']); ?> <?= htmlspecialchars($author['lastname']); ?>"</h1>
    </header>

    <main>
        <form action="edit_author_treatment.php" method="post">
            <small>Tous les champs sont obligatoires</small>
            <div>
                <label for="lastname">Nom</label>
                <input type="text" id="lastname" name="lastname" value="<?= htmlspecialchars($author['lastname']); ?>">
            </div>
            <div>
                <label for="firstname">Prenom</label>
                <input type="text" id="firstname" name="firstname" value="<?= htmlspecialchars($author['firstname']); ?>">
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($author['email']); ?>">
            </div>
            <input type="hidden" name="id"  value="<?= intval($author['id']); ?>">
            <button type="submit">Modifier</button>
        </form>
    </main>
</body>

</html>