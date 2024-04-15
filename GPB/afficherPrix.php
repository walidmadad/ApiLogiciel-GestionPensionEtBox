<?php
require_once 'database.php';

if (!empty($_POST['id_pension']) && !empty($_POST['id_typeGardiennage'])) {
    $id_pension = $_POST['id_pension'];
    $id_typeGardiennage = $_POST['id_typeGardiennage'];
    $conn = connectToDatabase();

    $superficie = "";
    $tarif = "";

    if ($conn) {
        $sqlstmt = $conn->prepare("SELECT tarif FROM tarification WHERE Pension_id = ? AND Type_Gardiennage_id = ?");

        $sqlstmt->bind_param("ii", $id_pension, $id_typeGardiennage);
        $sqlstmt->execute();

        $result = $sqlstmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $tarif = $row['tarif'];
            }
        } else {
            echo "Aucun tarif trouvé pour cette combinaison Pension_id et Type_Gardiennage_id.";
            exit; // Terminer le script ici si aucun tarif n'est trouvé
        }

        $sqlstmt2 = $conn->prepare("SELECT superficie, id_box FROM box WHERE id_pension = ? AND id_TypeGardiennage = ?");

        $sqlstmt2->bind_param("ii", $id_pension, $id_typeGardiennage);
        $sqlstmt2->execute();

        $result2 = $sqlstmt2->get_result();

        if ($result2->num_rows > 0) {
            while ($row = $result2->fetch_assoc()) {
                $superficie = $row['superficie'];
                $id_box = $row['id_box'];
            }
        } else {
            echo "Aucune superficie trouvée pour cette combinaison Pension_id et Type_Gardiennage_id.";
            exit; // Terminer le script ici si aucune superficie n'est trouvée
        }

        $sqlstmt2->close();
        $sqlstmt->close();

        // Créer un tableau contenant les données récupérées
        $response = array(
            "status" => "success",
            "tarif" => $tarif,
            "superficie" => $superficie,
            "id_box" => $id_box
        );

        // Retourner les données sous forme de réponse JSON
        echo json_encode($response);
    } else {
        echo "Erreur lors de la connexion à la base de données: " . mysqli_connect_error();
    }
} else {
    echo "Les paramètres id_pension et id_typeGardiennage sont manquants ou vides.";
}
?>
