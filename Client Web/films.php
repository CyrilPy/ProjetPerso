<?php 
	$page="Films";
	include 'header.php';
?>

<!-- #navigation -->
	<div id="contenu">
		<h2>Liste des Films</h2>

	<?php
		// on ouvre la connexion MySQL
		include('connexion.php');

		// on fait les opérations nécessaires
		$req_film = "SELECT * FROM film ORDER BY titreFilm;";
		$dataset_film = mysql_query($req_film) or die($req_film."<br />\n".mysql_error());

		// Maintenant on va lire le dataset ligne par ligne (datarow par datarow)
include('tableau_film.php');
		
		?>
	</div><!-- #contenu -->
<?php 
	include 'footer.php';
?>