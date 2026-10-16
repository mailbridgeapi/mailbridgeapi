<?php
declare(strict_types=1);

$accountKey = getenv('MAILBRIDGE_ACCOUNT_KEY') ?: '';
$mailboxKey = getenv('MAILBRIDGE_MAILBOX_KEY') ?: '';

if ($accountKey === '' || $mailboxKey === '') {
    throw new RuntimeException('Set MAILBRIDGE_ACCOUNT_KEY and MAILBRIDGE_MAILBOX_KEY.');
}

$payload = http_build_query([
    'apikey' => $accountKey,
    'apikeybox' => $mailboxKey,
    'recipient_email' => 'customer@example.com',
    'mail_subject' => 'Hello from PHP',
    'mail_body' => '<p>Your own mailbox is connected to your PHP application.</p>',
    'format' => 'html',
    'from_source' => 'php-example',
]);

$curl = curl_init('https://api.mailbridgeapi.com/sendemail/');
curl_setopt_array($curl, [
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $payload,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded'],
]);

$body = curl_exec($curl);
if ($body === false) {
    throw new RuntimeException(curl_error($curl));
}
$status = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

$response = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
if ($status >= 400 || (string)($response['result']['error'] ?? '') !== '0') {
    throw new RuntimeException('MailBridgeAPI send failed: ' . $body);
}

echo 'Sent message id: ' . ($response['result']['id'] ?? 'unknown') . PHP_EOL;

