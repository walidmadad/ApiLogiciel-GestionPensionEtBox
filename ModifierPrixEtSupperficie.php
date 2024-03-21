<?php
require_once 'database.php';

if (!empty($_POST['id_pension']) && !empty($_POST['id_typeGardiennage']) && !empty($_POST['nouveau_tarif']) && !empty($_POST['nouvelle_superficie'])) {
    $id_pension = $_POST['id_pension'];
    $id_typeGardiennage = $_POST['id_typeGardiennage'];
    $nouveau_tarif = $_POST['nouveau_tarif'];
    $nouvelle_superficie = $_POST['nouvelle_superficie'];
    $conn = connectToDatabase();

    if ($conn) {
        $sqlstmt = $conn->prepare("UPDATE tarification SET tarif = ? WHERE Pension_id = ? AND Type_Gardiennage_id = ?");
        $sqlstmt->bind_param("dii", $nouveau_tarif, $id_pension, $id_typeGardiennage);
        $sqlstmt->execute();

        $sqlstmt2 = $conn->prepare("UPDATE box SET superficie = ? WHERE id_pension = ? AND id_TypeGardiennage = ?");
        $sqlstmt2->bind_param("dii", $nouvelle_superficie, $id_pension, $id_typeGardiennage);
        $sqlstmt2->execute();

        $sqlstmt->close();
        $sqlstmt2->close();
        echo json_encode(array("status" => "success", "message" => "Les données ont été modifiées avec succès."));
    } else {
        echo json_encode(array("status" => "error", "message" => "Erreur lors de la connexion à la base de données"));
    }
} else {
    echo json_encode(array("status" => "error", "message" => "Paramètres manquants"));
}
?>
<?php
