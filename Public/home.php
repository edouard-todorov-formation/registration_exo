<?php 
//demarre la session
session_start();

// condition pour verifier si dans la session de l'utilisateur se trouve les infos qui nous montre qu'il est co 
if (!isset($_SESSION['loggin']) || $_SESSION['loggin'] !== true ) {
    //si il est co je le redirige grace a location, qui dans le header de ma request
    header('location: login.php');
    //je lui dis du coup d'arreter d'executer le code
    exit();
}

//condition qui me permet de verifier si en get j'ai une key logout ET si cette key contient la value 1 ( true )
if (isset($_GET['logout']) && $_GET['logout'] === '1') {
    $_SESSION = [];
    session_destroy();

    //supprime les cookie

    //si il est deco on le renvois sur la pas de logout surtout qu'il a pas le droit de rester ici 
    header('location: login.php');
    //je lui dis du coup d'arreter d'executer le code
    exit();

}

//(get) je recupere les infos stocké dans le tableau de la session du user 
$user_id = $_SESSION['user_id'] ?? 'inconnu';
$username = $_SESSION['username'] ?? 'non renseigné';
$email = $_SESSION['email'] ?? "pas d'email";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/style/style.css">
</head>
<body>
    <header>
        <h1>mon site d'auth en php</h1>
        <!-- petit message personnalisé grace aux infos stocké dans la session  -->
        <span><?= "welcom " . htmlspecialchars($username) . "sur mon site. Vous êtes co avec l'adresse mail " . htmlspecialchars($email); ?></span>
        <nav>
            <ul>
                <li>
                    <a href="home.php">home page</a>
                </li>
                <li>
                    <a href="">lien vers une page</a>
                </li>
                <li>
                    <a href="">lien vers une page</a>
                </li>
                <li>
                    <a href="home.php?logout=1">deco</a>
                </li>
            </ul>
        </nav>
    </header>
    <main>

    </main>
</body>
</html>