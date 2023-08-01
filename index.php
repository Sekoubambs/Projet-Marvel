<?php

session_start();

include './Class/DbConnect.php';

$db = new DbConnect;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles/style.css">
</head>


<body>

<div class=container>

<header class="header">

   <img src="https://static.lpnt.fr/images/2018/12/31/17817336lpw-17817357-article-jpg_5839679_1250x625.jpg" >
</header>



<section>


    <nav>

        <ul class=d-inline-block>

           <a href='index.php?page=accueil'>Accueil</a>
           <a href='index.php?page=user'>Films</a>
           <a href='index.php?page=settings'>Maj films</a>
<?php


                if (isset($_SESSION) and !empty($_SESSION)){    ?>
                    <a href="?page=connexion">Déconnexion</a>;
               <?php } else { ?>
                   <a href="?page=connexion">Connexion</a>
               <?php };
               ?>


       </ul>

   </nav>

   <?php


// **********************************PAGE ACCUEIL***********************************************************

if (isset($_GET['page']) && $_GET['page'] == "accueil" && empty($_SESSION)) {

    echo '<form class="form" method="POST">';
    echo '<p>Identifiant</p><input type="text" name="identifiant">';
    echo '<p>Mot de passe</p><input type="password" name="password">';
    echo '<p>Email</p><input type="email" name="email">';
    echo '<br>';
    echo '<br>';
    echo '<input type="submit" name="submit" value="connexion">';
    echo '</form>';

}


if (isset($_GET['page']) && $_GET['page'] == 'user' && empty($_SESSION)){ ?>
    <p class="alert warning">Vous devez être connecté pour pouvoir avoir accès à cette partie du site</p>
<?php }



if (isset($_POST['submit']) && ($_POST['identifiant'] == 'sekoubambs' && $_POST['password'] === '100385')) {



    $_SESSION = [
        'identifiant' => 'sekoubambs',
        'password' => '100385',
        'age' => 38 , 
        'nom' => 'haidara',
        'prenom' => 'amadou',
        'role' => 'stagiaire',
    ] ;
    
          echo 'Bienvenue ' . $_SESSION['prenom'] . '!!!';

        
      }

  if (isset($_POST['submit']) && ($_POST['identifiant'] != 'sekoubambs' || $_POST['password'] != '100385')) {
      
      echo 'Votre identifiant ou votre mot de passe est incorrect' ;
  }

  if (isset($_GET['page']) && $_GET['page'] == "accueil" && !empty($_SESSION)) {
      ?>
      <h1>Bonjour et bienvenue sur votre page d'accueil !!!</h1>
      <p class="alert-success">Vous êtes maintenant Connecté</p>
       <?php
             header("refresh:1;http://localhost/poo%20marvel/index.php?page=user");

      }




// **********************************PAGE USER (FILMS)***********************************************************




    if (isset($_GET['page']) && $_GET['page'] == 'user' && empty($_SESSION)){ ?>
        <p class="alert warning">Vous devez être connecté pour pouvoir avoir accès à cette partie du site</p>
<?php }



    if (isset($_GET['page']) && $_GET['page'] == "user" && !empty($_SESSION) ){



        echo '<form method="POST">';     // ******INPUT FILTRE PAR ACTEUR  
        echo '<select name="acteur">';
        echo '<option value="">-- Sélectionner un acteur --</option>';

        $acteurs = $db->readAllActeur(); // Fetch tous les acteur à partir de la table "acteur"


        foreach ($acteurs as $acteur) {
        echo '<option value="' . $acteur['id_acteur'] . '">' . $acteur['Prenom_acteur'] . ' ' . $acteur['Nom_acteur'] . '</option>';
        }
        echo '</select>';
        echo '<input type="submit" name="submitActeur"  >';
        echo '</form>';



        echo '<form method="POST">'; // ******INPUT FILTRE PAR REALISATEUR
        echo '<select name="réalisateur">';
        echo '<option value="">-- Sélectionner un réalisateur --</option>';
        
        $realisateurs = $db->readAllRealisateur(); // Fetch tous les réalisateurs à partir de la table "film"
        
        foreach ($realisateurs as $realisateur) {
            echo '<option value="' . $realisateur['id_réalisateur'] . '">' . $realisateur['Prenom_réalisateur'] . ' ' . $realisateur['Nom_réalisateur'] . '</option>';
        }
        
        echo '</select>';
        echo '<input type="submit" name="submitRealisateur">';
        echo '</form>';
        




          

        if (isset($_POST['submitActeur']) && isset($_POST['acteur'])) { // ******submit acteur
            $acteurSelectionne = $_POST['acteur'];
            $result = $db->postActeur($acteurSelectionne);
        } elseif (isset($_POST['submitRealisateur']) && isset($_POST['réalisateur'])) { // ******submit réalisateur
            $realisateurSelectionne = $_POST['réalisateur'];
            $result = $db->postRealisateur($realisateurSelectionne);
        } else {
            // Si aucun acteur ou réalisateur n'est sélectionné, fetch tous les films
            $result = $db->readAll();
        }
        
        
        echo '<section class="container">';
        foreach ($result as $film) {
            echo '<div class="card">';
            echo '<h3>' . $film['Nom_du_film'] . '</h3>';
            echo '<img src="' . $film['affiche'] . '" alt="' . $film['Nom_du_film'] . '" width="150">';
            echo '<p>Date de sortie : ' . $film['dateDeSortie'] . '</p>';
            echo '<p>Durée : ' . $film['Durée'] . ' minutes</p>';
            echo '</div>';
        }
        echo '</section>';
    }
    ?>


 <!-- // **********************************PAGE MISE A JOUR FILMS*********************************************************** -->
           
