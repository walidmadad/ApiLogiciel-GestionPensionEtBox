<?php

require_once 'database.php';

if (!empty($_POST['id_pension']) && !empty($_POST['id_typeGardiennage'])) {
    $id_pension = $_POST['id_pension'];
    $id_typeGardiennage = $_POST['id_typeGardiennage'];
    $conn = connectToDatabase();

    if ($conn) {
        $sqlstmt = $conn->prepare("SELECT superficie, id_box FROM box WHERE id_pension = ? AND id_TypeGardiennage = ?");

        $sqlstmt->bind_param("ii", $id_pension, $id_typeGardiennage);
        $sqlstmt->execute();

        $result = $sqlstmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $superficie = $row['superficie'];
                $id_box = $row['id_box'];
            }
        } else {
            echo "Aucun tarif trouvé pour cette combinaison Pension_id et Type_Gardiennage_id.";
        }

        $sqlstmt->close();
    } else {
        echo "Erreur lors de la connexion à la base de données: " . mysqli_connect_error();
    }
} else {
    echo "Les paramètres id_pension et id_typeGardiennage sont manquants ou vides.";
}


