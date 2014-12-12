<?php echo '<script type="text/javascript" src="jquery-1.9.1.min.js"></script>';
		
echo '<table border="0" class="listeFilm" id="listeFilm" width="100%">';
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

// maintenant que la requête a été effectuée, on peut refermer la connexion
mysql_close();
	