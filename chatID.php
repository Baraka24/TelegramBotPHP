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
    } else {
        // Decode the response
        $responseData = json_decode($response, true);
        if ($responseData['ok']) {
            echo "Webhook was deleted successfully.<br>";
        } else {
            echo "Failed to delete webhook: " . $responseData['description'] . "<br>";
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
    } else {
        // Decode the response
        $responseData = json_decode($response, true);
        if ($responseData['ok']) {
            // Extract the chat ID from the response
            if (!empty($responseData['result'])) {
                $chatId = $responseData['result'][0]['message']['chat']['id'];
                echo "Your chat ID is: $chatId<br>";
            } else {
                echo "No messages found. Please send a message to your bot first.<br>";
            }
        } else {
            echo "Failed to get chat ID: " . $responseData['description'] . "<br>";
        }
    }

    // Close cURL session
    curl_close($ch);
}

// Delete the webhook first
deleteWebhook($botToken);

// Then get the chat ID
getChatId($botToken);
?>