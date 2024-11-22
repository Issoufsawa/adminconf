<?php

// Inclusion de la bibliothèque PHPMailer
require 'vendor/autoload.php'; // Assurez-vous que le chemin vers autoload.php est correct
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $first_name = htmlspecialchars($_POST['first_name']);  // Prénom
    $subject = htmlspecialchars($_POST['subject']);        // Sujet de l'email
    $emails = htmlspecialchars($_POST['emails']);          // Emails séparés par des virgules
    $message = htmlspecialchars($_POST['text']);           // Contenu du message

    // Diviser les emails en tableau
    $email_list = explode(',', $emails);
    $invalid_emails = [];  // Tableau pour les emails invalides

    // Créer une instance de PHPMailer
    $mail = new PHPMailer(true);
    
    try {
        // Configuration SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';         // Serveur SMTP de Gmail
        $mail->SMTPAuth = true;
        $mail->Username = 'sawadogoissoufoo7@gmail.com'; // Votre adresse email (remplacez par votre propre adresse)
        $mail->Password = 'xknpkzjikcbkldt'; // Mot de passe ou clé d'application (jamais en clair dans le code)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Sécurisation de la connexion
        $mail->Port = 587; // Port SMTP de Gmail

        // Configurer l'expéditeur
        $mail->setFrom('sawadogoissoufoo7@gmail.com', 'Issouf'); // L'adresse et le nom de l'expéditeur

        // Ajouter les destinataires
        foreach ($email_list as $email) {
            $email = trim($email); // Supprimer les espaces inutiles
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $mail->addBCC($email); // Ajouter l'email à la liste des destinataires en copie cachée (BCC)
            } else {
                $invalid_emails[] = $email; // Ajouter l'email invalide à la liste
            }
        }

        // Vérifier si des emails valides ont été fournis
        if (count($mail->getBccAddresses()) === 0) {
            echo "Aucun email valide n'a été fourni.";
            exit;
        }

        // Si des emails sont invalides, les afficher
        if (!empty($invalid_emails)) {
            echo "Les emails suivants sont invalides : " . implode(', ', $invalid_emails) . "<br>";
        }

        // Contenu de l'email
        $mail->isHTML(true); // Le contenu est au format HTML
        $mail->Subject = $subject;  // Sujet de l'email
        $mail->Body = "
            <h3>Message de $first_name</h3>
            <p>$message</p>
        ";  // Corps de l'email

        // Envoyer l'email
        $mail->send();
        echo "Les emails ont été envoyés avec succès !";

    } catch (Exception $e) {
        // En cas d'erreur lors de l'envoi
        echo "Erreur lors de l'envoi de l'email : {$mail->ErrorInfo}";
    }


    

}

?>
