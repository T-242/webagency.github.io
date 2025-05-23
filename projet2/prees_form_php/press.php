<?php
header('Content-Type: application/json');

// Vérification du token (protection contre les bots)
if (!isset($_POST['_gotcha']) {
    echo json_encode(['success' => false, 'message' => 'Accès non autorisé']);
    exit;
}

// Récupération des données
$nom = htmlspecialchars($_POST['nom'] ?? '');
$email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
$service = htmlspecialchars($_POST['service'] ?? '');
$message = htmlspecialchars($_POST['message'] ?? '');

// Validation
if (empty($nom) || empty($email) || empty($message)) {
    echo json_encode(['success' => false, 'message' => 'Tous les champs requis doivent être remplis']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Adresse email invalide']);
    exit;
}

// Configuration de l'email
$to = 'contact@webagency.com';
$subject = 'Nouveau message de ' . $nom . ' - Service: ' . $service;
$headers = "From: $email\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

$email_body = "Nom: $nom\n";
$email_body .= "Email: $email\n";
$email_body .= "Service intéressé: $service\n\n";
$email_body .= "Message:\n$message";

// Envoi de l'email
if (mail($to, $subject, $email_body, $headers)) {
    echo json_encode(['success' => true, 'message' => 'Votre message a été envoyé avec succès. Nous vous contacterons bientôt.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Une erreur est survenue lors de l\'envoi du message. Veuillez réessayer.']);
}
?>