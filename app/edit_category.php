<?php
// Récupère l'identifiant de la catégorie depuis les paramètres GET de l'URL
$id = $_GET['id'];

// Vérifie si l'identifiant est un nombre
if (is_numeric($id)) {
    // Inclut le fichier de connexion à la base de données
    require_once 'includes/dbconnect.php';

    // Prépare la requête SQL pour sélectionner la catégorie avec l'identifiant donné
    $sql = 'SELECT * FROM categories WHERE id = :id;';

    // Prépare la requête SQL
    $stmt = $pdo->prepare($sql);

    // Lie la valeur de l'identifiant à la requête en tant qu'entier
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);

    // Exécute la requête
    $stmt->execute();

    // Récupère les informations de la catégorie
    $category = $stmt->fetch();

    // Vérifie si la catégorie existe
    if (!$category) {
        die('Catégorie inexistante'); // Arrête le script et affiche un message d'erreur si la catégorie n'existe pas
    }
} else {
    die('ID incorrect'); // Arrête le script et affiche un message d'erreur si l'identifiant n'est pas un nombre
}

?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une catégorie</title>
</head>

<body>
<header>
        <?php include_once 'includes/nav.php'; ?>
        <h1>Modifier une catégorie</h1>
    </header>

    <main>
        <form action="edit_category_treatment.php" method="post">
            <small>Seul le nom de la catégorie est obligatoire</small>
            <div>
                <label for="name">Nom de la catégorie</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($category['name']) ?>">
            </div>
            <div>
                <label for="description">Description</label>
                <input type="text" id="description" name="description" value="<?= htmlspecialchars($category['description']) ?>">
            </div>
            <input type="hidden" name="id" value="<?= intval($category['id']) ?>">
            <button type="submit">Envoyer</button>
        </form>
    </main>
</body>

</html>