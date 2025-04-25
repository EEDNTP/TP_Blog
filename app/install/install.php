<?php
require_once '../includes/dbconnect.php';

// Fonction pour créer les tables
function createTables($pdo) {
    $queries = [
        "DROP DATABASE IF EXISTS blog;",
        "CREATE DATABASE blog;",
        "USE blog;",
        "CREATE TABLE IF NOT EXISTS authors (
            id INT AUTO_INCREMENT PRIMARY KEY,
            lastname VARCHAR(100) NOT NULL,
            firstname VARCHAR(100) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE
        )",
        "CREATE TABLE IF NOT EXISTS categories (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(50) NOT NULL,
            description VARCHAR(255)
        )",
        "CREATE TABLE IF NOT EXISTS posts (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
            content TEXT NOT NULL,
            authors_id INT NOT NULL,
            FOREIGN KEY (authors_id) REFERENCES authors(id)
        )",
        "CREATE TABLE IF NOT EXISTS posts_categories (
            posts_id INT NOT NULL,
            categories_id INT NOT NULL,
            PRIMARY KEY(posts_id, categories_id),
            FOREIGN KEY (posts_id) REFERENCES posts(id),
            FOREIGN KEY (categories_id) REFERENCES categories(id)
        )",
        "CREATE TABLE IF NOT EXISTS comments (
            id INT AUTO_INCREMENT PRIMARY KEY,
            content VARCHAR(500) NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
            posts_id INT NOT NULL,
            FOREIGN KEY (posts_id) REFERENCES posts(id)
        )"
    ];

    foreach ($queries as $query) {
        $pdo->exec($query);
    }
}

// Fonction pour insérer des auteurs
function insertAuthors($pdo) {
    $authors = [
        ['Dupont', 'Jean', 'jean.dupont@example.com'],
        ['Martin', 'Marie', 'marie.martin@example.com'],
        ['Bernard', 'Paul', 'paul.bernard@example.com'],
        ['Durand', 'Sophie', 'sophie.durand@example.com'],
        ['Dubois', 'Pierre', 'pierre.dubois@example.com'],
        ['Moreau', 'Julie', 'julie.moreau@example.com'],
        ['Fournier', 'Marc', 'marc.fournier@example.com'],
        ['Girard', 'Caroline', 'caroline.girard@example.com'],
        ['Lefevre', 'Nicolas', 'nicolas.lefevre@example.com'],
        ['Rousseau', 'Isabelle', 'isabelle.rousseau@example.com']
    ];

    $stmt = $pdo->prepare("INSERT INTO authors (lastname, firstname, email) VALUES (?, ?, ?)");
    foreach ($authors as $author) {
        $stmt->execute($author);
    }
}

