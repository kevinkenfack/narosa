<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier et filtrer les données
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

    // Validation
    $errors = [];
    if (empty($name)) $errors[] = "Le nom est requis.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "L'email est invalide.";
    if (empty($phone)) $errors[] = "Le numéro est requis.";
    if (empty($message)) $errors[] = "Le message est requis.";

    if (empty($errors)) {
        // Préparer l'email
        $to = "votre.email@exemple.com"; // Remplacez par votre adresse email
        $subject = "Nouveau message de contact";
        $body = "Nom: $name\nEmail: $email\nTéléphone: $phone\n\nMessage:\n$message";
        $headers = "From: $email\r\nReply-To: $email\r\n";

        // Envoyer l'email
        if (mail($to, $subject, $body, $headers)) {
            header("Location: index.html?success=1");
            exit();
        } else {
            header("Location: index.html?errors=" . urlencode("Désolé, une erreur est survenue. Veuillez réessayer plus tard."));
            exit();
        }
    } else {
        // Redirection avec les erreurs
        header("Location: index.html?errors=" . urlencode(implode('|', $errors)));
        exit();
    }
}
?>
