<?php
require 'database.php';
if (!empty($_POST['prenom']) && !empty($_POST['nom']) && !empty($_POST['adresse']) && !empty($_POST['telephone']) && !empty($_POST['datenaissance']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['nom_animal']) && !empty($_POST['espece'])) {
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $adresse = $_POST['adresse'];
    $telephone = $_POST['telephone'];
    $datenaissance = $_POST['datenaissance'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $nom_animal = $_POST['nom_animal'];
    $idEspece = $_POST['espece'];

    $conn = connectToDatabase();

    $sqlProprietaire = "INSERT INTO proprietaire (prenom_Propietaire, nom_Propietaire, Adresse_Propietaire, TELEPHONE_Propietaire, date_naissance_proprietaire, email_Proprietaire, password_proprietaire) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmtProprietaire = $conn->prepare($sqlProprietaire);
    $stmtProprietaire->bind_param("sssssss", $prenom, $nom, $adresse, $telephone, $datenaissance, $email, $password);
    $stmtProprietaire->execute();

    // Vérifier si l'insertion du propriétaire a réussi
    if ($stmtProprietaire->affected_rows === 1) {
        // Récupérer l'ID du propriétaire nouvellement inséré
        $idProprietaire = $stmtProprietaire->insert_id;

        // Insérer les données de l'animal
        $sqlAnimal = "INSERT INTO animal (nom_animal, id_espece, id_proprietaire) VALUES (?, ?, ?)";
        $stmtAnimal = $conn->prepare($sqlAnimal);

         // Supposons que vous avez une table 'espece' contenant les identifiants des espèces

        $stmtAnimal->bind_param("sii", $nom_animal, $idEspece, $idProprietaire);
        $stmtAnimal->execute();

        // Vérifier si l'insertion de l'animal a réussi
        if ($stmtAnimal->affected_rows === 1) {
            echo "Enregistrement inséré avec succès.";
        } else {
            echo "Erreur lors de l'insertion de l'animal.";
        }
    } else {
        echo "Erreur lors de l'insertion du propriétaire.";
    }

    // Fermer les déclarations et la connexion à la base de données
    $stmtProprietaire->close();
    $stmtAnimal->close();
    $conn->close();
} else {
    echo "Tous les champs du formulaire sont requis.";
}

