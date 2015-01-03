<?php 

if (isset($_GET["quoi"]) && $_GET["quoi"] != ''){
    $quoi = $_GET["quoi"];

    $retour = '';

    // Données nécessaires à la connexion à la BDD
    $host = "mysql.imerir.com"; // serveur mysql
    $db = "seen";       // nom de la BDD
    $user = "seen";       // login de l'utilisateur de la BDD
    $pass = "dzMbzFHmyS5bQV9V"; // mot de passe de l'utilisateur de la BDD

    switch ($quoi){
      case "f" : if (isset($_GET["titre_f"])){
                      
                  }else{
                    header("HTTP/1.0 400 Bad Request");
                  };
      break;

      case "s" : if (isset($_GET["id_bs"]) && $_GET["id_bs"] != ''){

                    $req = new PDO('mysql:host='.$host.';dbname='.$db, $user, $pass); // accès à la base de données
                    $retour = $req->exec('REPLACE INTO serie (id_bs_s, titre_s, synopsis_s, date_debut_s, langue_s, statut_s) VALUES ('.$_GET["id_bs"].', "Mary of Scotland", "1936", 2015, "Anglais", "finalement on sait");');

                    //$retour = $req->exec('REPLACE INTO serie (id_s, titre_s, synopsis_s, date_debut_s, langue_s, statut_s) VALUES ('.$_GET["id_bs"].', "Mary of Scotland", "1936", 2015, "Anglais", "finalement on sait");');

                      
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
 
function retourFilm(){// formatage du JSON pour le client

}

function retourSerie(){// formatage du JSON pour le client
 
}

function retourMembre($data){ // formatage du JSON pour le client
  if ($data == 1){
    header("HTTP/1.0 200 OK");
  }else{
    header("HTTP/1.0 500 Internal Server Error");
  }
}
?>































