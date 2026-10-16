# MailBridgeAPI

**Turn your own email mailbox into a secure, programmable API.**

MailBridgeAPI connects your existing mailbox to two API keys. Your applications can then send email through that mailbox, retrieve received messages, search activity, inspect delivery errors, and monitor connectivity without storing the mailbox password in every project.

- Website: [mailbridgeapi.com](https://mailbridgeapi.com/)
- Interactive documentation: [mailbridgeapi.com/doc/](https://mailbridgeapi.com/doc/)
- Live demo: [mailbridgeapi.com/demo/](https://mailbridgeapi.com/demo/)
- Dashboard: [dashboard.mailbridgeapi.com](https://dashboard.mailbridgeapi.com/)
- API base URL: `https://api.mailbridgeapi.com`

> This public repository contains the API contract, documentation, and safe examples. The production service, mailbox credentials, and private infrastructure are not published here.

## Why MailBridgeAPI?

A normal SMTP/IMAP integration copies mailbox credentials into every website, script, and application. When the password changes, every integration must be updated. MailBridgeAPI centralizes the mailbox connection once and gives each project a stable HTTP interface.

```text
Your mailbox (SMTP, IMAP, or Gmail OAuth)
                    │
                    ▼
             MailBridgeAPI
       account key + mailbox key
                    │
          ┌─────────┴─────────┐
          ▼                   ▼
   Send and monitor      Receive and search
   from your projects    from your projects
```

Your application receives API keys, not the SMTP or IMAP password. If the mailbox password or provider settings change, update the connection once in the dashboard.

## Five-minute quick start

1. [Create a MailBridgeAPI account](https://mailbridgeapi.com/signup/).
2. Open **Mailboxes** in the dashboard.
3. Connect SMTP, IMAP, Gmail, or any supported combination.
4. Copy the account API key and the mailbox API key.
5. Store both keys in server-side environment variables.

```bash
export MAILBRIDGE_ACCOUNT_KEY="replace_with_your_account_key"
export MAILBRIDGE_MAILBOX_KEY="replace_with_your_mailbox_key"
```

Check the mailbox connection:

```bash
curl --request GET "https://api.mailbridgeapi.com/mailbox/status/" \
  --header "X-API-Key: $MAILBRIDGE_ACCOUNT_KEY" \
  --header "X-Mailbox-Key: $MAILBRIDGE_MAILBOX_KEY"
```

Send an email:

```bash
curl --request POST "https://api.mailbridgeapi.com/sendemail/" \
  --header "Content-Type: application/x-www-form-urlencoded" \
  --data-urlencode "apikey=$MAILBRIDGE_ACCOUNT_KEY" \
  --data-urlencode "apikeybox=$MAILBRIDGE_MAILBOX_KEY" \
  --data-urlencode "recipient_email=customer@example.com" \
  --data-urlencode "mail_subject=Hello from MailBridgeAPI" \
  --data-urlencode "mail_body=<p>Your mailbox is now connected to an API.</p>" \
  --data-urlencode "format=html" \
  --data-urlencode "from_source=my-application"
```

A successful legacy send response contains `result.error = "0"`, `result.sent = "OK"`, and a message `result.id`.

## Authentication

MailBridgeAPI uses two credentials:

| Credential | Purpose | Recommended transport |
| --- | --- | --- |
| Account API key | Identifies your MailBridgeAPI account | `X-API-Key` header |
| Mailbox API key | Selects one mailbox owned by that account | `X-Mailbox-Key` header |

Modern endpoints accept the two headers. The account key can also be sent as `Authorization: Bearer YOUR_ACCOUNT_KEY`. Original endpoints use the query or form fields `apikey` and `apikeybox` for compatibility.

Read [Authentication and security](docs/authentication.md) before deploying.

## API endpoints

| Method | Endpoint | What it does |
| --- | --- | --- |
| `GET` | `/health/` | Check public API availability |
| `POST` | `/sendemail/` | Send through the connected SMTP mailbox or Gmail account |
| `GET` | `/getemail/` | Read messages directly from an IMAP folder |
| `GET` | `/email/unsubscribed/` | Retrieve unsubscribe records |
| `GET` | `/mailbox/status/` | Inspect SMTP, IMAP, Gmail, and feature readiness |
| `GET` | `/mailbox/insights/` | Get an operational mailbox snapshot |
| `GET` | `/email/sent/` | List sent messages and SMTP outcomes |
| `GET` | `/email/received/` | List received messages stored by MailBridgeAPI |
| `GET` | `/email/message/` | Load one sent or received message |
| `GET` | `/email/search/` | Search sent and received message metadata |
| `GET` | `/email/activity/` | Get totals, daily activity, sources, and frequent errors |
| `POST` | `/email/validate/` | Validate a send request without sending it |

See [Complete endpoint reference](docs/endpoints.md) and the machine-readable [OpenAPI 3.1 contract](openapi.json).

## Examples

Ready-to-run examples are available for:

- [cURL](examples/curl/README.md)
- [PHP 7.4+](examples/php/send-email.php)
- [JavaScript / Node.js 18+](examples/javascript/send-email.mjs)
- [Python 3.9+](examples/python/send_email.py)
- [Postman](postman/MailBridgeAPI.postman_collection.json)

## Gmail support

Gmail mailboxes use OAuth 2.0. Complete the Google authorization flow in the MailBridgeAPI dashboard; your applications still use the same MailBridgeAPI keys and endpoints. No Google refresh token belongs in your project. See [Gmail OAuth](docs/gmail-oauth.md).

## Error handling

Modern endpoints use a stable JSON envelope:

```json
{
  "ok": false,
  "error": {
    "code": "invalid_parameter",
    "message": "recipient must be a valid email address."
  },
  "meta": {
    "request_id": "request_identifier",
    "api_version": "2026-10-12.2",
    "timestamp": "2026-10-16T09:00:00Z"
  }
}
```

Log `meta.request_id` when contacting support. See [Errors and troubleshooting](docs/errors.md).

## Repository map

```text
.
├── docs/                 Human-readable guides
├── examples/             Copy-ready code in popular languages
├── postman/              Importable Postman collection
├── openapi.json          OpenAPI 3.1 contract
├── CONTRIBUTING.md       Documentation contribution guide
└── SECURITY.md           Responsible security reporting
```

## Support

Use the [dashboard support center](https://dashboard.mailbridgeapi.com/support/) for account-specific help. For documentation problems, open a GitHub issue without including API keys, mailbox passwords, message bodies, or customer data.

## License

The documentation and examples in this repository are released under the [MIT License](LICENSE).

