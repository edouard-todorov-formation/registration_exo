<?php
    require_once "../config/database.php";

    $errors = [];
    $message = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $email = trim(htmlspecialchars($_POST["email"]) ?? '');
        $password = $_POST["password"] ?? '';
        
        if(empty($password)) {
            $errors[] = "le mdp est obligatoire";
        }

        if(empty($password)) {
            $errors[] = "le mdp est obligatoire";
        }

        if(empty($email)) {
            $errors[] = "l'email est obligatoire";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors[] = "votre adresse ne correspond au format mail classique";
        }

        if (empty($errors)) {
            try {
                //appel de la fonction de connexion a la db
                $pdo = dbConnexion();
                //prépare une requete sql (email dynamique)
                $sql = "SELECT * FROM users WHERE email = ?";
                //stock ma request préparée 
                $requestDb = $pdo->prepare($sql);
                //"execute la request en lui passant en parametre l'element dynamique
                $requestDb->execute([$email]);
                //recupération des données
                $user = $requestDb->fetch();
                
                if ($user) {
                    //verification
                    if (password_verify($password, $user["password"])) {
                        $_SESSION["user_id"] = $user['id'];
                        $_SESSION["username"] = $user['username'];
                        $_SESSION["email"] = $user['email'];
                        $_SESSION['loggin'] = true;

                        $message = "super vous etes connecté " . htmlspecialchars($user['name']);
                        header('location: home.php');
                        exit();
                    }else{
                        $errors[] = "mot de passe pas bon ma gueule";
                    }     
                }else{
                    $errors[] = "compte introuvable ma gueule";
                }  
            } catch (PDOException $e) {
                $errors[] = "nous avons des problemes ma gueule: " . $e->getMessage();
            }
        }

        
    }

?>

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
            <input type="email" name="email" id="email" placeholder="Email" required>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <input type="submit" value="Send">
        </form>
    </section>
</body>
</html>


<?php






/***************************************************************************************************************************
 ***************************  Ma logique ************************************************************************************
 ***************************************************************************************************************************
    require_once "../config/database.php";

    $errors = [];
    $validate = [];

//recup nettoyage
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $email = htmlspecialchars(trim($_POST["email"])) ?? "";
        $password = $_POST["password"] ?? "";
    }
    //verification 
    if (empty($email)) {
        $errors[] = "Entrer un mail";
    }elseif (strlen($email) < 3) {
        $errors[] = "mdp trop court";
    }elseif (strlen($email) > 55) {
        $errors[] = "mdp trop long";
    }

    if (empty($password)){
        $errors[] = "entrer votre password";
    }elseif (strlen($password) < 3) {
        $errors[] = "mdp trop court";
    }
    
        if (empty($errors)) {
        //logique de traitement en db
        $pdo = dbConnexion();

        $passwordDb = $pdo->prepare("SELECT passwo rd FROM users WHERE password = (?)");

        $passwordDb->execute([$passwordDb]);
        var_dump($passwordDb);

        //verifier si l'adresse mail est utilisé ou non
        $checkEmail = $pdo->prepare("SELECT email FROM users WHERE email = (?)");

        //la methode execute de mon objet pdo execute la request préparée
        $checkEmail->execute([$email]);

        //une condition pour vérifier si je recupere quelque chose
        if ($checkEmail->rowCount() > 0) {
            $validate[] = "email existant";
        } else {
            $errors[] = "email pas enregistré";
        }

        // condition si il a validé le mail
        if (!empty($validate)){
            if (password_verify($password, $passwordDb)){
                $validate[] = "mdp valide";
                var_dump($password);
                var_dump($passwordDb);
            }else{
                echo $password, $passwordDb;
                $errors[] = "mdp invalide";
            }
        }

    }

*/
?>