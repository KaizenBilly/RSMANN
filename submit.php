<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contact.html');
    exit;
}

$firstName = htmlspecialchars(trim($_POST['firstName'] ?? ''));
$lastName  = htmlspecialchars(trim($_POST['lastName'] ?? ''));
$email     = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$phone     = htmlspecialchars(trim($_POST['phone'] ?? ''));
$service   = htmlspecialchars(trim($_POST['service'] ?? ''));
$postcode  = htmlspecialchars(trim($_POST['postcode'] ?? ''));
$message   = htmlspecialchars(trim($_POST['message'] ?? ''));

if (empty($firstName) || empty($lastName) || empty($email) || empty($phone) || empty($message)) {
    header('Location: contact.html?status=error');
    exit;
}

$to      = 'info@rsmann.co.uk, billy@kaizensolutionsuk.com';
$subject = "New Enquiry from {$firstName} {$lastName} – RSM Website";

$body  = "You have a new enquiry from the RSM website.\n\n";
$body .= "Name:     {$firstName} {$lastName}\n";
$body .= "Email:    {$email}\n";
$body .= "Phone:    {$phone}\n";
$body .= "Service:  {$service}\n";
$body .= "Postcode: {$postcode}\n\n";
$body .= "Message:\n{$message}\n";

$headers  = "From: RSM Mann <info@rsmann.co.uk>\r\n";
$headers .= "Reply-To: {$email}\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

if (mail($to, $subject, $body, $headers)) {
    header('Location: contact.html?status=success');
} else {
    header('Location: contact.html?status=error');
}
exit;
