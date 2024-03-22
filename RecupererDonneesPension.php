<?php
require_once 'database.php';
if (!empty($_POST['id_pension'])){

    $id_pension = $_POST['id_pension'];

    $conn = connectToDatabase();
    $sqlstmt = $conn->prepare("SELECT * FROM pension WHERE id_pension = $id_pension");
    $sqlstmt->execute();

    $result = $sqlstmt->get_result();

    $affichage = array();
    if($conn) {
        while ($row = $result->fetch_assoc()) {
            $affichage[] = array("status" => "success", "message" => "Data Affichage successfully", "ville_pension" => $row['ville_pension'], "adresse_pension" => $row['adresse_pension'], "telephone_pension" => $row['telephone_pension'], "responsable_pension" => $row['responsable_pension'], "email_pension" => $row['email_pension']);
        }
    } else {
        $affichage = array("status" => "failed", "message" => "Error executing statement: " . mysqli_error($conn));
    }
}
