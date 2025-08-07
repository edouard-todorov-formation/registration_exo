<?php
    require_once "../config/database.php";
    //var_dump(dbConnexion());
    $errors = [];
    // =========================================
    // condition qui contient la logique de traitement du formulaire quand on recoit une request POST
    // ==========================================
    if ($_SERVER["REQUEST_METHOD"] === "POST"){
        //recuperation des données d'un formulaire
        //nettoyage des données du formulaire
        $username = htmlspecialchars(trim($_POST["username"]));
        $email = htmlspecialchars(trim($_POST["email"]));
        $password = $_POST["password"];
        $confirmPassword = $_POST["confirmPassword"];

//validation des données************************************
    //validation username
    //valide que le champ soit remplis
    if (empty($username)) {
        $errors[]="nom obligatoire";
    //valide avec la function strlen si la string est de plus de 3 carac
    }elseif (strlen($username) < 3) {
        $errors[] = "mini 3 carac";
    //valide avec la function strlen si la string est de moins de 55 carac
    }elseif (strlen($username) > 55) {
        $errors[] = "max 55 carac";
    }
   
    //validation email
    if (empty($email)) {
        $errors[] = "email obligatoire ! ( connard )";
    //function filter_var(cible du traitement ex:$email, filtre ex:FILTER_VALIDATE_MAIL ou FILTER_VALIDATE_URL ou FILTER_VALIDATE_INT ou FILTER_VALIDATE_BOOLEAN...)
    }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors[] = "votre adresse ne correspond au format mail classique";
    }
        

    
    if (empty($errors)) {
        //logique de traitement en db
        $pdo = dbConnexion();

        //verifier si l'adresse mail est utilisé ou non
        $checkEmail = $pdo->prepare("SELECT id FROM users WHERE email = ?");

        //la methode execute de mon objet pdo execute la request préparée
        $checkEmail->execute([$email]);

        //une condition pour vérifier si je recupere quelque chose
        if ($checkEmail->rowCount() > 0) {
            $errors[] = "email déja utilisé";
        } else {
            //dans le cas ou tout va bien ! email pas utilisé

            //hashage du mdp avec la fonction password_hash
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);

            //insertion des données en db
            // INSERT INTO users (username, email, password)VALUES ("atif","atif@gmail.com","lijezfoifjerlkjf")
            $insertUser = $pdo->prepare("
            INSERT INTO users (nom, email, password) 
            VALUES (?, ?, ?)
            ");

            $insertUser->execute([$username, $email, $hashPassword]);

            $message = "super mega cool vous êtes enregistré $username";
        }
        // try {
            
        // } catch () {
            
        // }
        }

        
    }
?>

<!--------------------------------------------------------------------------------------------
------------------  HTML SECTION -------------------------------------------------------------
--------------------------------------------------------------------------------------------->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/style/style.css">
</head>
<body>
<!---------------  FORM SECTION ------------------------------------------------------------>
    <section class="main-container">
        <form action="" method="POST">
            <?php
                foreach ($errors as $error) {
                    echo $error;
                }
            ?>
            <input type="text" name="username" id="username" placeholder="Username" required>
            <input type="email" name="email" id="email" placeholder="Email" required>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password" required>
            <input type="submit" value="Send">
        </form>
    </section>
</body>
</html>