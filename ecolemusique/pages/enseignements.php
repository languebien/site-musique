<div id="enseignements">

<?php
	echo '<h1 class="entry-title">Liste des enseignants</h1>';
	

	//$SQL = "SELECT enseignants.prenom, enseignants.nom, enseignants.photo, cours.libelleCours AS instruments FROM enseignants INNER JOIN cours ON enseignants.id = cours.idEnseignant";
	$SQL = "SELECT enseignants.id, enseignants.prenom, enseignants.nom, enseignants.photo FROM enseignants ";
	$stmt = $connexion->prepare($SQL);
	$stmt->execute(array()); // on passe dans le tableaux les paramètres si il y en a à fournir (aucun ici)
	$profs = $stmt->fetchAll(PDO::FETCH_ASSOC); // on met le resultat de la requete dans un tableau à 2 dimensions
	//var_dump($profs); // on affiche le contenu de la variable $Instrument (ici un tableau php array())
	$stmt->closeCursor(); // on ferme le curseur des résultats

?>

<table id="affiche_resultat" align="center">
	<thead>
		<tr> <td>Prénom</td><td>Nom</td><td>Photo</td><td>Instrument(s) enseigné(s)</td></tr>
	</thead>
	<!-- Corps du tableau -->
	<tbody> 
        <?php
            foreach($profs as &$prof)
            {
              $SQL = "SELECT libelleCours FROM cours WHERE idEnseignant = ? ";
              $stmt = $connexion->prepare($SQL);
              $stmt->execute(array($prof['id'])); // on passe dans le tableaux les paramètres si il y en a à fournir (aucun ici)
              $prof['cours'] = $stmt->fetchAll(PDO::FETCH_ASSOC); // on met le resultat de la requete dans un tableau à 2 dimensions
             // var_dump($prof); // on affiche le contenu de la variable $Instrument (ici un tableau php array())
              $stmt->closeCursor(); // on ferme le curseur des résultats
              
            $afficheInstru = "";
            foreach($prof['cours'] as $pro ){
              $afficheInstru = $afficheInstru . $pro['libelleCours'].", ";
            }
            $afficheInstru = substr($afficheInstru, 0, -2); 
          

            echo "<tr><td>",$prof['prenom'],"</td><td>",$prof['nom'],"</td><td> <img src=template-css/enseignants/" ,$prof['photo'],"></td><td>".$afficheInstru."</td></tr>";
            }
			//var_dump($prof);
        ?>
	</tbody>
</table>

