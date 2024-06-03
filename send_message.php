<?php
// Replace with your bot token
$botToken = "TOKEN";

// Function to delete the webhook
function deleteWebhook($botToken) {
    $url = "https://api.telegram.org/bot$botToken/deleteWebhook";

    // Initialize cURL session
    $ch = curl_init();

    // cURL options
    $options = [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
    ];

    curl_setopt_array($ch, $options);

    // Execute cURL request
    $response = curl_exec($ch);

    // Check for errors
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
        return false;
    } else {
        // Decode the response
        $responseData = json_decode($response, true);
        if ($responseData['ok']) {
            echo "Webhook was deleted successfully.<br>";
            return true;
        } else {
            echo "Failed to delete webhook: " . $responseData['description'] . "<br>";
            return false;
        }
    }

    // Close cURL session
    curl_close($ch);
}

// Function to get the chat ID
function getChatId($botToken) {
    $url = "https://api.telegram.org/bot$botToken/getUpdates";

    // Initialize cURL session
    $ch = curl_init();

    // cURL options
    $options = [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
    ];

    curl_setopt_array($ch, $options);

    // Execute cURL request
    $response = curl_exec($ch);

    // Check for errors
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
        return false;
    } else {
        // Decode the response
        $responseData = json_decode($response, true);
        if ($responseData['ok']) {
            // Extract the chat ID from the response
            if (!empty($responseData['result'])) {
                $chatId = $responseData['result'][0]['message']['chat']['id'];
                echo "Your chat ID is: $chatId<br>";
                return $chatId;
            } else {
                echo "No messages found. Please send a message to your bot first.<br>";
                return false;
            }
        } else {
            echo "Failed to get chat ID: " . $responseData['description'] . "<br>";
            return false;
        }
    }

    // Close cURL session
    curl_close($ch);
}

// Delete the webhook first
if (deleteWebhook($botToken)) {
    // Get the chat ID
    $chatId = getChatId($botToken);
    if ($chatId) {
        // Handle form submission
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
    }
}
?>