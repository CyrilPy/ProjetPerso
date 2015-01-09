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

      case "s" :  $retour = $req->query(' SELECT titre_s, synopsis_s, date_debut_s, nb_saison, nb_episode, langue_s, statut_s
                                          FROM serie, serie_membre
                                          WHERE serie.id_s=serie_membre.id_s 
                                          AND id_m = '.$qui.' 
                                          ORDER BY titre_s ASC 
                                          LIMIT 0,'.$nb.';'); // requete sur la base de données;
                  retourSerie($retour);
      break;

      case "fs" : $film = $req->query('   SELECT titre_f, date_sortie_f, duree_f, synopsis_f, langue_f, realisateur_f, note_fm, date_fm 
                                          FROM film_membre, film 
                                          WHERE film_membre.id_f=film.id_f 
                                          AND id_m = '.$qui.' 
                                          ORDER BY date_fm DESC 
                                          LIMIT 0,'.$nb.';'); // requete sur la base de données;
                  $serie = $req->query('  SELECT titre_s, num_sn, num_e, titre_e, date_e, synopsis_e, note_em, date_em 
                                          FROM serie, saison, episode, episode_membre
                                          WHERE serie.id_s=saison.id_s 
                                          AND saison.id_sn=episode.id_sn
                                          AND episode.id_e=episode_membre.id_e
                                          AND id_m = '.$qui.' 
                                          ORDER BY date_em DESC 
                                          LIMIT 0,'.$nb.';'); // requete sur la base de données
                  retourIndex($film, $serie);
      break;
    }
}else{
    header("HTTP/1.0 400 Bad Request");
}
 
function retourFilm($data){// formatage du JSON pour le client
  $jsonClient = '{"film":[';
  $i = 0;
  foreach($data as $row) {
      if ($i != 0){
        $jsonClient .= ',';
      }
      $jsonClient .= '{';
      $jsonClient .= '"titre_f":"'.str_replace('"', '\"', $row["titre_f"]).'",';
      $jsonClient .= '"date_sortie_f":"'.$row["date_sortie_f"].'",';
      $jsonClient .= '"duree_f":"'.$row["duree_f"].'",';
      $jsonClient .= '"synopsis_f":"'.str_replace('"', '\"', $row["synopsis_f"]).'",';   
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
      }// titre_s, synopsis_s, date_debut_s, nb_saison, nb_episode, langue_s, statut_s
      $jsonClient .= '{';
      $jsonClient .= '"titre_s":"'.$row["titre_s"].'",';
      $jsonClient .= '"synopsis":"'.str_replace('"', '\"', $row["synopsis_s"]).'",';
      $jsonClient .= '"date_debut":"'.$row["date_debut_s"].'",';
      $jsonClient .= '"nb_saison":"'.$row["nb_saison"].'",';
      $jsonClient .= '"nb_episode":"'.$row["nb_episode"].'",';
      $jsonClient .= '"langue":"'.$row["langue_s"].'",';
      $jsonClient .= '"statut":"'.$row["statut_s"].'"';
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
      $jsonClient .= '"titre_f":"'.str_replace('"', '\"', $row["titre_f"]).'",';
      $jsonClient .= '"date_sortie_f":"'.$row["date_sortie_f"].'",';
      $jsonClient .= '"duree_f":"'.$row["duree_f"].'",';
      $jsonClient .= '"synopsis_f":"'.str_replace('"', '\"', $row["synopsis_f"]).'",';
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
      $jsonClient .= '"date_e":"'.$row["date_e"].'",';
      $jsonClient .= '"synopsis_e":"'.str_replace('"', '\"', $row["synopsis_e"]).'",';
      $jsonClient .= '"note_em":"'.$row["note_em"].'",';
      $jsonClient .= '"date_em":"'.$row["date_em"].'"';
      $jsonClient .= '}';

      $i++;
  }
  $jsonClient .= ']}';

  echo $jsonClient; 
}
?>

















