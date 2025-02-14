
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $country = trim($_POST["country"]);

    $errors = [];

    // Validate Name
    if (empty($name)) {
        $errors[] = "Name is required.";
    }

    // Validate Email
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // Validate Phone
    if (empty($phone)) {
        $errors[] = "Phone number is required.";
    } elseif (!preg_match("/^[0-9]{10,15}$/", $phone)) {
        $errors[] = "Invalid phone number format.";
    }

    // Validate Country (Dropdown)
    $valid_countries = ["Russia", "China", "Philippines", "Uzbekistan"];
    if (empty($country) || !in_array($country, $valid_countries)) {
        $errors[] = "Please select a valid country.";
    }

    // If no errors, process the form
    if (empty($errors)) {
        $to = $email;
        $subject = "New Contact Form Submission";
        $email_body = "Name: $name\nEmail: $email\nPhone: $phone\n\nMessage:\n$message";
        $headers = "From: $email\r\nReply-To: $email";

        if (mail($to, $subject, $email_body, $headers)) {
            echo "Email sent successfully!";
        } else {
            echo "Email failed to send.";
        }
    } else {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
    }
}
?>
