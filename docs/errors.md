# Errors and troubleshooting

## Modern endpoint format

Modern endpoints return an HTTP error status and a JSON body with `ok: false`, an error code, a human-readable message, and request metadata.

| HTTP status | Typical meaning |
| --- | --- |
| `400` | Invalid or missing request parameter |
| `401` | Missing or invalid API keys |
| `404` | Resource or message not found |
| `405` | Unsupported HTTP method |
| `502` | Mail provider, SMTP, IMAP, or Gmail operation failed |
| `503` | Service configuration is temporarily unavailable |

Always log `meta.request_id`, the endpoint, the HTTP status, and your own correlation identifier. Do not log API keys or message bodies.

## Send endpoint format

`/sendemail/` keeps its original response for compatibility. Inspect these fields:

- `result.error`: `"0"` means the SMTP or Gmail send was accepted.
- `result.sent`: `"OK"` on success, otherwise a reason.
- `result.id`: MailBridgeAPI message identifier.

## Common checks

1. Call `/health/` to confirm API availability.
2. Call `/mailbox/status/` with both keys.
3. Call `/email/validate/` before sending.
4. Inspect `/mailbox/insights/` and `/email/sent/?status=error`.
5. Test SMTP or IMAP from the dashboard if the connection changed.
6. Confirm the subscription is active.

## Support request checklist

Provide the request ID, UTC time, endpoint, HTTP status, and a redacted response. Never send a mailbox password, Google refresh token, account key, or mailbox key in a ticket.

