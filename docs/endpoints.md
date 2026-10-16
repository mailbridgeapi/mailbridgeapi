# Complete endpoint reference

Base URL: `https://api.mailbridgeapi.com`

All examples use placeholders. See [Authentication and security](authentication.md) for credential handling.

## `GET /health/`

Public availability check. It requires no authentication and returns the service name, operational state, and API version.

## `POST /sendemail/`

Sends one message through the mailbox configured in MailBridgeAPI. It supports standard SMTP mailboxes and Gmail connections while keeping one endpoint for your application.

Content type: `application/x-www-form-urlencoded`.

### Required fields

| Field | Type | Description |
| --- | --- | --- |
| `apikey` | string | Account API key |
| `apikeybox` | string | Mailbox API key |
| `recipient_email` | email | Primary recipient |
| `mail_subject` | string | Message subject |
| `mail_body` | string | Plain-text or HTML body |

### Optional fields

| Field | Description |
| --- | --- |
| `format` | `html` or `text`; defaults to `html` |
| `sender_name` | Display name when the mailbox configuration permits it |
| `sender_email` | Sender address when the mailbox configuration permits it |
| `reply_name`, `reply_email` | Reply-To identity |
| `email_cc1`, `email_cc2`, `email_cc3` | Up to three CC recipients |
| `charset` | Message character set; defaults to UTF-8 |
| `from_source` | Your integration identifier, for example `wordpress`, `crm`, or `billing-service` |
| `unsubscribe` | Enables the configured unsubscribe behavior |
| `skip_sent_copy` | `1` prevents asynchronous storage in the selected IMAP Sent folder |
| `mail_message_id` | Explicit RFC message identifier for advanced threading |
| `mail_in_reply_to` | Parent RFC message identifier |
| `mail_references` | Space-separated RFC message identifiers |
| `mail_auto_submitted` | `auto-generated` or `auto-replied` |
| `attachmentBase64_1`, `attachmentBase64_name_1` | First Base64 attachment and filename |
| `attachmentBase64_2`, `attachmentBase64_name_2` | Second Base64 attachment and filename |

Successful sends return `result.error = "0"`, `result.sent = "OK"`, and `result.id`. Store `result.id` to retrieve the delivery record later.

## `GET /getemail/`

Reads up to 30 messages directly from an IMAP folder.

| Parameter | Required | Description |
| --- | --- | --- |
| `apikey` | yes | Account API key |
| `apikeybox` | yes | Mailbox API key |
| `mbox` | yes | IMAP folder such as `INBOX` |
| `start` | no | Zero-based offset; defaults to `0` |

Messages are returned under `result.emaillist`. Use `/email/received/` for the modern paginated activity view.

## `GET /email/unsubscribed/`

Returns unsubscribe records for the authenticated mailbox. Pass `email` to filter by one recipient.

## `GET /mailbox/status/`

Inspects the selected mailbox without exposing SMTP, IMAP, Google, or password credentials. Use it during installation, support diagnostics, and monitoring.

## `GET /mailbox/insights/`

Returns a compact operational summary: delivery totals, errors, received volume, last activity, and most recent send failure.

| Parameter | Range | Default |
| --- | --- | --- |
| `days` | 1–90 | 30 |

## `GET /email/sent/`

Returns sent-email activity ordered from newest to oldest.

| Parameter | Description |
| --- | --- |
| `page` | Page number, starting at 1 |
| `per_page` | 1–100; defaults to 25 |
| `status` | `all`, `success`, or `error` |
| `recipient` | Exact recipient email filter |
| `from`, `to` | Inclusive dates in `YYYY-MM-DD` format |
| `source` | Filter by `from_source` |
| `include_body` | Include message bodies only when needed |

## `GET /email/received/`

Returns received messages stored by MailBridgeAPI. Gmail connections may also return `meta.pagination.next_page_token` for provider pagination.

| Parameter | Description |
| --- | --- |
| `page`, `per_page` | Standard pagination; `per_page` is limited to 100 |
| `sender` | Exact sender email filter |
| `from`, `to` | Inclusive dates in `YYYY-MM-DD` format |
| `include_body` | Include bodies only when the UI opens a message |
| `page_token` | Gmail continuation token when returned by the previous response |

## `GET /email/message/`

Loads one full sent or received message.

| Parameter | Required | Values |
| --- | --- | --- |
| `direction` | yes | `sent` or `received` |
| `id` | yes | MailBridgeAPI message identifier |

## `GET /email/search/`

Searches identifiers, subjects, senders, and recipients across sent and received metadata. Bodies remain available through `/email/message/`.

| Parameter | Description |
| --- | --- |
| `query` | Required, 2–120 characters |
| `direction` | `all`, `sent`, or `received` |
| `page`, `per_page` | Pagination |
| `from`, `to` | Inclusive date filters |

## `GET /email/activity/`

Returns sent, accepted, error, and received totals plus a daily series. It also reports leading `from_source` values and frequent error reasons.

| Parameter | Range | Default |
| --- | --- | --- |
| `days` | 1–90 | 30 |

## `POST /email/validate/`

Validates the recipient, subject, body, format, and SMTP readiness without sending email. Accepts JSON or form data.

| Field | Required | Rules |
| --- | --- | --- |
| `recipient_email` | yes | Valid email address |
| `mail_subject` | yes | Maximum 998 bytes |
| `mail_body` | yes | Maximum 1 MB |
| `format` | no | `html` or `text` |

`data.sends_email` is always `false`.

