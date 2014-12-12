<?php 

if (isset($_GET["quoi"]) && $_GET["quoi"] != '' && $_GET["qui"]) && $_GET["qui"] != '' && $_GET["action"]) && $_GET["action"] != '')){
    $quoi = $_GET["quoi"];
    $qui = $_GET["qui"];
    $action = $_GET["action"];

    $retour = '';

    // Données nécessaires à la connexion à la BDD
    $host = "mysql.imerir.com"; // serveur mysql
    $db = "seen";       // nom de la BDD
    $user = "seen";       // login de l'utilisateur de la BDD
    $pass = "dzMbzFHmyS5bQV9V"; // mot de passe de l'utilisateur de la BDD
    $context = stream_context_create($opts);

    switch ($quoi){
      case "f" : if (isset($_GET["titre_f"])){
                      
                  }else{
                    header("HTTP/1.0 400 Bad Request");
                  };
      break;

      case "s" : if (isset($_GET["titre"]) && $_GET["titre"] != ''){
                      
                  }else{
                    header("HTTP/1.0 400 Bad Request");
                  };
      break;

      case "m" : if (isset($_GET["pseudo"]) && $_GET["pseudo"] != ''){
                     
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

function retourMembre(){ // formatage du JSON pour le client
  
}
?>