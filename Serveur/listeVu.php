<?php 
session_start();
if (isset($_GET["quoi"]) && $_GET["quoi"] != '' && isset($_GET["nb"]) && $_GET["nb"] != ''){
    $quoi = $_GET["quoi"];
    $qui = $_SESSION["id"];
    $nb = $_GET["nb"];

    $retour = '';

    // Données nécessaires à la connexion à la BDD
    $host = "mysql.imerir.com"; // serveur mysql
    $db = "seen";       // nom de la BDD
    $user = "seen";       // login de l'utilisateur de la BDD
    $pass = "dzMbzFHmyS5bQV9V"; // mot de passe de l'utilisateur de la BDD
    $req = new PDO('mysql:host='.$host.';dbname='.$db, $user, $pass); // accès à la base de données
    
    switch ($quoi){
      case "f" :  $retour = $req->query(' SELECT titre_f, date_sortie_f, duree_f, synopsis_f, langue_f, realisateur_f, note_fm, date_fm 
                                          FROM film_membre, film 
                                          WHERE film_membre.id_f=film.id_f 
                                          AND id_m = '.$qui.' 
                                          ORDER BY date_fm DESC 
                                          LIMIT 0,'.$nb.';'); // requete sur la base de données
                  retourFilm($retour);
      break;

      case "s" :  $retour = $req->query(' SELECT titre_s, num_sn, num_e, titre_e, synopsis_e, note_em, date_em 
                                          FROM serie, saison, episode, episode_membre
                                          WHERE serie.id_s=saison.id_s 
                                          AND saison.id_sn=episode.id_sn
                                          AND episode.id_e=episode_membre.id_e
                                          AND id_m = '.$qui.' 
                                          ORDER BY date_em DESC 
                                          LIMIT '.$nb.';'); // requete sur la base de données;
                  retourSerie($retour);
      break;

      case "fs" : $film = $req->query('   SELECT titre_f, date_sortie_f, duree_f, synopsis_f, langue_f, realisateur_f, note_fm, date_fm 
                                          FROM film_membre, film 
                                          WHERE film_membre.id_f=film.id_f 
                                          AND id_m = '.$qui.' 
                                          ORDER BY date_fm DESC 
                                          LIMIT 0,'.$nb.';'); // requete sur la base de données;
                  $serie = $req->query('  SELECT titre_s, num_sn, num_e, titre_e, synopsis_e, note_em, date_em 
                                          FROM serie, saison, episode, episode_membre
                                          WHERE serie.id_s=saison.id_s 
                                          AND saison.id_sn=episode.id_sn
                                          AND episode.id_e=episode_membre.id_e
                                          AND id_m = '.$qui.' 
                                          ORDER BY date_em DESC 
                                          LIMIT '.$nb.';'); // requete sur la base de données
                  retourIndex($film, $serie);
      break;
    }
}else{
    header("HTTP/1.0 400 Bad Request");
    if (!isset($_GET["quoi"])){echo "manque: quoi";}
    if (!isset($_GET["qui"])){echo "manque: qui";}
    if (!isset($_GET["nb"])){echo "manque: nb";}
}
 
function retourFilm($data){// formatage du JSON pour le client
  $jsonClient = '{"film":[';
  $i = 0;
  foreach($data as $row) {
      if ($i != 0){
        $jsonClient .= ',';
      }
      $jsonClient .= '{';
      $jsonClient .= '"titre_f":"'.$row["titre_f"].'",';
      $jsonClient .= '"date_sortie_f":"'.$row["date_sortie_f"].'",';
      $jsonClient .= '"duree_f":"'.$row["duree_f"].'",';
      $jsonClient .= '"synopsis_f":"'.$row["synopsis_f"].'",';
      $jsonClient .= '"langue_f":"'.$row["langue_f"].'",';
      $jsonClient .= '"realisateur_f":"'.$row["realisateur_f"].'",';
      $jsonClient .= '"note_fm":"'.$row["note_fm"].'",';
      $jsonClient .= '"date_fm":"'.$row["date_fm"].'"';
      $jsonClient .= '}';

      $i++;
  }
  $jsonClient .= ']}';

  echo $jsonClient;
}
function retourSerie($serie){// formatage du JSON pour le client
  $jsonClient = '{"serie":[';
  $i = 0;
  foreach($serie as $row) {
      if ($i != 0){
        $jsonClient .= ',';
      }
      $jsonClient .= '{';
      $jsonClient .= '"titre_s":"'.$row["titre_s"].'",';
      $jsonClient .= '"num_sn":"'.$row["num_sn"].'",';
      $jsonClient .= '"num_e":"'.$row["num_e"].'",';
      $jsonClient .= '"titre_e":"'.$row["titre_e"].'",';
      $jsonClient .= '"synopsis_e":"'.$row["synopsis_e"].'",';
      $jsonClient .= '"note_em":"'.$row["note_em"].'",';
      $jsonClient .= '"date_em":"'.$row["date_em"].'"';
      $jsonClient .= '}';

      $i++;
  }
  $jsonClient .= ']}';

  echo $jsonClient; 
}
function retourIndex($film, $serie){ // formatage du JSON pour le client
  $jsonClient = '{"film":[';
    $i = 0;
  foreach($film as $row) {
      if ($i != 0){
        $jsonClient .= ',';
      }
      $jsonClient .= '{';
      $jsonClient .= '"titre_f":"'.$row["titre_f"].'",';
      $jsonClient .= '"date_sortie_f":"'.$row["date_sortie_f"].'",';
      $jsonClient .= '"duree_f":"'.$row["duree_f"].'",';
      $jsonClient .= '"synopsis_f":"'.$row["synopsis_f"].'",';
      $jsonClient .= '"langue_f":"'.$row["langue_f"].'",';
      $jsonClient .= '"realisateur_f":"'.$row["realisateur_f"].'",';
      $jsonClient .= '"note_fm":"'.$row["note_fm"].'",';
      $jsonClient .= '"date_fm":"'.$row["date_fm"].'"';
      $jsonClient .= '}';

      $i++;
  }
  $jsonClient .= '],"serie":[';
  $i = 0;
  foreach($serie as $row) {
      if ($i != 0){
        $jsonClient .= ',';
      }
      $jsonClient .= '{';
      $jsonClient .= '"titre_s":"'.$row["titre_s"].'",';
      $jsonClient .= '"num_sn":"'.$row["num_sn"].'",';
      $jsonClient .= '"num_e":"'.$row["num_e"].'",';
      $jsonClient .= '"titre_e":"'.$row["titre_e"].'",';
      $jsonClient .= '"synopsis_e":"'.$row["synopsis_e"].'",';
      $jsonClient .= '"note_em":"'.$row["note_em"].'",';
      $jsonClient .= '"date_em":"'.$row["date_em"].'"';
      $jsonClient .= '}';

      $i++;
  }
  $jsonClient .= ']}';

  echo $jsonClient; 
}
?>

















