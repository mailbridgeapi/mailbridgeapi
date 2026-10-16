# cURL examples

Set `MAILBRIDGE_ACCOUNT_KEY` and `MAILBRIDGE_MAILBOX_KEY` before running these commands.

## Status

```bash
curl "https://api.mailbridgeapi.com/mailbox/status/" \
  -H "X-API-Key: $MAILBRIDGE_ACCOUNT_KEY" \
  -H "X-Mailbox-Key: $MAILBRIDGE_MAILBOX_KEY"
```

## Send

```bash
curl -X POST "https://api.mailbridgeapi.com/sendemail/" \
  -H "Content-Type: application/x-www-form-urlencoded" \
  --data-urlencode "apikey=$MAILBRIDGE_ACCOUNT_KEY" \
  --data-urlencode "apikeybox=$MAILBRIDGE_MAILBOX_KEY" \
  --data-urlencode "recipient_email=customer@example.com" \
  --data-urlencode "mail_subject=Order update" \
  --data-urlencode "mail_body=<p>Your order is ready.</p>" \
  --data-urlencode "format=html" \
  --data-urlencode "from_source=order-service"
```

## Read recent received messages

```bash
curl "https://api.mailbridgeapi.com/email/received/?per_page=5" \
  -H "X-API-Key: $MAILBRIDGE_ACCOUNT_KEY" \
  -H "X-Mailbox-Key: $MAILBRIDGE_MAILBOX_KEY"
```

## Search

```bash
curl --get "https://api.mailbridgeapi.com/email/search/" \
  -H "X-API-Key: $MAILBRIDGE_ACCOUNT_KEY" \
  -H "X-Mailbox-Key: $MAILBRIDGE_MAILBOX_KEY" \
  --data-urlencode "query=order 12345" \
  --data-urlencode "direction=all"
```

