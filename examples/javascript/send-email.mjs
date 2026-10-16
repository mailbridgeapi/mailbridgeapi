const accountKey = process.env.MAILBRIDGE_ACCOUNT_KEY;
const mailboxKey = process.env.MAILBRIDGE_MAILBOX_KEY;

if (!accountKey || !mailboxKey) {
  throw new Error('Set MAILBRIDGE_ACCOUNT_KEY and MAILBRIDGE_MAILBOX_KEY.');
}

const body = new URLSearchParams({
  apikey: accountKey,
  apikeybox: mailboxKey,
  recipient_email: 'customer@example.com',
  mail_subject: 'Hello from Node.js',
  mail_body: '<p>Your own mailbox is connected to your JavaScript application.</p>',
  format: 'html',
  from_source: 'node-example',
});

const response = await fetch('https://api.mailbridgeapi.com/sendemail/', {
  method: 'POST',
  headers: {'Content-Type': 'application/x-www-form-urlencoded'},
  body,
});
const data = await response.json();

if (!response.ok || String(data?.result?.error) !== '0') {
  throw new Error(`MailBridgeAPI send failed: ${JSON.stringify(data)}`);
}

console.log('Sent message id:', data.result.id);

