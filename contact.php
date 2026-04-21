
<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.html');
    exit;
}

$name     = htmlspecialchars(strip_tags(trim($_POST['name'] ?? '')));
$email    = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$business = htmlspecialchars(strip_tags(trim($_POST['business'] ?? 'Not provided')));
$budget   = htmlspecialchars(strip_tags(trim($_POST['budget'] ?? 'Not specified')));
$message  = htmlspecialchars(strip_tags(trim($_POST['message'] ?? '')));

$errors = [];
if (empty($name))    $errors[] = 'Name is required.';
if (empty($message)) $errors[] = 'Message is required.';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email required.';

if (!empty($errors)) {
    foreach ($errors as $e) echo htmlspecialchars($e) . "<br>";
    exit;
}

$to      = 'waindimian@outlook.com'; 
$subject = "New project inquiry from $name — $business";
$body    = "Name: $name\nEmail: $email\nBusiness: $business\nBudget: $budget\n\nMessage:\n$message";
$headers = "From: noreply@ianwaindim.com\r\nReply-To: $email";

if (mail($to, $subject, $body, $headers)) {
    header('Location: index.html?sent=1');
} else {
    echo "There was a problem sending your message. Please email me directly.";
}
exit;
?>