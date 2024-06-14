<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$response = array(); // Create an array to hold response data

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
     
    require_once "vendor/autoload.php";
     
    $mail = new PHPMailer(true);
     
    try {
        $mail->isSMTP();
        $mail->Host = 'in-v3.mailjet.com'; // host
        $mail->SMTPAuth = true;
        $mail->Username = ''; //username
        $mail->Password = ''; //password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587; //smtp port for TLS
       
        $mail->setFrom($email, $name);
        $mail->addAddress($email, 'John');
     
        $mail->isHTML(true);
        $mail->Subject = 'Message from ' . $name;
        $mail->Body    = '<p><b>Name:</b> ' . $name . '</p><p><b>Email:</b> ' . $email . '</p><p><b>Message:</b> ' . $message . '</p>';
     
        $mail->send();
        
        $response['status'] = 'success'; // Set status to success
        $response['message'] = 'Email sent successfully.';
    } catch (Exception $e) {
        $response['status'] = 'error'; // Set status to error
        $response['message'] = 'Email could not be sent. Mailer Error: '. $mail->ErrorInfo;
    }
    
    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
