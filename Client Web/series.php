<?php 
	$page="S&eacute;ries";
	include 'header.php';
?>

<!-- #navigation -->
	<div id="contenu">
		<h2>Liste des S&eacute;ries</h2>

	<?php
		// on ouvre la connexion MySQL
		include('connexion.php');

		// on fait les opérations nécessaires
		$req_serie = "SELECT * FROM serie ORDER BY titreSerie;";
		$dataset_serie = mysql_query($req_serie) or die($req_serie."<br />\n".mysql_error());

		// Maintenant on va lire le dataset ligne par ligne (datarow par datarow)
include('tableau_serie.php');
		
		?>
	</div><!-- #contenu -->
<?php 
	include 'footer.php';
?>