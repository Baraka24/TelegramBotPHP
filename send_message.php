<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Telegram bot token and chat ID
    $botToken = "TOKEN";
    $chatId = "ID";

    // Capture form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Format message for Telegram
    $text = "New Contact Form Submission:\n\n";
    $text .= "Name: $name\n";
    $text .= "Email: $email\n";
    $text .= "Message: $message";

    // Telegram API URL
    $url = "https://api.telegram.org/bot$botToken/sendMessage";

    // Initialize cURL session
    $ch = curl_init();

    // cURL options
    $options = [
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => http_build_query([
            'chat_id' => $chatId,
            'text' => $text
        ]),
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/x-www-form-urlencoded"
        ]
    ];

    // Set cURL options
    curl_setopt_array($ch, $options);

    // Execute cURL request
    $response = curl_exec($ch);

    // Check for errors
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    } else {
        // Decode the response
        $responseData = json_decode($response, true);
        if ($responseData['ok']) {
            echo "Message sent successfully!";
        } else {
            echo "Failed to send message: " . $responseData['description'];
        }
    }

    // Close cURL session
    curl_close($ch);
} else {
    echo "Invalid request method.";
}
?>
