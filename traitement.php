<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root"; // Votre utilisateur MySQL
$password = ""; // Votre mot de passe MySQL
$dbname = "conf"; // Nom de la base de données

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifiez la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupérer les données du formulaire
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Validation des données
if ($password !== $confirm_password) {
    die("Les mots de passe ne correspondent pas.");
}

// Sécuriser les données
$first_name = $conn->real_escape_string($first_name);
$last_name = $conn->real_escape_string($last_name);
$email = $conn->real_escape_string($email);
$password_hashed = password_hash($password, PASSWORD_BCRYPT); // Hachage du mot de passe

// Insérer les données dans la table
$sql = "INSERT INTO users (first_name, last_name, email, password) 
        VALUES ('$first_name', '$last_name', '$email', '$password_hashed')";

if ($conn->query($sql) === TRUE) {
   // echo "Enregistrement réussi. <a href='register.php'></a>";
   // Rediriger vers la page register.php
   header("Location: register.php");
   exit();
} else {
    echo "Erreur : " . $sql . "<br>" . $conn->error;
}

// Fermer la connexion
$conn->close();
?>
