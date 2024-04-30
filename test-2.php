<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Replace these variables with your own email and subject
    $toEmail = "balaji.gahire@gmail.com";
    $subject = "Contact Form Submission";

    // Collect form data
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $message = trim($_POST["message"]);

    // Check if data is valid
    if (!empty($name) && !empty($email) && !empty($message)) {
        // Construct email message
        $mailContent = "Name: $name\n";
        $mailContent .= "Email: $email\n\n";
        $mailContent .= "Message:\n$message";

        // Set headers
        $headers = "From: $name <$email>\r\n";
        $headers .= "Reply-To: $email\r\n";

        // Send email
        if (mail($toEmail, $subject, $mailContent, $headers)) {
            $status = "success";
            $message = "Your message has been sent successfully.";
        } else {
            $status = "error";
            $message = "Oops! Something went wrong. Please try again later.";
        }
    } else {
        $status = "error";
        $message = "Please fill out all the fields.";
    }

    // Return status and message
    echo json_encode(array("status" => $status, "message" => $message));
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
</head>
<body>
    <h1>Contact Us</h1>
    <div id="form-messages"></div>
    <form id="contact-form" method="post" action="">
        <div>
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name" required>
        </div>
        <div>
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="message">Message:</label><br>
            <textarea id="message" name="message" rows="4" required></textarea>
        </div>
        <div>
            <button type="submit">Send</button>
        </div>
    </form>

    <script>
        const form = document.getElementById('contact-form');
        const formMessages = document.getElementById('form-messages');

        form.addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                formMessages.innerHTML = '<div>' + data.message + '</div>';
                if (data.status === 'success') {
                    form.reset();
                }
            })
            .catch(error => {
                formMessages.innerHTML = '<div>Oops! An error occurred.</div>';
            });
        });
    </script>
</body>
</html>
