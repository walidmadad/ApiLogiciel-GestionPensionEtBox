<?php
require_once 'database.php';

$response = array();

if (!empty($_POST['id_pension'])){
    $id_pension = $_POST['id_pension'];
    $conn = connectToDatabase();

    if ($conn) {
        $sqlstmt = $conn->prepare("SELECT * FROM pension WHERE id_pension = ?");
        $sqlstmt->bind_param("s", $id_pension);
        $sqlstmt->execute();

        $result = $sqlstmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $response = array("status" => "success", "message" => "Data Affichage successfully", "ville_pension" => $row['ville_pension'], "adresse_pension" => $row['adresse_pension'], "telephone_pension" => $row['telephone_pension'], "responsable_pension" => $row['responsable_pension'], "email_pension" => $row['email']);
            }
        } else {
            $response = array("status" => "failed", "message" => "No data found for ID: $id_pension");
        }
    } else {
        $response = array("status" => "failed", "message" => "Error connecting to database");
    }
} else {
    $response = array("status" => "failed", "message" => "ID_pension is empty");
}

echo json_encode($response);
?>
