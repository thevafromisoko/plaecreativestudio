<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Invalid email format.";
        exit;
    }

    // 1. Send notification email to you
    $to = "studioplae@gmail.com";
    $subject = "New Lead Magnet Subscriber";
    $body = "New subscriber email: $email\n\nSource: Website Checklist Form";
    $headers = "From: Plae Website <no-reply@plaecreativestudio.com>";

    mail($to, $subject, $body, $headers);

    // 2. Log to CSV
    $file = fopen("subscribers.csv", "a");
    fputcsv($file, [date("Y-m-d H:i:s"), $email]);
    fclose($file);

    // 3. Redirect to a simple thank-you message or PDF
    header("Location: checklist.pdf");
    exit;

} else {
    http_response_code(403);
    echo "There was a problem with your submission. Please try again.";
}
?>
