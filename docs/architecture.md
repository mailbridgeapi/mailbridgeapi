# Architecture and integration patterns

## One mailbox, many projects

A single mailbox can serve multiple authorized applications. Each request selects it through the mailbox API key. Use `from_source` on outgoing messages to identify the originating application in the dashboard, mobile app, and activity endpoints.

## Password changes

When an SMTP or IMAP password changes, update the mailbox once in MailBridgeAPI. Projects keep their MailBridgeAPI keys and do not need the mailbox password.

## Recommended send workflow

1. Validate input in your application.
2. Optionally call `/email/validate/` for provider readiness.
3. Call `/sendemail/` with a stable `from_source`.
4. Store the returned message ID.
5. Inspect `/email/message/` or `/email/sent/` for the recorded result.

## Recommended inbox workflow

1. Use `/email/received/` for a paginated mailbox activity view.
2. Load the body through `/email/message/` only when required.
3. Use `/email/search/` for subject, address, or identifier lookup.
4. Use `/getemail/` only when direct IMAP folder retrieval is required.

## Monitoring workflow

Call `/mailbox/status/` for configuration readiness and `/mailbox/insights/` for recent operational state. Build charts from `/email/activity/` and alert on a growing error count or a failed connection.

