<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader or require the necessary files directly
require '../PHP-mailer/Exception.php';
require '../PHP-mailer/PHPMailer.php';
require '../PHP-mailer/SMTP.php';

// Set response header for JSON
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the required fields are set
    if (isset($_POST['name'], $_POST['email'], $_POST['subject'], $_POST['message'])) {
        
        // Collect and sanitize form data
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $subject = trim($_POST['subject']);
        $message = trim($_POST['message']);

        // Validate email address
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid email format.']);
            exit; // Stop further execution
        }

        // Create an instance of PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();                                      // Send using SMTP
            $mail->Host = 'smtp.gmail.com';                     // Set the SMTP server to send through
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'deebawa48@gmail.com';           // SMTP username (replace with your email)
            $mail->Password = ${PASSWORD};              // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   // Enable TLS encryption
            $mail->Port = 587;                                    // TCP port to connect to

            // Recipients
            $mail->setFrom($email, $name);                        // Sender
            $mail->addAddress('deebawa48@gmail.com');             // Add your email (replace this)

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = "Name: $name<br>Email: $email<br>Message:<br>$message";

            // Send the email
            $mail->send();
            header('Content-Type: application/json');
            http_response_code(200); // Explicitly set the status code
            echo json_encode(['status' => 'success', 'message' => 'Your message has been sent. Thank you!']);
            exit; // Stop further execution after success
            
        } catch (Exception $e) {
          header('Content-Type: application/json');
          http_response_code(500); // Set a server error status code
          echo json_encode(['status' => 'error', 'message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
          exit; // Stop further execution after error
        }
    } else {
        // Missing form fields
        echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
        exit; // Stop further execution after error
    }
} else {
    // Redirect to the contact form if the request method is not POST
    header("Location: ../index.html");
    exit();
}
