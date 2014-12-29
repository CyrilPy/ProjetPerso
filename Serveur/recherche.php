<?php 

if (isset($_GET["quoi"]) && $_GET["quoi"] != '' &&  !is_null($_GET["quoi"])){
  $quoi = $_GET["quoi"];
  $retour = '';
    // Création d'un flux pour connexion à BetaSeries
  $opts = array(
    'http'=>array(
      'method'=>"GET",
      'header'=>"X-BetaSeries-Key: 4efa6075b15d\r\n".
                "X-BetaSeries-Version: 2.3\r\n".
                "Accept: application/json\r\n".
                "User-agent: Seen\r\n"
    )
  );
  // Données nécessaires à la connexion à la BDD
  $host = "mysql.imerir.com"; // serveur mysql
  $db = "seen";       // nom de la BDD
  $user = "seen";       // login de l'utilisateur de la BDD
  $pass = "dzMbzFHmyS5bQV9V"; // mot de passe de l'utilisateur de la BDD
  $context = stream_context_create($opts);

  switch ($quoi){
    case "f" : if (isset($_GET["titre"]) && $_GET["titre"] != ''){
                  $retour = file_get_contents('http://api.betaseries.com/movies/search?title='.str_replace(" ", "+", $_GET["titre"]), false, $context);
                  retourFilm($retour);
                }else{
                  header("HTTP/1.0 400 Bad Request");
                };
    break;
    case "s" : if (isset($_GET["titre"]) && $_GET["titre"] != ''){
                  $retour = file_get_contents('http://api.betaseries.com/shows/search?title='.str_replace(" ", "+", $_GET["titre"]), false, $context);
                  retourSerie($retour);
                }else{
                  header("HTTP/1.0 400 Bad Request");
                };
    break;
    case "m" : if (isset($_GET["pseudo"]) && $_GET["pseudo"] != ''){
                    try{
                      $req = new PDO('mysql:host='.$host.';dbname='.$db, $user, $pass); // accès à la base de données
                      $retour = $req->query('SELECT * FROM membre WHERE pseudo_mbr = "'.$_GET["pseudo"].'"'); // requete sur la base de données

                      retourMembre($retour);
                    }catch (PDOException $e) {
                        print "Erreur !: " . $e->getMessage() . "<br/>";
                        die();
                    }
                    
                }else{
                  header("HTTP/1.0 400 Bad Request");
                };
    break;
  }
}else{
  header("HTTP/1.0 400 Bad Request");
}
 
function retourFilm($data){// formatage du JSON pour le client
  $json = json_decode($data);

  $jsonClient = '{"film":[';
  for ($i = 0; $i < count($json->{'movies'}); $i++){
      if ($i != 0){
        $jsonClient .= ',';
      }
      $jsonClient .= '{';
      $jsonClient .= '"id_bs_f":"'.$json->{'movies'}[$i]->{'id'}.'",';
      $jsonClient .= '"titre_f":"'.str_replace('"', '\"', $json->{'movies'}[$i]->{'title'}).'",';
      $jsonClient .= '"titre_original_f":"'.str_replace('"', '\"', $json->{'movies'}[$i]->{'original_title'}).'",';
      $jsonClient .= '"date_sortie_f":"'.$json->{'movies'}[$i]->{'release_date'}.'",';
      $jsonClient .= '"duree_f":"'.$json->{'movies'}[$i]->{'length'}.'",';
      $jsonClient .= '"synopsis_f":"'.str_replace('"', '\"', $json->{'movies'}[$i]->{'synopsis'}).'",';
      $jsonClient .= '"langue_f":"'.$json->{'movies'}[$i]->{'language'}.'",';
      $jsonClient .= '"realisateur_f":"'.$json->{'movies'}[$i]->{'director'}.'"';
      $jsonClient .= '}';
  }
  $jsonClient .= ']}';

  echo $jsonClient; 
}

function retourSerie($data){// formatage du JSON pour le client
  $json = json_decode($data);

  $jsonClient = '{"serie":[';
  for ($i = 0; $i < count($json->{'shows'}); $i++){
      if ($i != 0){
        $jsonClient .= ',';
      }
      $jsonClient .= '{';
      $jsonClient .= '"id_bs_s":"'.$json->{'shows'}[$i]->{'id'}.'",';
      $jsonClient .= '"titre_s":"'.str_replace('"', '\"', $json->{'shows'}[$i]->{'title'}).'",';
      $jsonClient .= '"synopsis_s":"'.str_replace('"', '\"', $json->{'shows'}[$i]->{'description'}).'",';
      $jsonClient .= '"date_debut_s":"'.$json->{'shows'}[$i]->{'creation'}.'",';
      $jsonClient .= '"langue_s":"'.$json->{'shows'}[$i]->{'language'}.'",';
      $jsonClient .= '"statut_s":"'.$json->{'shows'}[$i]->{'status'}.'"';
      $jsonClient .= '}';
  }
  $jsonClient .= ']}';

  echo $jsonClient; 
}

function retourMembre($data){ // formatage du JSON pour le client

    $jsonClient = '{"membre":[';
    $i = 0;
    foreach($data as $row) {
        if ($i != 0){
          $jsonClient .= ',';
        }
        $jsonClient .= '{';
        $jsonClient .= '"id_mbr":"'.$row["id_mbr"].'",';
        $jsonClient .= '"nom_mbr":"'.$row["nom_mbr"].'",';
        $jsonClient .= '"prenom_mbr":"'.$row["prenom_mbr"].'",';
        $jsonClient .= '"pseudo_mbr":"'.$row["pseudo_mbr"].'",';
        $jsonClient .= '"mail_mbr":"'.$row["mail_mbr"].'"';
        $jsonClient .= '}';

        $i++;
    }
    $jsonClient .= ']}';
  
  echo $jsonClient; 
}
?>
