// Fonction pour insérer des catégories
function insertCategories($pdo) {
    $categories = [
        ['Technologie', 'Articles sur les nouvelles technologies'],
        ['Santé', 'Conseils et actualités sur la santé'],
        ['Sport', 'Actualités et analyses sportives'],
        ['Voyage', 'Guides et conseils de voyage'],
        ['Cuisine', 'Recettes et astuces culinaires'],
        ['Éducation', 'Ressources et conseils éducatifs'],
        ['Finance', 'Conseils et actualités financières'],
        ['Mode', 'Tendances et conseils de mode'],
        ['Culture', 'Articles sur la culture et les arts'],
        ['Science', 'Découvertes et actualités scientifiques'],
        ['Environnement', 'Articles sur l\'écologie et l\'environnement'],
        ['Politique', 'Analyses et actualités politiques'],
        ['Divertissement', 'Actualités sur le cinéma, la musique et les jeux'],
        ['Automobile', 'Conseils et actualités sur les voitures'],
        ['Immobilier', 'Conseils et actualités sur l\'immobilier'],
        ['Famille', 'Conseils et actualités pour la famille'],
        ['Animaux', 'Conseils et actualités sur les animaux'],
        ['Business', 'Conseils et actualités pour les entreprises'],
        ['High-Tech', 'Actualités sur les gadgets et les innovations technologiques'],
        ['Bien-être', 'Conseils pour le bien-être et la relaxation'],
        ['Littérature', 'Critiques et analyses de livres'],
        ['Histoire', 'Articles sur l\'histoire et les événements passés'],
        ['Beauté', 'Conseils et tendances en matière de beauté'],
        ['Économie', 'Analyses et actualités économiques'],
        ['Loisirs', 'Idées et conseils pour les loisirs et les activités'],
        ['Nature', 'Articles sur la nature et les paysages'],
        ['Société', 'Analyses et actualités sur la société'],
        ['Art', 'Articles sur l\'art et les artistes'],
        ['Musique', 'Actualités et critiques musicales'],
        ['Cinéma', 'Critiques et actualités sur les films'],
        ['Jeux vidéo', 'Actualités et critiques sur les jeux vidéo'],
        ['Photographie', 'Conseils et actualités sur la photographie'],
        ['Bricolage', 'Idées et conseils pour le bricolage'],
        ['Jardinage', 'Conseils et actualités sur le jardinage'],
        ['Décoration', 'Idées et conseils pour la décoration intérieure'],
        ['Fitness', 'Conseils et programmes de fitness'],
        ['Yoga', 'Conseils et pratiques de yoga'],
        ['Voyages', 'Récits et conseils de voyage'],
        ['Aventure', 'Articles sur les aventures et les expéditions'],
        ['Gastronomie', 'Articles sur la gastronomie et les restaurants'],
        ['Vin', 'Conseils et actualités sur le vin'],
        ['Théâtre', 'Articles sur le théâtre et les spectacles'],
        ['Danse', 'Articles sur la danse et les spectacles de danse'],
        ['Architecture', 'Articles sur l\'architecture et les bâtiments'],
        ['Design', 'Articles sur le design et les tendances'],
        ['Informatique', 'Conseils et actualités sur l\'informatique'],
        ['Électronique', 'Articles sur les composants électroniques'],
        ['Robotique', 'Articles sur la robotique et les innovations'],
        ['Astronomie', 'Articles sur l\'astronomie et les découvertes spatiales'],
        ['Archéologie', 'Articles sur les fouilles et les découvertes archéologiques']
    ];

    $stmt = $pdo->prepare("INSERT INTO categories (name, description) VALUES (?, ?)");
    foreach ($categories as $category) {
        $stmt->execute($category);
    }
}

