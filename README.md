# Telegram Bot Webhook Management and Form Submission Notification

This PHP script manages a Telegram bot webhook, retrieves the chat ID, and sends a notification message to the bot when a contact form is submitted.

## Prerequisites

- PHP 7.0 or higher
- A Telegram bot token (obtainable from [BotFather](https://core.telegram.org/bots#botfather))

## Getting Started

### Setup

1. **Clone the repository or download the script.**

2. **Update the script with your Telegram bot token:**

   Replace `"TOKEN"` in the script with your actual Telegram bot token.

### Usage

1. **Delete Webhook and Get Chat ID**

   The script first deletes the current webhook and retrieves the chat ID for message sending.

2. **Form Submission Handling**

   When the form is submitted via POST request, the script captures the form data and sends a formatted message to the specified Telegram chat ID.

### Example Form

Here is an example HTML form that you can use to submit data to this script:

```html
<form action="your-script.php" method="POST">
  <label for="name">Name:</label><br>
  <input type="text" id="name" name="name" required><br>
  <label for="email">Email:</label><br>
  <input type="email" id="email" name="email" required><br>
  <label for="message">Message:</label><br>
  <textarea id="message" name="message" required></textarea><br>
  <input type="submit" value="Submit">
</form>
```

This `README.md` file provides an overview of the script, explains how to set it up and use it, and includes an example form for submitting data to the script. Be sure to replace `"TOKEN"` in the script with your actual Telegram bot token.
