<?php
require 'database.php';

if (!empty($_POST['prenom']) && !empty($_POST['nom'])){
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];

    $conn = connectToDatabase();

        $sql = "SELECT id_animal, nom_animal FROM animal WHERE id_proprietaire IN " .
            "(SELECT id_proprietaire FROM proprietaire WHERE nom_Propietaire = ? AND prenom_Propietaire = ?)";

        $stmt = $conn->prepare($sql);

        $stmt->execute(array($nom, $prenom));

        $result = $sql->getresult();

        $affichage = array();
    if ($conn) {
        while ($row = $result->fetch_assoc()) {
            $affichage[] = array("status" => "success", "message" => "Data Affichage successfully", "id_espece" => $row['id_espece'], "libelle" => $row['libelle']);
        }
    } else {
        $affichage = array("status" => "failed", "message" => "Error executing statement: " . mysqli_error($conn));
    }

}
?>