// Fonction pour insérer des posts
function insertPosts($pdo) {
    $posts = [
        [4, 'Les meilleures destinations de voyage en Europe', '<h1>Les meilleures destinations de voyage en Europe</h1><p>L\'Europe regorge de destinations incroyables à découvrir. Que vous soyez amateur de culture, de nature ou de gastronomie, il y en a pour tous les goûts. Dans cet article, nous vous présentons les meilleures destinations de voyage en Europe.</p><p>Paris, la ville de l\'amour, est incontournable pour ses monuments emblématiques comme la Tour Eiffel et le Louvre. Barcelone, avec son architecture unique et ses plages magnifiques, est une autre destination populaire. Pour les amoureux de la nature, les fjords de Norvège et les paysages à couper le souffle des Alpes suisses sont à ne pas manquer.</p>'],
        [5, 'Recette de la tarte aux pommes', '<h1>Recette de la tarte aux pommes</h1><p>La tarte aux pommes est un dessert classique et délicieux. Voici une recette simple pour réaliser une tarte aux pommes maison.</p><p>Ingrédients : 1 pâte brisée, 4 pommes, 50g de sucre, 1 cuillère à soupe de cannelle, 1 citron. Préparation : Préchauffez votre four à 180°C. Étalez la pâte brisée dans un moule à tarte. Épluchez et coupez les pommes en fines tranches. Disposez-les sur la pâte. Saupoudrez de sucre et de cannelle. Arrosez de jus de citron. Enfournez pendant 30 minutes. Laissez refroidir avant de déguster.</p>'],
        [6, 'Comment investir en bourse ?', '<h1>Comment investir en bourse ?</h1><p>Investir en bourse peut être une excellente façon de faire fructifier votre argent. Cependant, il est important de bien se préparer avant de se lancer. Dans cet article, nous vous donnons des conseils pour investir en bourse de manière intelligente.</p><p>Tout d\'abord, il est essentiel de diversifier votre portefeuille pour réduire les risques. Ensuite, informez-vous sur les différentes actions et secteurs avant d\'investir. Utilisez des outils d\'analyse financière pour suivre les performances de vos investissements. Enfin, soyez patient et ne prenez pas de décisions hâtives basées sur des fluctuations à court terme.</p>'],
        [7, 'Les meilleurs exercices de fitness', '<h1>Les meilleurs exercices de fitness</h1><p>Pour rester en forme, il est important de pratiquer régulièrement des exercices de fitness. Voici une sélection des meilleurs exercices pour améliorer votre condition physique.</p><p>Les squats sont excellents pour renforcer les jambes et les fessiers. Les pompes travaillent les muscles des bras, de la poitrine et des épaules. Les abdominaux sont essentiels pour un ventre plat et tonique. N\'oubliez pas de varier vos exercices pour éviter la monotonie et continuer à progresser.</p>'],
        [8, 'Les dernières innovations en matière de smartphones', '<h1>Les dernières innovations en matière de smartphones</h1><p>Les smartphones évoluent constamment avec de nouvelles innovations. Dans cet article, nous explorons les dernières tendances en matière de smartphones.</p><p>Les écrans pliables sont l\'une des innovations les plus marquantes. Ils offrent une plus grande surface d\'affichage tout en restant compacts. Les caméras intégrées sont de plus en plus performantes, avec des capteurs améliorés et des fonctionnalités d\'intelligence artificielle. Les batteries à charge rapide et à longue durée de vie sont également une priorité pour les fabricants.</p>'],
        [9, 'Conseils pour bien dormir', '<h1>Conseils pour bien dormir</h1><p>Un bon sommeil est essentiel pour la santé. Voici quelques conseils pour améliorer la qualité de votre sommeil.</p><p>Évitez les écrans avant de vous coucher, car la lumière bleue peut perturber votre cycle de sommeil. Créez un environnement propice au sommeil avec une température agréable et une literie confortable. Établissez une routine de coucher régulière et évitez la caféine et l\'alcool avant de dormir.</p>'],
        [10, 'Les meilleurs films de 2025', '<h1>Les meilleurs films de 2025</h1><p>L\'année 2025 a été riche en films incroyables. Voici notre sélection des meilleurs films de l\'année.</p><p>"Voyage vers les étoiles" est un film de science-fiction captivant qui explore les mystères de l\'univers. "Amour éternel" est une comédie romantique touchante qui a conquis le cœur des spectateurs. "L\'énigme du temps" est un thriller palpitant qui vous tiendra en haleine jusqu\'à la fin.</p>'],
        [3, 'Les bienfaits de la méditation', '<h1>Les bienfaits de la méditation</h1><p>La méditation est une pratique ancestrale qui offre de nombreux bienfaits pour le corps et l\'esprit. Elle réduit le stress, améliore la concentration et favorise le bien-être général. Dans cet article, nous explorons les différents types de méditation et leurs bienfaits spécifiques.</p><p>La méditation de pleine conscience, par exemple, consiste à se concentrer sur le moment présent. La méditation transcendantale, en revanche, utilise des mantras pour atteindre un état de relaxation profonde.</p>'],
        [1, 'Les avantages du télétravail', '<h1>Les avantages du télétravail</h1><p>Le télétravail est devenu une pratique courante dans de nombreuses entreprises. Il offre de nombreux avantages, notamment une meilleure conciliation entre vie professionnelle et vie personnelle, une réduction des coûts de transport et une plus grande flexibilité. Dans cet article, nous explorons les avantages et les défis du télétravail.</p><p>Cependant, le télétravail peut également présenter des défis, tels que l\'isolement social et la difficulté à séparer vie professionnelle et vie personnelle. Il est important de mettre en place des stratégies pour surmonter ces défis.</p>'],
        [2, 'Les tendances du marché immobilier en 2025', '<h1>Les tendances du marché immobilier en 2025</h1><p>En 2025, le marché immobilier est marqué par des tendances innovantes et durables. Les acheteurs recherchent des maisons intelligentes et écologiques. Dans cet article, nous explorons les tendances clés du marché immobilier pour 2025.</p><p>Les maisons intelligentes, intégrant des technologies comme les capteurs et les matériaux thermorégulants, sont à la pointe du marché. Les couleurs vives et les motifs audacieux sont également en vogue, reflétant un désir de créativité et d\'expression personnelle.</p>'],
        [4, 'Les meilleurs exercices de musculation', '<h1>Les meilleurs exercices de musculation</h1><p>Pour développer votre masse musculaire, il est important de pratiquer régulièrement des exercices de musculation. Voici une sélection des meilleurs exercices pour améliorer votre force et votre endurance.</p><p>Les exercices de musculation comme le développé couché, le soulevé de terre et les tractions sont essentiels pour développer les muscles du haut du corps. Les squats et les fentes sont excellents pour renforcer les jambes et les fessiers.</p>'],
        [5, 'Les bienfaits du vélo', '<h1>Les bienfaits du vélo</h1><p>Le vélo est une activité physique excellente pour améliorer votre condition physique et votre santé mentale. Il renforce les muscles des jambes, améliore l\'endurance cardiovasculaire et réduit le stress. Dans cet article, nous explorons les nombreux bienfaits du vélo.</p><p>Le vélo est également un moyen de transport écologique qui permet de réduire votre empreinte carbone. Il offre une grande flexibilité et peut être pratiqué en ville comme à la campagne.</p>'],
        [6, 'Les tendances de la décoration intérieure en 2025', '<h1>Les tendances de la décoration intérieure en 2025</h1><p>En 2025, la décoration intérieure est marquée par des tendances innovantes et durables. Les designers mettent l\'accent sur des matériaux écologiques et des designs intemporels. Dans cet article, nous explorons les tendances clés de la décoration intérieure pour 2025.</p><p>Les meubles modulables et les espaces multifonctionnels sont à la pointe de la décoration intérieure. Les couleurs neutres et les matériaux naturels comme le bois et le lin sont également très prisés.</p>'],
        [7, 'Les meilleurs exercices de cardio', '<h1>Les meilleurs exercices de cardio</h1><p>Pour améliorer votre endurance cardiovasculaire, il est important de pratiquer régulièrement des exercices de cardio. Voici une sélection des meilleurs exercices pour améliorer votre condition physique.</p><p>La course à pied, le vélo et la natation sont d\'excellents exercices de cardio qui améliorent l\'endurance et brûlent les calories. Les cours de fitness en groupe comme le Zumba et le spinning sont également très populaires.</p>'],
        [8, 'Les bienfaits de la marche', '<h1>Les bienfaits de la marche</h1><p>La marche est une activité physique simple mais très bénéfique pour la santé. Elle améliore la circulation sanguine, renforce les muscles des jambes et réduit le stress. Dans cet article, nous explorons les nombreux bienfaits de la marche.</p><p>La marche est également un excellent moyen de découvrir de nouveaux paysages et de se reconnecter avec la nature. Elle peut être pratiquée à tout âge et ne nécessite pas d\'équipement particulier.</p>'],
        [9, 'Les tendances de la mode masculine en 2025', '<h1>Les tendances de la mode masculine en 2025</h1><p>En 2025, la mode masculine est marquée par des tendances innovantes et durables. Les créateurs mettent l\'accent sur des matériaux écologiques et des designs intemporels. Dans cet article, nous explorons les tendances clés de la mode masculine pour 2025.</p><p>Les vêtements intelligents, intégrant des technologies comme les capteurs et les matériaux thermorégulants, sont à la pointe de la mode. Les couleurs vives et les motifs audacieux sont également en vogue, reflétant un désir de créativité et d\'expression personnelle.</p>'],
        [10, 'Les meilleurs exercices de yoga pour débutants', '<h1>Les meilleurs exercices de yoga pour débutants</h1><p>Si vous débutez dans la pratique du yoga, il est important de commencer par des exercices simples et accessibles. Voici une sélection des meilleurs exercices de yoga pour débutants.</p><p>La posture de la montagne, la posture de l\'enfant et la posture du guerrier sont des exercices de base qui améliorent la flexibilité et renforcent les muscles. La respiration consciente est également essentielle pour se détendre et se concentrer.</p>'],
        [3, 'Les bienfaits de la natation', '<h1>Les bienfaits de la natation</h1><p>La natation est une activité physique excellente pour améliorer votre condition physique et votre santé mentale. Elle renforce les muscles du corps entier, améliore l\'endurance cardiovasculaire et réduit le stress. Dans cet article, nous explorons les nombreux bienfaits de la natation.</p><p>La natation est également un excellent moyen de se détendre et de se relaxer. Elle peut être pratiquée à tout âge et ne nécessite pas d\'équipement particulier.</p>'],
        [1, 'Les tendances du marché de l\'art en 2025', '<h1>Les tendances du marché de l\'art en 2025</h1><p>En 2025, le marché de l\'art est marqué par des tendances innovantes et durables. Les artistes mettent l\'accent sur des matériaux écologiques et des designs intemporels. Dans cet article, nous explorons les tendances clés du marché de l\'art pour 2025.</p><p>L\'art numérique et les NFT sont à la pointe du marché de l\'art. Les œuvres d\'art interactives et les installations immersives sont également très prisées.</p>'],
        [2, 'Les meilleurs exercices de Pilates', '<h1>Les meilleurs exercices de Pilates</h1><p>Le Pilates est une méthode d\'entraînement qui améliore la force, la flexibilité et l\'équilibre. Voici une sélection des meilleurs exercices de Pilates pour améliorer votre condition physique.</p><p>Les exercices de Pilates comme le "Hundred", le "Roll-Up" et le "Single Leg Circle" sont essentiels pour renforcer le centre du corps et améliorer la posture. La respiration consciente est également essentielle pour se détendre et se concentrer.</p>'],
        [4, 'Les bienfaits de la course à pied', '<h1>Les bienfaits de la course à pied</h1><p>La course à pied est une activité physique excellente pour améliorer votre condition physique et votre santé mentale. Elle renforce les muscles des jambes, améliore l\'endurance cardiovasculaire et réduit le stress. Dans cet article, nous explorons les nombreux bienfaits de la course à pied.</p><p>La course à pied est également un excellent moyen de découvrir de nouveaux paysages et de se reconnecter avec la nature. Elle peut être pratiquée à tout âge et ne nécessite pas d\'équipement particulier.</p>'],
        [5, 'Les tendances de la mode féminine en 2025', '<h1>Les tendances de la mode féminine en 2025</h1><p>En 2025, la mode féminine est marquée par des tendances innovantes et durables. Les créateurs mettent l\'accent sur des matériaux écologiques et des designs intemporels. Dans cet article, nous explorons les tendances clés de la mode féminine pour 2025.</p><p>Les vêtements intelligents, intégrant des technologies comme les capteurs et les matériaux thermorégulants, sont à la pointe de la mode. Les couleurs vives et les motifs audacieux sont également en vogue, reflétant un désir de créativité et d\'expression personnelle.</p>'],
        [6, 'Les meilleurs exercices de stretching', '<h1>Les meilleurs exercices de stretching</h1><p>Le stretching est essentiel pour améliorer la flexibilité et prévenir les blessures. Voici une sélection des meilleurs exercices de stretching pour améliorer votre condition physique.</p><p>Les étirements des jambes, des bras et du dos sont essentiels pour améliorer la flexibilité et réduire les tensions musculaires. Le stretching dynamique est également très bénéfique pour préparer les muscles à l\'effort.</p>'],
        [7, 'Les bienfaits du Tai Chi', '<h1>Les bienfaits du Tai Chi</h1><p>Le Tai Chi est une pratique ancestrale qui offre de nombreux bienfaits pour le corps et l\'esprit. Il améliore l\'équilibre, la coordination et réduit le stress. Dans cet article, nous explorons les nombreux bienfaits du Tai Chi.</p><p>Le Tai Chi est également un excellent moyen de se détendre et de se relaxer. Il peut être pratiqué à tout âge et ne nécessite pas d\'équipement particulier.</p>']
    ];

    $stmt = $pdo->prepare("INSERT INTO posts (title, content, authors_id) VALUES (?, ?, ?)");
    foreach ($posts as $post) {
        $stmt->execute([$post[1], $post[2], $post[0]]);
    }
}

