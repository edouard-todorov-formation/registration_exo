<?php 

// logique de connexion a la database

//information pour se connecter
//l'endroit ou est ma database
$host = "localhost";
//le nom de la db
$dbname = "users";
//identifiant de connexion
$username = "root";
//mdp de connexion
$password = "";
//port
$port = 3306;
//encodage
$charset = "utf8mb4";

//fonction qui crée et renvoi une connexion a la db
function dbConnexion() {
    //transforme mes variable en global (accessible partout)
    global $host, $dbname, $password, $username, $port, $charset;

    try {
        //mes param de co
        $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset;port=$port";
        //fait mon object de co
        $pdo = new PDO($dsn, $username, $password);
        //comment recuperer les exception (erreurs)
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //comment me renvoyer les données
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $pdo;

    } catch (PDOException $e) {
        die("erreur durant la co a la bd: " . $e->getMessage());
   
    }
}
//dbConnexion();// lancement de la fonction de connection pour test
?>