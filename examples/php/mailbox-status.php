<?php
declare(strict_types=1);

$curl = curl_init('https://api.mailbridgeapi.com/mailbox/status/');
curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 20,
    CURLOPT_HTTPHEADER => [
        'X-API-Key: ' . (getenv('MAILBRIDGE_ACCOUNT_KEY') ?: ''),
        'X-Mailbox-Key: ' . (getenv('MAILBRIDGE_MAILBOX_KEY') ?: ''),
        'Accept: application/json',
    ],
]);
$body = curl_exec($curl);
if ($body === false) {
    throw new RuntimeException(curl_error($curl));
}
$status = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);
if ($status >= 400) {
    throw new RuntimeException('Status request failed: ' . $body);
}
print_r(json_decode($body, true, 512, JSON_THROW_ON_ERROR));

