<?php
header('Content-Type: application/json');
require_once 'database.php';

$affichage = array();

if (
    isset($_POST['id'], $_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['tel'], $_POST['adresse'], $_POST['dateNaissance'])
) {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $adresse = $_POST['adresse'];
    $dateNaissance = $_POST['dateNaissance'];

    $conn = connectToDatabase();

    if ($conn) {
        $sqlstmt1 = $conn->prepare("UPDATE proprietaire SET nom_Propietaire=?, prenom_Propietaire=?, Adresse_Propietaire=?, date_naissance_proprietaire=?, TELEPHONE_Propietaire=?, email_Proprietaire=? WHERE id_proprietaire=?");
        $sqlstmt1->bind_param("ssssssi", $nom, $prenom, $adresse, $dateNaissance, $tel, $email, $id);
        if ($sqlstmt1->execute()) {
            $affichage = array(
                "status" => "success",
                "message" => "Proprietaire modifié"
            );
        } else {
            $affichage = array(
                "status" => "erreur",
                "message" => "Échec de la mise à jour des informations du propriétaire"
            );
        }
    } else {
        $affichage = array(
            "status" => "erreur",
            "message" => "Échec de la connexion à la base de données"
        );
    }
} else {
    $affichage = array(
        "status" => "erreur",
        "message" => "Tous les champs sont obligatoires"
    );
}

echo json_encode($affichage, JSON_PRETTY_PRINT);
?>
