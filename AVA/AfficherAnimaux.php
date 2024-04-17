<?php
require_once 'database.php';
if(!empty($_POST['id'])){
    $id_proprietaire = $_POST['id'];
    $espece = "";
    $conn = connectToDatabase();

    $sqlstmt = $conn->prepare("SELECT id_Animal, nom_animal, id_espece FROM animal WHERE id_proprietaire = ?");
    $sqlstmt->bind_param("i", $id_proprietaire);
    $sqlstmt->execute();

    $result = $sqlstmt->get_result();



    $affichage = array();
    if($conn) {
        while ($row = $result->fetch_assoc()) {
            $sqlstmt2 = $conn->prepare("SELECT libelle FROM espece WHERE id_espece = ?");
            $sqlstmt2->bind_param("i", $row['id_espece']);
            $sqlstmt2->execute();

            $result2 = $sqlstmt2->get_result();

            if($result2->num_rows > 0){
                $row2 = $result2->fetch_assoc();

                if(isset($row2['libelle'])){
                    $espece = $row2['libelle'];
                }
            }

            $id_animal = $row['id_Animal'];

            $affichage[] = array(
                "status" => "success",
                "message" => "Data Affichage successfully",
                "id_Animal" => $row['id_Animal'],
                "id_espece" => $row['id_espece'],
                "espece" => $espece,
                "nom_animal" => $row['nom_animal']);
        }
    } else {
        $affichage[] = array("status" => "failed", "message" => "Error executing statement: " . mysqli_error($conn));
    }
}else if(!empty($_POST['id_animal'])){
    $id_animal = $_POST['id_animal'];

    $conn = connectToDatabase();
    $sqlstmt = $conn->prepare("SELECT id_espece FROM animal WHERE id_animal = ?");
    $sqlstmt->bind_param("i", $id_animal);
    $sqlstmt->execute();
    $espece = "";
    $result = $sqlstmt->get_result();

    $affichage = array();
    if($conn) {
        while ($row = $result->fetch_assoc()) {
            $sqlstmt2 = $conn->prepare("SELECT libelle FROM espece WHERE id_espece = ?");
            $sqlstmt2->bind_param("i", $row['id_espece']);
            $sqlstmt2->execute();

            $result2 = $sqlstmt2->get_result();

            if($result2->num_rows > 0){
                $row2 = $result2->fetch_assoc();

                if(isset($row2['libelle'])){
                    $espece = $row2['libelle'];
                }
            }
            $affichage[] = array(
                "status" => "success",
                "message" => "Data Affichage successfully",
                "espece" => $espece,
                "id_espece" => $row['id_espece']);
        }
    }

}else{
    $affichage[] = array("status" => "failed", "message" => "Erreur");
}
echo json_encode($affichage, JSON_PRETTY_PRINT);