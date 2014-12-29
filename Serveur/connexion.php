<?php 
$host = "mysql.imerir.com";	// serveur mysql
$db = "seen";				// nom de la BDD
$user = "seen";				// login de l'utilisateur de la BDD
$pass = "dzMbzFHmyS5bQV9V";	// mot de passe de l'utilisateur de la BDD

if (isset($_GET["pseudo"]) && isset($_GET["mdp"])){

  $dbh = new PDO('mysql:host='.$host.';dbname='.$db, $user, $pass); // accès à la base de données
  $retour = $dbh->query('SELECT mdp_mbr FROM membre WHERE pseudo_mbr = \''.$_GET["pseudo"].'\';');
  $res = $retour->fetchAll();

  if ( $res[0]["mdp_mbr"] == md5($_GET["mdp"]) ){
    header("HTTP/1.0 200 OK");
    echo "1";
  }else{
    header("HTTP/1.0 200 OK");
    echo "0";
  }

}else{
  header("HTTP/1.0 400 Bad Request");
}
?>