// Fonction pour insérer des relations entre les posts et les catégories
function insertPostsCategories($pdo) {
    $postsCategories = [
        [1, 4], // Les meilleures destinations de voyage en Europe -> Voyage
        [2, 5], // Recette de la tarte aux pommes -> Cuisine
        [3, 7], // Comment investir en bourse ? -> Finance
        [4, 26], // Les meilleurs exercices de fitness -> Fitness
        [5, 19], // Les dernières innovations en matière de smartphones -> High-Tech
        [6, 21], // Conseils pour bien dormir -> Bien-être
        [7, 30], // Les meilleurs films de 2025 -> Cinéma
        [8, 21], // Les bienfaits de la méditation -> Bien-être
        [9, 14], // Les avantages du télétravail -> Business
        [10, 18], // Les tendances du marché immobilier en 2025 -> Immobilier
        [11, 26], // Les meilleurs exercices de musculation -> Fitness
        [12, 26], // Les bienfaits du vélo -> Fitness
        [13, 23], // Les tendances de la décoration intérieure en 2025 -> Décoration
        [14, 26], // Les meilleurs exercices de cardio -> Fitness
        [15, 21], // Les bienfaits de la marche -> Bien-être
        [16, 8], // Les tendances de la mode masculine en 2025 -> Mode
        [17, 26], // Les meilleurs exercices de yoga pour débutants -> Fitness
        [18, 21], // Les bienfaits de la natation -> Bien-être
        [19, 13], // Les tendances du marché de l'art en 2025 -> Art
        [20, 26], // Les meilleurs exercices de Pilates -> Fitness
        [21, 21], // Les bienfaits de la course à pied -> Bien-être
        [22, 8], // Les tendances de la mode féminine en 2025 -> Mode
        [23, 26], // Les meilleurs exercices de stretching -> Fitness
        [24, 21]  // Les bienfaits du Tai Chi -> Bien-être
    ];

    $stmt = $pdo->prepare("INSERT INTO posts_categories (posts_id, categories_id) VALUES (?, ?)");
    foreach ($postsCategories as $relation) {
        $stmt->execute($relation);
    }
}

