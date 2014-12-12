<?php 
$host = "mysql.imerir.com";	// serveur mysql
$db = "seen";				// nom de la BDD
$user = "seen";				// login de l'utilisateur de la BDD
$pass = "dzMbzFHmyS5bQV9V";	// mot de passe de l'utilisateur de la BDD


// Création d'un flux
$opts = array(
  'http'=>array(
    'method'=>"GET",
    'header'=>"X-BetaSeries-Key: 4efa6075b15d\r\n".
              "X-BetaSeries-Version: 2.3\r\n".
              "Accept: application/json\r\n".
              "User-agent: Seen\r\n"
  )
);

$context = stream_context_create($opts);

// Accès à un fichier HTTP avec les entêtes HTTP indiqués ci-dessus
$file = file_get_contents('http://api.betaseries.com/shows/search?title=arrow', false, $context);
$file = json_decode($file);




try {
    $dbh = new PDO('mysql:host='.$host.';dbname='.$db, $user, $pass); // accès à la base de données

$req = $dbh->prepare('INSERT INTO serie (id_bs_s, titre_s, synopsis_s, date_debut_s, langue_s, statut_s) VALUES(:id_bs_s, :titre_s, :synopsis_s, :date_debut_s, :langue_s, :statut_s)');
$req->execute(array(
	'id_bs_s' => $file->{'shows'}[0]->{'id'},
	'titre_s' => $file->{'shows'}[0]->{'title'},
	'synopsis_s' => $file->{'shows'}[0]->{'description'},
	'date_debut_s' => $file->{'shows'}[0]->{'creation'},
	'langue_s' => $file->{'shows'}[0]->{'language'},
	'statut_s' => $file->{'shows'}[0]->{'status'}
	));

   $dbh = null; // fermeture de la connexion a la BDD

} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}


try {
    $dbh = new PDO('mysql:host='.$host.';dbname='.$db, $user, $pass); // accès à la base de données
    foreach($dbh->query('SELECT * from serie') as $row) { // requete sur la base de données
        var_dump($row["synopsis_s"]);
        echo "<hr>";
        echo "<hr>";
    }
    $dbh = null; // fermeture de la connexion a la BDD
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}


?>
















