<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un auteur</title>
</head>

<body>
    <header>
        <?php include_once 'includes/nav.php'; ?>
        <h1>Ajouter un auteur</h1>
    </header>

    <main>
        <form action="add_author_treatment.php" method="post">
            <small>Tous les champs sont obligatoires</small>
            <div>
                <label for="lastname">Nom</label>
                <input type="text" id="lastname" name="lastname">
            </div>
            <div>
                <label for="firstname">Prenom</label>
                <input type="text" id="firstname" name="firstname">
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" id="email" name="email">
            </div>
            <button type="submit">Ajouter</button>
        </form>
    </main>
</body>

</html>