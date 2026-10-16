# Gmail OAuth

Gmail and Google Workspace accounts use OAuth 2.0 instead of storing an ordinary Gmail password.

## Connection flow

1. In the dashboard, create a mailbox and choose **Gmail / Google Workspace**.
2. Enter the mailbox name and Gmail address.
3. Start Google authorization.
4. Sign in to the intended Google account and approve the requested mail access.
5. Return to MailBridgeAPI and verify the connection.

MailBridgeAPI stores and refreshes the provider authorization on the server. Your application continues using the account API key and mailbox API key.

## Application code does not change

The same `/sendemail/`, `/email/received/`, `/mailbox/status/`, and reporting endpoints work for Gmail-backed mailboxes. Do not place a Google client secret or refresh token in your project.

## Revocation

Disconnect the Gmail mailbox in the MailBridgeAPI dashboard and revoke the app in the Google account security settings if access is no longer required.

