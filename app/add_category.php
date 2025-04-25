<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une catégorie</title>
</head>

<body>
<header>
        <?php include_once 'includes/nav.php'; ?>
        <h1>Ajouter une catégorie</h1>
    </header>

    <main>
        <form action="add_category_treatment.php" method="post">
            <small>Seul le nom de la catégorie est obligatoire</small>
            <div>
                <label for="name">Nom de la catégorie</label>
                <input type="text" id="name" name="name">
            </div>
            <div>
                <label for="description">Description</label>
                <input type="text" id="description" name="description">
            </div>
            <button type="submit">Envoyer</button>
        </form>
    </main>
</body>

</html>