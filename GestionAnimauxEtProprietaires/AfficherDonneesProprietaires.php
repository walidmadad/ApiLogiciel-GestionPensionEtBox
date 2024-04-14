<?php
require_once 'database.php';
if(!empty($_POST['id'])) {
    $id_proprietaire = $_POST['id'];
    $conn = connectToDatabase();

    $sqlstmt = $conn->prepare("SELECT * FROM proprietaire WHERE id_proprietaire = ?");
    $sqlstmt->bind_param("i", $id_proprietaire);
    $sqlstmt->execute();

    $result = $sqlstmt->get_result();
    $sqlstmt->execute();
    $affichage = array();
    if ($conn) {
        while ($row = $result->fetch_assoc()) {
            $affichage[] = array(
                "status" => "success",
                "message" => "Data Affichage successfully",
                "nom" => $row['nom_Propietaire'],
                "prenom" => $row['prenom_Propietaire'],
                "email" => $row['email_Proprietaire'],
                "adresse" => $row['Adresse_Propietaire'],
                "tel" =>$row['TELEPHONE_Propietaire'],
                "dateNaissance" => $row['date_naissance_proprietaire']
            );
        }
    } else {
        $affichage = array("status" => "failed", "message" => "Error executing statement: " . mysqli_error($conn));
    }
}else{
    $affichage = array("status" => "failed", "message" => "ID Incorrect ");
}
echo json_encode($affichage, JSON_PRETTY_PRINT);
?>
<?php
