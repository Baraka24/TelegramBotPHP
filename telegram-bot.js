// Replace with your bot token
const botToken = "TOKEN";

// Function to delete the webhook
async function deleteWebhook(botToken) {
    const url = `https://api.telegram.org/bot${botToken}/deleteWebhook`;

    try {
        const response = await fetch(url, { method: 'POST' });
        const responseData = await response.json();

        if (responseData.ok) {
            console.log("Webhook was deleted successfully.");
            return true;
        } else {
            console.log("Failed to delete webhook: " + responseData.description);
            return false;
        }
    } catch (error) {
        console.log('Error:', error);
        return false;
    }
}

// Function to get the chat ID
async function getChatId(botToken) {
    const url = `https://api.telegram.org/bot${botToken}/getUpdates`;

    try {
        const response = await fetch(url);
        const responseData = await response.json();

        if (responseData.ok) {
            if (responseData.result.length > 0) {
                const chatId = responseData.result[0].message.chat.id;
                console.log("Your chat ID is: " + chatId);
                return chatId;
            } else {
                console.log("No messages found. Please send a message to your bot first.");
                return false;
            }
        } else {
            console.log("Failed to get chat ID: " + responseData.description);
            return false;
        }
    } catch (error) {
        console.log('Error:', error);
        return false;
    }
}

// Handle form submission
async function handleSubmit(event) {
    event.preventDefault();

    const name = event.target.name.value;
    const email = event.target.email.value;
    const message = event.target.message.value;

    // Format message for Telegram
    const text = `New Contact Form Submission:\n\nName: ${name}\nEmail: ${email}\nMessage: ${message}`;

    // Get the chat ID
    const chatId = await getChatId(botToken);
    if (chatId) {
        // Telegram API URL
        const url = `https://api.telegram.org/bot${botToken}/sendMessage`;

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    'chat_id': chatId,
                    'text': text
                })
            });
            const responseData = await response.json();

            if (responseData.ok) {
                console.log("Message sent successfully!");
            } else {
                console.log("Failed to send message: " + responseData.description);
            }
        } catch (error) {
            console.log('Error:', error);
        }
    }
}

// Delete the webhook first and then set up form submission handling
deleteWebhook(botToken).then(deleted => {
    if (deleted) {
        document.querySelector('form').addEventListener('submit', handleSubmit);
    }
});
