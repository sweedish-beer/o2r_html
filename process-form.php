// Created by IB | https://iakov.pro/landing  | TG: @Iakov_Belyaev
// This is the processing for when a form is submitted. 
//It takes user to a page called "thanks.html", aswell as sending an email to the specified address.

<?php
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize it
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"]));
    $message = trim($_POST["message"]);
    
    // Check that required data exists
    if (empty($name) OR empty($message) OR empty($subject) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Set a 400 (bad request) response code and exit
        http_response_code(400);
        echo "Please complete the form and try again.";
        exit;
    }
    
    // Set the recipient email address
    $recipient = "admin@o2r.events"; // CHANGE THIS TO YOUR EMAIL
    
    // Set the email subject
    $email_subject = "Contact Form: $subject";
    
    // Build the email content
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Subject: $subject\n\n";
    $email_content .= "Message:\n$message\n";
    
    // Build the email headers
    $email_headers = "From: $name <$email>";
    
    // Send the email
    if (mail($recipient, $email_subject, $email_content, $email_headers)) {
        // Set a 200 (success) response code
        http_response_code(200);
        header("Location: thanks.html"); // Redirect to a thank you page
        exit;
    } else {
        // Set a 500 (internal server error) response code
        http_response_code(500);
        echo "Oops! Something went wrong and we couldn't send your message.";
        exit;
    }
} else {
    // Not a POST request, set a 403 (forbidden) response code
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}
?>