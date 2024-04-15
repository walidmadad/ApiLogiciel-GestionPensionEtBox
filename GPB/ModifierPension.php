<?php
require_once 'database.php';
if (!empty($_POST['id_pension']) && !empty($_POST['ville']) && !empty($_POST['responsable']) && !empty($_POST['tel']) && !empty($_POST['adresse']) && !empty($_POST['email'])) {
    $id = $_POST['id_pension'];
    $ville = $_POST['ville'];
    $responsable = $_POST['responsable'];
    $tel = $_POST['tel'];
    $adresse = $_POST['adresse'];
    $email = $_POST['email'];

    $conn = connectToDatabase();
    if($conn){

        $sqlstmt2 = $conn->prepare("UPDATE pension SET ville_pension = ? , adresse_pension = ? , telephone_pension= ? , responsable_pension = ?, email = ? WHERE id_pension = ? ");
        $sqlstmt2->bind_param("sssssi", $ville,$adresse , $tel, $responsable, $email, $id);
        $sqlstmt2->execute();

        $sqlstmt2->close();
        echo json_encode(array("status" => "success", "message" => "Les données ont été modifiées avec succès."));
    } else {
        echo json_encode(array("status" => "error", "message" => "Erreur lors de la connexion à la base de données"));
    }
} else {
    echo json_encode(array("status" => "error", "message" => "Paramètres manquants"));
}
?>

