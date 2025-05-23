<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $nom = strip_tags($_POST["nom"]);
  $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
  $message = htmlspecialchars($_POST["message"]);

  if (!empty($nom) && filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($message)) {
    $to = "tonemail@exemple.com";
    $subject = "Nouveau message de $nom";
    $body = "Nom: $nom\nEmail: $email\n\nMessage:\n$message";
    $headers = "From: $nom <$email>";

    if (mail($to, $subject, $body, $headers)) {
      http_response_code(200);
      echo "Message envoyé.";
    } else {
      http_response_code(500);
      echo "Erreur serveur.";
    }
  } else {
    http_response_code(400);
    echo "Champs invalides.";
  }
}
?>
