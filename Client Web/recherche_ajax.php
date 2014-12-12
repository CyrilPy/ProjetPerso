
	<?php 

		// on ouvre la connexion MySQL
		include('connexion.php');


//nom de la table sur laquelle on recherche
	$nom_table='film';
	//nom du champs sur lequel on effectue la recherche
	$nom_champ='titreFilm';
	//suppression des espaces inutiles
	$chaine=trim($_GET["req"]);
	//si la recherche n'est pas vide
	if($chaine!='')
	{
		//on sépare les mots
		$chaine=explode(' ', $chaine);
		$nb=count($chaine);
		//si il y'a plusieurs mots
		$req_sup='';
		if($nb>1)
		{
			//pour chaque mot sauf le premier
			for($i=1;$i<$nb;$i++)
			{
				$chaine[$i]=trim($chaine[$i]);
				//si la chaine n'est pas vide
				if($chaine[$i]!='')
				{
					//on forme la requête
					$req_sup.=" AND (".$nom_champ." LIKE '%".$chaine[$i]."%') ";
				}
			}
		}
		//on fait la recherche, qui prend par defaut le premier mot, + les autre qu'on vient de traiter
		$query ="
		SELECT * FROM ".$nom_table."
		WHERE (".$nom_champ." LIKE '%".$chaine[0]."%')
		".$req_sup."
		ORDER BY ".$nom_champ;

		$dataset_film = mysql_query($query);
								
			echo '<br><table border="0" class="listeFilm" id="listeFilm" width="100%">';
			echo '<tr class="titreTab" align="center">';
			echo '	<td width="25%"><h4>Titre</h4></td>
					<td width="13%"><h4>Date de Sortie</h4></td>
					<td width="25%"><h4>R&eacute;alisateur</h4></td>
					<td width="25%"><h4>Genre</h4></td>
					<td width="12%"><h4>Vu</h4></td>
				</tr>
				<tr >
					<td colspan="5" class="celluleSyn"></td>
				</tr>';
			$i=0;
			while($film = mysql_fetch_array($dataset_film))
			{
				echo '<tr class="film" id="film'.$i.'">';
				echo '	<td>'.$film['titreFilm'].' </td>
						<td align="center"> '.$film['dateSortie'].'</td>
						<td>'.$film['realisateur'].' </td>
						<td>'.$film['genreFilm'].' </td>
						<td align="center">';
				 if($film['vu']==1){
				 	echo $film['dateVu'];
				 }else{
				 	echo 'Non';
				 }
				 echo '</td>
					</tr>
					<tr >
						<td colspan="5" class="celluleSyn">
							<div class="synopsis" id="synopsis'.$i.'">
								'.$film['synopsis'].'
							</div>
						</td>
					</tr>';
				?>
				<script type="text/javascript">
					$("#film<?php echo $i;?>").click(function(){
						$("#synopsis<?php echo $i;?>").slideToggle("slow");
					});
				</script>
				<?php
				$i++;
			};
			echo '</table>';
	}
	else
	{
		//on renvois du vide
		echo '';
	} 
?>