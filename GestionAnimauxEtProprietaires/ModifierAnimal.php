<?php
require_once 'database.php';

if (
    isset($_POST['id_animal'], $_POST['nom_animal'], $_POST['id_espece'])
) {
    $id_animal = $_POST['id_animal'];
    $nom_animal = $_POST['nom_animal'];
    $id_espece = $_POST['id_espece'];

    $conn = connectToDatabase();
    $affichage = array();
    if ($conn) {

        $sqlstmt1 = $conn->prepare("UPDATE animal SET nom_animal=?, id_espece=? WHERE id_animal=?");
        $sqlstmt1->bind_param("sii", $nom_animal, $id_espece, $id_animal);
        if ($sqlstmt1->execute()) {
            $affichage[] = array(
                "status" => "success",
                "message" => "Animal Modifier");

        } else {
            $affichage[] = array(
                "status" => "erreur",
                "message" => "Échec de la mise à jour des informations de l'animal :");

        }
    } else {
        $affichage[] = array(
            "status" => "erreur",
            "message" => "Échec de la connexion à la base de données");
    }
} else {
    $affichage[] = array(
        "status" => "erreur",
        "message" => "Tous les champs sont obligatoires");
}
echo json_encode($affichage,JSON_PRETTY_PRINT);
?>
