<div id="cour">

	
<?php
	echo '<h1 class="entry-title">Liste des cours  </h1>';
	

	$SQL = "SELECT libelle, id as idinstrument  FROM instruments ORDER BY 2 ASC";
	$stmt = $connexion->prepare($SQL);
	$stmt->execute(array()); // on passe dans le tableaux les paramètres si il y en a à fournir (aucun ici)
	$lesInstruments = $stmt->fetchAll(PDO::FETCH_ASSOC); // on met le resultat de la requete dans un tableau à 2 dimensions
	//var_dump($lesInstruments); // on affiche le contenu de la variable $consoles (ici un tableau php array())
	$stmt->closeCursor(); // on ferme le curseur des résultats
	
?>

<form method="post" action="index.php?page=cours">
	<select name="instrument">
		<option value="idInstrument">--sélectionner un instrument--</option>
			<?php
			foreach ($lesInstruments as $unInstrument) {
				$selected = "";
				if ((isset($_POST['instrument'])) && ($_POST['instrument']==$unInstrument['idinstrument'])) {
					$selected = "selected";
				}
				echo '<option value="'.$unInstrument['idinstrument'].'" '.$selected.'>'.$unInstrument['libelle'].'</option>';
			} ?>
	</select>
	<input type="submit" value="recharger" title="recharger" />
</form>



<?php 

	if ((isset($_POST['instrument'])) && ($_POST['instrument'] != "")){
		$idInstrument = $_POST['instrument'];

		$SQL = "SELECT * FROM cours NATURAL JOIN tarifs WHERE idInstrument = ? ORDER BY libelleCours ASC";
		$stmt = $connexion->prepare($SQL);
		$stmt->execute(array($idInstrument)); // on passe dans le tableaux les paramètres si il y en a à fournir (aucun ici)
		$lesCours = $stmt->fetchAll(PDO::FETCH_ASSOC); // on met le resultat de la requete dans un tableau à 2 dimensions
		//var_dump($lesCours); // on affiche le contenu de la variable $consoles (ici un tableau php array())
		$stmt->closeCursor(); // on ferme le curseur des résultats
	} else {
		$SQL = "SELECT * FROM cours NATURAL JOIN tarifs  ";
		$stmt = $connexion->prepare($SQL);
		$stmt->execute(array()); // on passe dans le tableaux les paramètres si il y en a à fournir (aucun ici)
		$lesCours = $stmt->fetchAll(PDO::FETCH_ASSOC); // on met le resultat de la requete dans un tableau à 2 dimensions
		//var_dump($lesCours); // on affiche le contenu de la variable $consoles (ici un tableau php array())
		$stmt->closeCursor(); // on ferme le curseur des résultats


	} 
		
	?>

	<?php
	?> 
			<table align = "center">
				<tr> <th>nom du cours</th> <th> age pour les cours</th><th></th><th>le nombre de places </th> <th>montant du cours </th> </tr>
				<?php
		foreach ($lesCours as $cours){
		
			echo 	"<tr>
						<td>".$cours['libelleCours']."</td>
						<td colspan='2'>".$cours['ageMini']."-".$cours['ageMaxi']."</td>
						<td>".$cours['nbPlaces']."</td> 
						<td>".$cours['montant'] ."</td>
					</tr>";
			
			}
		?>
			</table>
			

</div>