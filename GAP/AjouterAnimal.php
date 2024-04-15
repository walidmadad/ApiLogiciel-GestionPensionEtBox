<?php
require_once 'database.php';
if (!empty($_POST['prop']) && !empty($_POST['nom']) && !empty($_POST['espece'])) {
    $nom_animal = $_POST['nom'];
    $espece = $_POST['espece'];
    $id_proprietaire = $_POST['prop'];

    $conn = connectToDatabase();
    $result = array();
    if ($conn) {

        $sqlstmt1 = $conn->prepare("INSERT INTO animal(nom_animal, id_espece, id_proprietaire) VALUES(?,?,?)");
        $sqlstmt1->bind_param("sss",$nom_animal,$espece, $id_proprietaire);
        if ($sqlstmt1->execute()) {
            $result = array("status" => "success", "message" => "Animal Ajouter");
        }else {
        $result = array("status" => "erreur", "message" => "Failed to insert into animal table");

        }
    } else {
        $result = array("status" => "erreur", "message" => "Database connection failed");
    }
} else {
    $result = array("status" => "erreur", "message" => "All fields are required");
}
echo json_encode($result, JSON_PRETTY_PRINT);