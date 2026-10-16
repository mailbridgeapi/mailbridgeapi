# Quick start

## 1. Connect your mailbox

Create an account, open **Mailboxes**, and choose the connection type:

- **SMTP + IMAP** for standard providers.
- **SMTP only** if the application only sends.
- **IMAP only** if the application only reads.
- **Gmail OAuth** for Gmail and Google Workspace.

Test the configured protocol in the dashboard before saving.

## 2. Copy both API keys

You need the account API key and the mailbox API key. They do not replace each other.

## 3. Check readiness

```bash
curl "https://api.mailbridgeapi.com/mailbox/status/" \
  -H "X-API-Key: $MAILBRIDGE_ACCOUNT_KEY" \
  -H "X-Mailbox-Key: $MAILBRIDGE_MAILBOX_KEY"
```

Use the returned readiness fields to decide whether your application can send, receive, or both.

## 4. Validate before sending

```bash
curl -X POST "https://api.mailbridgeapi.com/email/validate/" \
  -H "X-API-Key: $MAILBRIDGE_ACCOUNT_KEY" \
  -H "X-Mailbox-Key: $MAILBRIDGE_MAILBOX_KEY" \
  -H "Content-Type: application/json" \
  -d '{"recipient_email":"customer@example.com","mail_subject":"Test","mail_body":"Hello","format":"text"}'
```

The endpoint never sends a message. Check `data.valid`, `data.errors`, and `data.warnings`.

## 5. Send

Use `POST /sendemail/`. Check `result.error` instead of relying on the HTTP status alone because this endpoint keeps its original response format for compatibility.

## 6. Monitor

Use `/email/sent/` for message-level results, `/email/activity/` for charts and error patterns, and `/mailbox/insights/` for a compact health summary.

