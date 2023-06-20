<?php
$host = "localhost";
$dbname = "makgoo";
$username = "root";
$password = "secret";

try {
  $bdd = new PDO("mysql:host=$host; port=3306; dbname=$dbname;", $username, $password);
  $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Données à insérer
  $title_column = "Nouvelle colonne";
  $id_user = 1;

  // Vérifier si l'utilisateur existe dans la table "user"
  $checkUserQuery = $bdd->prepare("SELECT * FROM user WHERE id_user = :id");
  $checkUserQuery->bindParam(":id", $id_user);
  $checkUserQuery->execute();
  $userExists = $checkUserQuery->rowCount() > 0;

  if ($userExists) {
    // Requête préparée
    $query = $bdd->prepare("INSERT INTO `column` (title_column, id_user) VALUES (:title, :user)");

    // Liaison des paramètres
    $query->bindParam(":title", $title_column);
    $query->bindParam(":user", $id_user);

    // Exécution de la requête
    $query->execute();

    echo "Nouvelle colonne insérée avec succès !";
  } else {
    echo "L'utilisateur avec l'ID $id_user n'existe pas dans la table 'user'.";
  }
} catch (PDOException $e) {
  die('Erreur : ' . $e->getMessage());
}
?>