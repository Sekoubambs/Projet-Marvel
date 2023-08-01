<?php

include 'Database.php';

class DbConnect extends Database{
    private $dbConnect;    


    public function __construct()
    {
        
        $this->dbConnect = Database::dbConnect();
    }

    public function readAll(){
        $sqlSelect = "SELECT * FROM `film`";
        $stmtSelect = $this->dbConnect->prepare($sqlSelect);
        $stmtSelect->execute();
        return $stmtSelect->fetchAll(PDO::FETCH_ASSOC);
    }


    public function readAllActeur (){
        $sqlActeurs = "SELECT * FROM `acteur`";
        $stmtActeurs = $this->dbConnect->prepare($sqlActeurs);
        $stmtActeurs->execute();
        return $stmtActeurs->fetchAll(PDO::FETCH_ASSOC);

    }

    public function readAllRealisateur (){
        $sqlRealisateurs = "SELECT * FROM `réalisateur`";
        $stmtRealisateurs = $this->dbConnect->prepare($sqlRealisateurs);
        $stmtRealisateurs->execute();
        return $stmtRealisateurs->fetchAll(PDO::FETCH_ASSOC);

    }



    public function insertIntoFilm ($nomFilm,$dateDeSortie,$duree,$affiche){
        $sqlInsertFilm = "INSERT INTO `film`(`Nom_du_film`, `dateDeSortie`, `Durée`, `affiche`) VALUES ('$nomFilm','$dateDeSortie','$duree','$affiche')";
        $stmtInsertFilm =$this->dbConnect->prepare($sqlInsertFilm);
        return $stmtInsertFilm->execute();

    }

    public function insertIntoActeur ($nomActeur,$prenomActeur){
        $sqlInsertActeur = "INSERT INTO `acteur`(`Nom_acteur`, `Prenom_acteur`) VALUES ('$nomActeur','$prenomActeur')";
        $stmtInsertActeur =$this->dbConnect->prepare($sqlInsertActeur);
        return $stmtInsertActeur->execute();

    }

    public function insertIntoRealisateur ($nomRealisateur,$prenomRealisateur){
        $sqlInsertRealisateur = "INSERT INTO `réalisateur`(`Nom_réalisateur`, `Prenom_réalisateur`) VALUES ('$nomRealisateur','$prenomRealisateur')";
        $stmtInsertRealisateur =$this->dbConnect->prepare($sqlInsertRealisateur);
        return $stmtInsertRealisateur->execute();

    }


    public function postActeur ($acteurSelectionne){


        $sqlListeActeurs ="SELECT film.id_film , film.Nom_du_film, film.dateDeSortie, film.Durée, film.affiche , acteur.id_acteur 
        FROM `film` 
        INNER JOIN `joue_dans` on film.id_film = joue_dans.id_film 
        INNER JOIN `acteur` on joue_dans.id_acteur = acteur.id_acteur 
        WHERE acteur.id_acteur = $acteurSelectionne";
       
        $stmtListeActeurs = $this->dbConnect->prepare($sqlListeActeurs);
        $stmtListeActeurs->execute();
        return  $stmtListeActeurs->fetchAll(PDO::FETCH_ASSOC);

    }

    public function postRealisateur ($realisateurSelectionne){


        $sqlRealisateurs ="SELECT film.id_film , film.Nom_du_film, film.dateDeSortie, film.Durée, film.affiche , réalisateur.id_réalisateur 
        FROM `film` 
        INNER JOIN `réalise` on film.id_film = réalise.id_film 
        INNER JOIN `réalisateur` on réalise.id_réalisateur = réalisateur.id_réalisateur 
        WHERE réalisateur.id_réalisateur = $realisateurSelectionne";
       
        $stmtListeRealisateurs = $this->dbConnect->prepare($sqlRealisateurs);
        $stmtListeRealisateurs->execute();
        return  $stmtListeRealisateurs->fetchAll(PDO::FETCH_ASSOC);

    }


    

}