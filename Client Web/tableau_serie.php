<?php echo '<script type="text/javascript" src="jquery-1.9.1.min.js"></script>';
		
echo '<table border="0" class="listeserie" id="listeserie" width="100%">';
echo '<tr class="titreTab" align="center">';
echo '	<td width="25%"><h4>Titre</h4></td>
		<td width="25%"><h4>Genre</h4></td>
		<td width="12%"><h4>Ann&eacute;e D&eacute;but</h4></td>
	</tr>
	<tr >
		<td colspan="5" class="celluleSyn"></td>
	</tr>';
$i=0;
while($serie = mysql_fetch_array($dataset_serie))
{
	echo '<tr class="serie" id="serie'.$i.'">';
	echo '	<td>'.$serie['titreSerie'].' </td>
			<td>'.$serie['genreSerie'].' </td>
			<td>'.$serie['anneeDebut'].' </td>
		</tr>
		<tr >
			<td colspan="5" class="celluleSyn">
				<div class="synopsis" id="synopsis'.$i.'">
					'.$serie['synopsisSerie'].'
				</div>
			</td>
		</tr>';
	?>
	<script type="text/javascript">
		$("#serie<?php echo $i;?>").click(function(){
			$("#synopsis<?php echo $i;?>").slideToggle("slow");
		});
	</script>
	<?php
	$i++;
};
echo '</table>';

// maintenant que la requête a été effectuée, on peut refermer la connexion
mysql_close();
	