<?php     

if (isset($_GET['page']) && $_GET['page'] == "settings" && empty($_SESSION)) { ?>
    <p class="alert warning">Vous devez être connecté pour pouvoir avoir accès à cette partie du site</p>
            <?php }
            
 if (isset($_GET['page']) && $_GET['page'] == 'settings' && !empty($_SESSION)){ 
    
        echo   '<br>';
        echo   '<form method="post">';
        echo   '<input type="text" name="Nom_du_film" placeholder="Nom du film">';
        echo   '<br>';
        echo   '<p>Date<p> <input type="date" name="dateDeSortie">';
        echo   '<br>';
        echo   '<input type="number" name="Durée" placeholder="Durée">';
        echo   '<br>';
        echo   '<input type="text" name="genre" placeholder="Genre">';
        echo   '<br>';
        echo   '<input type="url" name="affiche" placeholder="Affiche">';
        echo   '<br>';
        echo   '<input type="submit" name="submitCreateFilm" value="Ajouter film">';
        echo   '<br>';
        echo   '<br>';
        echo   '<input type="text" name="Nom_réalisateur" placeholder="Nom du réalisateur">';
        echo   '<br>';
        echo   '<input type="text" name="Prenom_réalisateur" placeholder="Prénom du réalisateur">';
        echo   '<br>';
        echo   '<input type="submit" name="submitCreateReal" value="Ajouter Réalisateur">';
        echo   '<br>';
        echo   '<br>';
        echo   '<input type="text" name="Nom_acteur" placeholder="Nom Acteur">';
        echo   '<br>';
        echo   '<input type="text" name="Prenom_acteur" placeholder="Prénom Acteur">';
        echo   '<br>';
        echo   '<input type="submit" name="submitCreateActeur" value="Ajouter Acteur">';
        echo   '<br>';
        echo   '<br>';
        echo   '<br>';
        echo   '<br>';
        echo   '<input type="submit" name="submitUpdate" value="Update film">';
        echo   '<br>';
        echo   '<br>';
        echo   '<br>';
        echo   '<br>';
        echo   '<input type="submit" name="submitDelete" value="Supprimer film">';

    
                '</form>';
    
            }
    

            if (isset($_POST["submitCreateFilm"])) {

                $nomFilm = $_POST['Nom_du_film'];
                $dateDeSortie = $_POST['dateDeSortie'];
                $duree = $_POST['Durée'];
                $affiche = $_POST['affiche'];
                $genre = $_POST['genre'];
    
    
                $result = $db-> insertIntoFilm ($nomFilm,$dateDeSortie,$duree,$affiche);
    
                header("refresh:1;http://localhost/poo%20marvel/index.php?page=settings");
                }
    
    
            if (isset($_POST["submitCreateReal"])) {
                $nomRealisateur = $_POST['Nom_réalisateur'];
                $prenomRealisateur = $_POST['Prenom_réalisateur'];
                
                $result = $db-> insertIntoRealisateur ($nomRealisateur,$prenomRealisateur);
    
                 header("refresh:1;http://localhost/poo%20marvel/index.php?page=settings");
                }
            
    
             if (isset($_POST["submitCreateActeur"])) {
                $nomActeur = $_POST['Nom_acteur'];
                $prenomActeur = $_POST['Prenom_acteur'];
                
                $result = $db-> insertIntoActeur ($nomActeur,$prenomActeur);
                
                header("refresh:1;http://localhost/poo%20marvel/index.php?page=settings");
                }
    
    
































// *********************************************** Déconnexion ********************************************************************************************


if (isset($_GET['page']) && $_GET['page'] == "connexion" && !empty($_SESSION)) {

    echo '<form method="POST">';
    echo '<br>';
    echo '<input type="submit" name="deconnexion" value="Déconnexion">';
    echo '</form>';
}

?>

<?php
    if (isset($_POST['deconnexion'])) {
    session_destroy(); ?>
    <p class="alert-deconnexion">Vous êtes maintenant déconnecté</p>
    <?php
                header("refresh:1;http://localhost/poo%20marvel/index.php?page=accueil");

     }
?>

            
    