// Fonction pour insérer des commentaires
function insertComments($pdo) {
    $comments = [
        [1, 'Super article sur les destinations de voyage en Europe ! Merci pour ces recommandations.'],
        [1, 'J\'ai toujours rêvé de visiter Paris, vos conseils sont très utiles.'],
        [1, 'Les fjords de Norvège sont magnifiques, merci pour l\'info !'],
        [1, 'Je vais planifier mon prochain voyage grâce à vos conseils.'],
        [1, 'Excellent guide, très complet et bien expliqué.'],
        [1, 'Merci pour ces informations précieuses sur les voyages en Europe.'],
    
        [2, 'La recette de la tarte aux pommes est délicieuse ! Merci pour cette recette simple et rapide.'],
        [2, 'J\'adore les desserts faits maison, merci pour cette recette.'],
        [2, 'La tarte aux pommes est un classique indémodable, merci pour cette recette !'],
        [2, 'Super recette ! Je vais essayer de la faire ce week-end.'],
        [2, 'Merci pour cette recette de tarte aux pommes, mes enfants vont adorer !'],
        [2, 'La tarte est parfaite pour les goûters en famille, merci !'],
    
        [3, 'Excellents conseils pour investir en bourse. Merci pour cet article complet.'],
        [3, 'Investir en bourse peut être risqué, mais vos conseils sont très utiles. Merci !'],
        [3, 'Merci pour ces conseils d\'investissement, je vais diversifier mon portefeuille comme vous le recommandez.'],
        [3, 'Super article sur l\'investissement en bourse !'],
        [3, 'Merci pour ces explications claires sur l\'investissement en bourse.'],
        [3, 'Je vais suivre vos conseils pour mieux gérer mes investissements.'],
    
        [4, 'Merci pour ces exercices de fitness, je vais les intégrer à ma routine quotidienne.'],
        [4, 'Les squats et les pompes sont vraiment efficaces, merci pour ces conseils !'],
        [4, 'J\'aimerais varier mes exercices de fitness, merci pour ces idées !'],
        [4, 'Super article sur les exercices de fitness !'],
        [4, 'Merci pour ces conseils pour rester en forme.'],
        [4, 'Je vais essayer ces exercices pour améliorer ma condition physique.'],
    
        [5, 'Les innovations des smartphones sont incroyables ! Merci pour cet article.'],
        [5, 'J\'adore les écrans pliables, merci pour ces informations sur les dernières tendances des smartphones.'],
        [5, 'Les caméras des smartphones sont de plus en plus performantes, merci pour cet article !'],
        [5, 'Super article sur les innovations des smartphones !'],
        [5, 'Merci pour ces explications sur les batteries à charge rapide.'],
        [5, 'Je vais suivre vos conseils pour choisir mon prochain smartphone.'],
    
        [6, 'Merci pour ces conseils pour bien dormir, je vais essayer de suivre votre routine.'],
        [6, 'Un bon sommeil est essentiel pour la santé, merci pour cet article !'],
        [6, 'J\'aimerais améliorer la qualité de mon sommeil, merci pour ces conseils !'],
        [6, 'Super article sur les conseils pour bien dormir !'],
        [6, 'Merci pour ces explications sur l\'importance d\'un bon sommeil.'],
        [6, 'Je vais essayer de réduire mon temps d\'écran avant de dormir.'],
    
        [7, 'Super sélection de films pour 2025 ! Merci pour cet article.'],
        [7, 'J\'ai adoré "Voyage vers les étoiles", merci pour cette recommandation !'],
        [7, 'Les films de 2025 sont incroyables, merci pour cette sélection !'],
        [7, 'Super article sur les meilleurs films de 2025 !'],
        [7, 'Merci pour ces recommandations de films, je vais regarder "L\'énigme du temps" ce soir.'],
        [7, 'Je vais suivre vos conseils pour découvrir de nouveaux films.'],
    
        [8, 'Merci pour cet article sur les bienfaits de la méditation, je vais essayer le Hatha yoga dès demain !'],
        [8, 'La méditation a vraiment changé ma vie, merci pour cet article inspirant.'],
        [8, 'Je ne savais pas qu\'il existait autant de types de méditation, merci pour ces informations !'],
        [8, 'Super article ! J\'aimerais en savoir plus sur la méditation Bikram.'],
        [8, 'Merci pour ces explications claires sur les bienfaits de la méditation.'],
        [8, 'Je vais intégrer la méditation dans ma routine quotidienne.'],
    
        [9, 'Merci pour cet article sur les avantages du télétravail, très instructif !'],
        [9, 'Le télétravail a vraiment changé ma vie, merci pour ces conseils !'],
        [9, 'Je ne connaissais pas tous ces avantages du télétravail, merci pour cet article.'],
        [9, 'Super article sur les avantages du télétravail !'],
        [9, 'Merci pour ces conseils pour mieux gérer le télétravail.'],
        [9, 'Je vais suivre vos recommandations pour améliorer mon expérience de télétravail.'],
    
        [10, 'Merci pour cet article sur les tendances du marché immobilier en 2025, très intéressant !'],
        [10, 'Les maisons intelligentes sont l\'avenir, merci pour ces informations !'],
        [10, 'Je vais suivre vos conseils pour investir dans l\'immobilier, merci !'],
        [10, 'Super article sur les tendances du marché immobilier en 2025 !'],
        [10, 'Merci pour ces explications claires sur les innovations immobilières.'],
        [10, 'Je vais m\'informer davantage sur les maisons écologiques.'],
    
        [11, 'Merci pour ces exercices de musculation, je vais les ajouter à ma routine !'],
        [11, 'Les exercices de musculation sont essentiels pour développer la masse musculaire, merci pour ces conseils !'],
        [11, 'Super article sur les exercices de musculation !'],
        [11, 'Merci pour ces explications claires sur les exercices de musculation.'],
        [11, 'Je vais essayer ces exercices pour améliorer ma force.'],
        [11, 'Merci pour ces conseils pour développer mes muscles.'],
    
        [12, 'Merci pour cet article sur les bienfaits du vélo, je vais m\'y mettre !'],
        [12, 'Le vélo est excellent pour la santé, merci pour ces conseils !'],
        [12, 'Je ne savais pas que le vélo avait autant de bienfaits, merci pour cet article.'],
        [12, 'Super article sur les bienfaits du vélo !'],
        [12, 'Merci pour ces explications claires sur les avantages du vélo.'],
        [12, 'Je vais essayer de faire du vélo plus régulièrement.'],
    
        [13, 'Merci pour cet article sur les tendances de la décoration intérieure en 2025, très inspirant !'],
        [13, 'Les meubles modulables sont une excellente idée, merci pour ces conseils !'],
        [13, 'Je vais redécorer mon intérieur grâce à vos conseils, merci !'],
        [13, 'Super article sur les tendances de la décoration intérieure en 2025 !'],
        [13, 'Merci pour ces explications claires sur les innovations en décoration.'],
        [13, 'Je vais suivre vos recommandations pour moderniser mon intérieur.'],
    
        [14, 'Merci pour ces exercices de cardio, je vais les intégrer à ma routine !'],
        [14, 'La course à pied et le vélo sont excellents pour la santé, merci pour ces conseils !'],
        [14, 'Je vais essayer le Zumba grâce à vos conseils, merci !'],
        [14, 'Super article sur les exercices de cardio !'],
        [14, 'Merci pour ces explications claires sur les bienfaits du cardio.'],
        [14, 'Je vais essayer de faire plus de cardio pour améliorer mon endurance.'],
    
        [15, 'Merci pour cet article sur les bienfaits de la marche, je vais m\'y mettre !'],
        [15, 'La marche est excellente pour la santé, merci pour ces conseils !'],
        [15, 'Je ne savais pas que la marche avait autant de bienfaits, merci pour cet article.'],
        [15, 'Super article sur les bienfaits de la marche !'],
        [15, 'Merci pour ces explications claires sur les avantages de la marche.'],
        [15, 'Je vais essayer de marcher plus régulièrement.'],
    
        [16, 'Merci pour cet article sur les tendances de la mode masculine en 2025, très intéressant !'],
        [16, 'Les vêtements intelligents sont l\'avenir, merci pour ces informations !'],
        [16, 'Je vais suivre vos conseils pour renouveler ma garde-robe, merci !'],
        [16, 'Super article sur les tendances de la mode masculine en 2025 !'],
        [16, 'Merci pour ces explications claires sur les innovations en mode masculine.'],
        [16, 'Je vais m\'informer davantage sur les vêtements écologiques.'],
    
        [17, 'Merci pour ces exercices de yoga pour débutants, je vais essayer !'],
        [17, 'Le yoga est excellent pour la santé, merci pour ces conseils !'],
        [17, 'Je ne savais pas que le yoga avait autant de bienfaits, merci pour cet article.'],
        [17, 'Super article sur les exercices de yoga pour débutants !'],
        [17, 'Merci pour ces explications claires sur les bienfaits du yoga.'],
        [17, 'Je vais essayer de faire du yoga régulièrement.'],
    
        [18, 'Merci pour cet article sur les bienfaits de la natation, je vais m\'y mettre !'],
        [18, 'La natation est excellente pour la santé, merci pour ces conseils !'],
        [18, 'Je ne savais pas que la natation avait autant de bienfaits, merci pour cet article.'],
        [18, 'Super article sur les bienfaits de la natation !'],
        [18, 'Merci pour ces explications claires sur les avantages de la natation.'],
        [18, 'Je vais essayer de nager plus régulièrement.'],
    
        [19, 'Merci pour cet article sur les tendances du marché de l\'art en 2025, très intéressant !'],
        [19, 'L\'art numérique est l\'avenir, merci pour ces informations !'],
        [19, 'Je vais suivre vos conseils pour investir dans l\'art, merci !'],
        [19, 'Super article sur les tendances du marché de l\'art en 2025 !'],
        [19, 'Merci pour ces explications claires sur les innovations en art.'],
        [19, 'Je vais m\'informer davantage sur les NFT.'],
    
        [20, 'Merci pour ces exercices de Pilates, je vais les intégrer à ma routine !'],
        [20, 'Le Pilates est excellent pour la santé, merci pour ces conseils !'],
        [20, 'Je ne savais pas que le Pilates avait autant de bienfaits, merci pour cet article.'],
        [20, 'Super article sur les exercices de Pilates !'],
        [20, 'Merci pour ces explications claires sur les bienfaits du Pilates.'],
        [20, 'Je vais essayer de faire du Pilates régulièrement.'],
    
        [21, 'Merci pour cet article sur les bienfaits de la course à pied, je vais m\'y mettre !'],
        [21, 'La course à pied est excellente pour la santé, merci pour ces conseils !'],
        [21, 'Je ne savais pas que la course à pied avait autant de bienfaits, merci pour cet article.'],
        [21, 'Super article sur les bienfaits de la course à pied !'],
        [21, 'Merci pour ces explications claires sur les avantages de la course à pied.'],
        [21, 'Je vais essayer de courir plus régulièrement.'],
    
        [22, 'Merci pour cet article sur les tendances de la mode féminine en 2025, très intéressant !'],
        [22, 'Les vêtements intelligents sont l\'avenir, merci pour ces informations !'],
        [22, 'Je vais suivre vos conseils pour renouveler ma garde-robe, merci !'],
        [22, 'Super article sur les tendances de la mode féminine en 2025 !'],
        [22, 'Merci pour ces explications claires sur les innovations en mode féminine.'],
        [22, 'Je vais m\'informer davantage sur les vêtements écologiques.'],
    
        [23, 'Merci pour ces exercices de stretching, je vais les intégrer à ma routine !'],
        [23, 'Le stretching est excellent pour la santé, merci pour ces conseils !'],
        [23, 'Je ne savais pas que le stretching avait autant de bienfaits, merci pour cet article.'],
        [23, 'Super article sur les exercices de stretching !'],
        [23, 'Merci pour ces explications claires sur les bienfaits du stretching.'],
        [23, 'Je vais essayer de faire du stretching plus régulièrement.'],
    
        [24, 'Merci pour cet article sur les bienfaits du Tai Chi, je vais essayer !'],
        [24, 'Le Tai Chi est excellent pour la santé, merci pour ces conseils !'],
        [24, 'Je ne savais pas que le Tai Chi avait autant de bienfaits, merci pour cet article.'],
        [24, 'Super article sur les bienfaits du Tai Chi !'],
        [24, 'Merci pour ces explications claires sur les avantages du Tai Chi.'],
        [24, 'Je vais essayer de pratiquer le Tai Chi régulièrement.']
    ];
    $stmt = $pdo->prepare("INSERT INTO comments (content, posts_id) VALUES (?, ?)");
    foreach ($comments as $comment) {
        $stmt->execute([$comment[1], $comment[0]]);
    }
}

// Initialisation de la base de données
createTables($pdo);
insertAuthors($pdo);
insertCategories($pdo);
insertPosts($pdo);
insertPostsCategories($pdo);
insertComments($pdo);

echo "Base de données initialisée avec succès !";
