<?php 
session_start();
if (isset($_GET["quoi"]) && $_GET["quoi"] != ''){
    $quoi = $_GET["quoi"];

    $retour = '';

    // Données nécessaires à la connexion à la BDD
    $host = "mysql.imerir.com"; // serveur mysql
    $db = "seen";       // nom de la BDD
    $user = "seen";       // login de l'utilisateur de la BDD
    $pass = "dzMbzFHmyS5bQV9V"; // mot de passe de l'utilisateur de la BDD

    switch ($quoi){
      case "f" : if (isset($_GET["id_bs"]) && $_GET["id_bs"] != '' && isset($_GET["titre_f"]) && $_GET["titre_f"] != '' && isset($_GET["titre_original"]) && $_GET["titre_original"] != '' && isset($_GET["synopsis"]) && $_GET["synopsis"] != '' && isset($_GET["realisateur"]) && $_GET["realisateur"] != '' && isset($_GET["date_sortie"]) && $_GET["date_sortie"] != '' && isset($_GET["duree"]) && $_GET["duree"] != '' && isset($_GET["langue"]) && $_GET["langue"] != ''){

                    $req = new PDO('mysql:host='.$host.';dbname='.$db, $user, $pass); // accès à la base de données
                    $retour = $req->exec('INSERT IGNORE film (
                                              id_bs_f ,
                                              titre_f ,
                                              titre_original_f ,
                                              date_sortie_f ,
                                              duree_f ,
                                              synopsis_f ,
                                              langue_f ,
                                              realisateur_f
                                              )VALUES(
                                              '.$_GET["id_bs"].', 
                                              "'.str_replace("\"", "\\\"", $_GET["titre_f"]).'", 
                                              "'.str_replace("\"", "\\\"", $_GET["titre_original"]).'", 
                                              \''.$_GET["date_sortie"].'\', 
                                              '.$_GET["duree"].', 
                                              "'.$_GET["synopsis"].'", 
                                              "'.$_GET["langue"].'", 
                                              "'.$_GET["realisateur"].'");');

                    $id = $req->query('SELECT id_f FROM film WHERE id_bs_f = '.$_GET["id_bs"].';');
                    $id = $id->fetchAll();

                    $retour = $req->exec('INSERT IGNORE film_membre (id_f, id_m, ajoute_fm) VALUES ('.$id[0]["id_f"].', '.$_SESSION["id"].', 1);');

                    retourFilm($retour);
                  }else{
                    header("HTTP/1.0 400 Bad Request");
                  };
      break;

      case "s" : if (isset($_GET["id_bs"]) && $_GET["id_bs"] != '' && isset($_GET["titre_s"]) && $_GET["titre_s"] != '' && isset($_GET["date_debut"]) && $_GET["date_debut"] != '' && isset($_GET["langue"]) && $_GET["langue"] != '' && isset($_GET["statut"]) && $_GET["statut"] != '' && isset($_GET["synopsis"]) && $_GET["synopsis"] != '' && isset($_GET["nb_saison"]) && $_GET["nb_saison"] != '' && isset($_GET["nb_episode"]) && $_GET["nb_episode"] != '' ){

                    $req = new PDO('mysql:host='.$host.';dbname='.$db, $user, $pass); // accès à la base de données
                    $retour = $req->exec('INSERT IGNORE serie (
                                            id_bs_s, 
                                            titre_s, 
                                            synopsis_s, 
                                            date_debut_s, 
                                            nb_saison, 
                                            nb_episode, 
                                            langue_s, 
                                            statut_s
                                          )VALUES(
                                            '.$_GET["id_bs"].',
                                            "'.str_replace("\"", "\\\"", $_GET["titre_s"]).'",
                                            "'.str_replace("\"", "\\\"", $_GET["synopsis"]).'",
                                            '.$_GET["date_debut"].',
                                            '.$_GET["nb_saison"].',
                                            '.$_GET["nb_episode"].',
                                            "'.$_GET["langue"].'",
                                            "'.$_GET["statut"].'");');

                    $id = $req->query('SELECT id_s FROM serie WHERE id_bs_s = '.$_GET["id_bs"].';');
                    $id = $id->fetchAll();

                    $retour = $req->exec('INSERT IGNORE serie_membre (id_s, id_m, ajoute_sm) VALUES ('.$id[0]["id_s"].', '.$_SESSION["id"].', 1);');

                    retourSerie($retour); 
                  }else{
                    header("HTTP/1.0 400 Bad Request");
                  };
      break;

      case "m" : if (isset($_GET["nom"]) && $_GET["nom"] != '' && isset($_GET["prenom"]) && $_GET["prenom"] != '' && isset($_GET["mail"]) && $_GET["mail"] != '' && isset($_GET["pseudo"]) && $_GET["pseudo"] != '' && isset($_GET["mdp"]) && $_GET["mdp"] != ''){
                     $req = new PDO('mysql:host='.$host.';dbname='.$db, $user, $pass); // accès à la base de données
                     $retour = $req->exec('INSERT INTO membre (id_mbr, nom_mbr, prenom_mbr, pseudo_mbr, mdp_mbr, mail_mbr) VALUES (NULL,\''.$_GET["nom"].'\',\''.$_GET["prenom"].'\',\''.$_GET["pseudo"].'\',\''.md5($_GET["mdp"]).'\',\''.$_GET["mail"].'\');');
                     retourMembre($retour);
                  }else{
                    header("HTTP/1.0 400 Bad Request");
                  };
      break;
    }
}else{
  header("HTTP/1.0 400 Bad Request");
}
 
function retourFilm($data){// formatage du JSON pour le client
header("HTTP/1.0 200 OK");

if ($data == 1){
    echo '{"code":"1"}';
  }else{
    echo '{"code":"0"}';
  }
}

function retourSerie($data){// formatage du JSON pour le client
 header("HTTP/1.0 200 OK");

if ($data == 1){
    echo '{"code":"1"}';
  }else{
    echo '{"code":"0"}';
  }
}

function retourMembre($data){ // formatage du JSON pour le client
  header("HTTP/1.0 200 OK");

if ($data == 1){
    echo '{"code":"1"}';
  }else{
    echo '{"code":"0"}';
  }
}
?>