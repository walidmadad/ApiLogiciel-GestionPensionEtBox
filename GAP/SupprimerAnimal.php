<?php
require_once 'database.php';
if(!empty($_POST['id'])){
    $id_animal = $_POST['id'];

    $conn = connectToDatabase();

    $sqlstmt = $conn->prepare("DELETE FROM animal WHERE id_Animal = ?");

    $sqlstmt->bind_param("i", $id_animal);
    $affichage = array();
    if($sqlstmt->execute()) {
        $affichage[] = array(
            "status" => "success",
            "message" => "Animal Supprimer");
    } else {
        $affichage[] = array(
            "status" => "erreur",
            "message" => "Erreur lors de la suppression de l'animal.");

    }
} else {
    $affichage[] = array(
        "status" => "erreur",
        "message" => "Les données nécessaires sont manquantes.");
}
echo json_encode($affichage, JSON_PRETTY_PRINT);

?>
