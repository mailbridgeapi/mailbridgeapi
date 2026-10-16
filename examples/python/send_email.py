import os
import urllib.parse
import urllib.request
import json

account_key = os.environ["MAILBRIDGE_ACCOUNT_KEY"]
mailbox_key = os.environ["MAILBRIDGE_MAILBOX_KEY"]

payload = urllib.parse.urlencode({
    "apikey": account_key,
    "apikeybox": mailbox_key,
    "recipient_email": "customer@example.com",
    "mail_subject": "Hello from Python",
    "mail_body": "<p>Your own mailbox is connected to your Python application.</p>",
    "format": "html",
    "from_source": "python-example",
}).encode()

request = urllib.request.Request(
    "https://api.mailbridgeapi.com/sendemail/",
    data=payload,
    headers={"Content-Type": "application/x-www-form-urlencoded"},
    method="POST",
)

with urllib.request.urlopen(request, timeout=30) as response:
    result = json.load(response)

if str(result.get("result", {}).get("error")) != "0":
    raise RuntimeError(f"MailBridgeAPI send failed: {result}")

print("Sent message id:", result["result"].get("id"))

