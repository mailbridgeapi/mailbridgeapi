const response = await fetch(
  'https://api.mailbridgeapi.com/email/received/?per_page=5',
  {
    headers: {
      'X-API-Key': process.env.MAILBRIDGE_ACCOUNT_KEY ?? '',
      'X-Mailbox-Key': process.env.MAILBRIDGE_MAILBOX_KEY ?? '',
      Accept: 'application/json',
    },
  },
);
const data = await response.json();
if (!response.ok || data.ok !== true) {
  throw new Error(`MailBridgeAPI request failed: ${JSON.stringify(data)}`);
}
console.table(data.data.items);

