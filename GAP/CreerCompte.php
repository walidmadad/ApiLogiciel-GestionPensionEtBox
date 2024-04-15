<?php
require_once 'database.php';
if(!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['adresse']) && !empty($_POST['tel']) && !empty($_POST['dateNaissance']) && !empty($_POST['email']) && !empty($_POST['password'])){
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $adresse = $_POST['adresse'];
    $tel = $_POST['tel'];
    $dateNaissance = $_POST['dateNaissance'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $result = array();
    $conn = connectToDatabase();

    if($conn){
        $sql ="INSERT INTO proprietaire(nom_Propietaire, prenom_Propietaire, Adresse_Propietaire, TELEPHONE_Propietaire, email_Proprietaire, password_proprietaire, date_naissance_proprietaire) VALUES('".$nom."','".$prenom."','".$adresse."','".$tel."', '".$email."','".$password."','".$dateNaissance."')";
        if(mysqli_query($conn, $sql)){
            $result = array("status" => "success", "message" => "Compte créé");
        }
    }else{
        $result = array("status" => "failed", "message" => "Database Connection failed");
    }
}else{
    $result = array("status" => "failed", "message" => "all fields are required");
}
echo json_encode($result, JSON_PRETTY_PRINT);

