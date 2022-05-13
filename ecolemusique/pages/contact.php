    <div id="contact">
<div id="instruments">


    <form method="post" action="#">
    
    <fieldset>
        <legend>Vos coordonnées</legend> <!-- Titre du fieldset --> 

        <label for="nom">Quel est votre nom ?</label>
        <input type="text" name="nom" id="nom"/>

        <label for="prenom">Quel est votre prénom ?</label>
        <input type="text" name="prenom" id="prenom">" />
    
        <label for="email">Quel est votre e-mail ?</label>
        <input type="email" name="email" id="email?" />

    </fieldset>
    <?php
     	$SQL = "SELECT libelle , id FROM instruments ";
         $stmt = $connexion->prepare($SQL);
         $stmt->execute(array()); // on passe dans le tableaux les paramètres si il y en a à fournir (aucun ici)
         $instru = $stmt->fetchAll(PDO::FETCH_ASSOC); // on met le resultat de la requete dans un tableau à 2 dimensions
         //var_dump($instru); // on affiche le contenu de la variable $consoles (ici un tableau php array())
         $stmt->closeCursor(); // on ferme le curseur des résultats
    ?>
    
    <fieldset>
        <legend>demande</legend> <!-- Titre du fieldset -->
    
        <p>
        l'objet de la demande :

                
            
            <select name="demande" id="demande">
                <option value="demande informations">demande d’informations </option>
                <option value="demande inscription">demande d’inscription</option>
                <option value="abonnement newsletter">abonnement à la newsletter</option>
            </select>
        

</br>les instruments :
            <?php 
            foreach ($instru as $ins){ 
                
                ?>
                
                
                <input type="checkbox" name="instrument<?php echo $ins['id']?>"  id="instrument<?php echo $ins['id']?>"value="oui" /> <label for=""><?php echo $ins['libelle'] ?></label>
            
            <?php } ?>
        </p>
    
        <p>
            <label for="objet">objet de la demande :</label>
            <textarea name="objet" id="objet" cols="40" rows="4"></textarea>
        </p>
        <input type="submit" name ="submit" value="Envoyer" />
    </fieldset>
            </br>
    <fieldset>
        <legend>Nos coordonnées</legend>
        
        Adresse : 8 Av. Debrousse, 69005 Lyon  </br>
         <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2784.0014178743436!2d4.8107169158039005!3d45.75111752227294!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47f4ebbbc37690d1%3A0x22f3f94cb32eff95!2s8%20Av.%20Debrousse%2C%2069005%20Lyon!5e0!3m2!1sfr!2sfr!4v1638185551310!5m2!1sfr!2sfr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
         </br>
            num de l'école : <a href=" callto : +3360606060">+3360606060</a> 
            mail:<a href="mailto : ecoledemusique@mail.com"> ecoledemusique@mail.com</a>


    </fieldset>

    </form>





<?php
if (isset($_POST['submit'])){
        $instr="";
        foreach($instru as $ins){
            
                if (isset($_POST['instrument'.$ins['id']]) == 'oui'){
                    $instr = $instr . $ins['libelle'] .', ';
            //var_dump($ins);
        
                    }
        

    }
    $instr = substr($instr, 0, -2);
        //echo $_POST['instrument1'];
        //echo $instr;

                $servname = 'localhost';
                $dbname = 'ecolemusique';
                $user = 'root';
                $pass = 'root';
                $nom= $_POST['nom'];
                $prenom= $_POST['prenom'];
                $email= $_POST['email'];
                $demande= $_POST['demande'];
                $instrument= $instr;
                $objet= $_POST['objet'];

                
                try{
                    $dbco = new PDO("mysql:host=$servname;dbname=$dbname", $user, $pass);
                    $dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stmt = $dbco->prepare("INSERT INTO contact (nom, prenom, email, demande, instrument, objet) VALUES (:nom,:prenom,:email,:demande,:instrument,:objet ) ");
                    $stmt->bindParam(':nom', $nom ,PDO::PARAM_STR);
                    $stmt->bindParam(':prenom', $prenom , PDO::PARAM_STR);
                    $stmt->bindParam(':email', $email,PDO::PARAM_STR);
                    $stmt->bindParam(':demande', $demande, PDO::PARAM_STR);
                    $stmt->bindParam(':instrument', $instrument, PDO::PARAM_STR);
                    $stmt->bindParam(':objet', $objet, PDO::PARAM_STR);
                            
                    $stmt->execute();
                    
                    
                    
                    
                }
                
                catch(PDOException $e){
                echo "Erreur : " . $e->getMessage();
                }

            }
            ?>

        </div>
        </div>