<div id="instruments">


<?php
	echo '<h1 class="entry-title">Liste des instruments  </h1>';
	

	$SQL = "SELECT libelle, id as idType FROM type_instruments ORDER BY 2 ASC";
	$stmt = $connexion->prepare($SQL);
	$stmt->execute(array()); // on passe dans le tableaux les paramètres si il y en a à fournir (aucun ici)
	$lesTypes = $stmt->fetchAll(PDO::FETCH_ASSOC); // on met le resultat de la requete dans un tableau à 2 dimensions
	//var_dump($lesTypes); // on affiche le contenu de la variable $consoles (ici un tableau php array())
	$stmt->closeCursor(); // on ferme le curseur des résultats
	
?>

<form method="post" action="index.php?page=instruments">
	<select name="type">
		<option value="idType">--sélectionner un type d'instrument--</option>
			<?php
			foreach ($lesTypes as $leType) {
				$selected = "";
				if ((isset($_POST['type'])) && ($_POST['type']==$leType['idType'])) {
					$selected = "selected";
				}
				echo '<option value="'.$leType['idType'].'" '.$selected.'>'.$leType['libelle'].'</option>';
			} ?>
	</select>
	<input type="submit" value="recharger" title="recharger" />
</form>


<?php 

	if ((isset($_POST['type'])) && ($_POST['type'] != "")){
		$idType = $_POST['type'];

		$SQL = "SELECT * FROM instruments WHERE idTypeInstrument = ? ";
		$stmt = $connexion->prepare($SQL);
		$stmt->execute(array($idType)); // on passe dans le tableaux les paramètres si il y en a à fournir (aucun ici)
		$leInstrument = $stmt->fetchAll(PDO::FETCH_ASSOC); // on met le resultat de la requete dans un tableau à 2 dimensions
		//var_dump($leInstrument); // on affiche le contenu de la variable $consoles (ici un tableau php array())
		$stmt->closeCursor(); // on ferme le curseur des résultats
	} else {
		$SQL = "SELECT * FROM instruments ";
		$stmt = $connexion->prepare($SQL);
		$stmt->execute(array()); // on passe dans le tableaux les paramètres si il y en a à fournir (aucun ici)
		$leInstrument= $stmt->fetchAll(PDO::FETCH_ASSOC); // on met le resultat de la requete dans un tableau à 2 dimensions
		//var_dump(leInstrument); // on affiche le contenu de la variable $consoles (ici un tableau php array())
		$stmt->closeCursor(); // on ferme le curseur des résultats


	} 
		
	?>
	 
	<?php
	?> <table align ="center">
			<tr><th>instruments</th><th>photos des instruments</th></tr> 	
				<?php
		foreach ($leInstrument as $leInstru){
		
			echo 	"<tr><td>".$leInstru['libelle'].":</td><td> "; 
			if ($leInstru['photo'] == '' or $leInstru['photo']== 'null'){
				echo 'il n y a pas de photo  </tr></td>';
			}
			else{
				echo "<img src=template-css/instruments/".$leInstru['photo']." title='image de ".$leInstru['libelle']."'> </tr></td>";		
			}
			
			}
		?>
		</table>





</div>