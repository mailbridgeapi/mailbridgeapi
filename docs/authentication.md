# Authentication and security

Every mailbox request is scoped by two keys. The account key identifies the customer account; the mailbox key selects a mailbox that belongs to that account.

## Recommended headers

```http
X-API-Key: YOUR_ACCOUNT_API_KEY
X-Mailbox-Key: YOUR_MAILBOX_API_KEY
```

The account key may alternatively use a Bearer header:

```http
Authorization: Bearer YOUR_ACCOUNT_API_KEY
X-Mailbox-Key: YOUR_MAILBOX_API_KEY
```

Use headers with `/mailbox/status/`, `/mailbox/insights/`, `/email/sent/`, `/email/received/`, `/email/message/`, `/email/search/`, `/email/activity/`, and `/email/validate/`.

## Original endpoint fields

`/sendemail/`, `/getemail/`, and `/email/unsubscribed/` accept:

- `apikey`: account API key
- `apikeybox`: mailbox API key

Send them as form fields for `POST /sendemail/` and as query parameters for the original `GET` endpoints.

## Rules for production

1. Keep both keys on your server. Never embed them in browser JavaScript, mobile binaries, public repositories, logs, analytics, or screenshots.
2. Use environment variables or a secret manager.
3. Give each external project a meaningful `from_source` value when sending.
4. Remove access from the MailBridgeAPI dashboard if a project or server is compromised.
5. Rotate the mailbox password only in MailBridgeAPI; connected projects continue using the MailBridgeAPI keys.
6. Use HTTPS exclusively.

## `.env` example

```dotenv
MAILBRIDGE_BASE_URL=https://api.mailbridgeapi.com
MAILBRIDGE_ACCOUNT_KEY=replace_with_your_account_key
MAILBRIDGE_MAILBOX_KEY=replace_with_your_mailbox_key
```

The included [`.env.example`](../.env.example) contains placeholders only.

