# Neos mailgun package

A Neos Flow package to easily use the mailgun api.

## Installation

Just run ```composer require neosrulez/neos-mailgun```

## Usage

```php
use NeosRulez\Neos\Mailgun\Message;

$message = new Message();
$message->setFrom('foo-from@bar.com');
$message->setTo('foo-to@bar.com');
$message->setCc('foo-cc@bar.com');
$message->setBcc('foo-bcc@bar.com');
$message->setSubject('This is the body');
$message->setBody('<strong>This is the body</strong>', 'text/html');

// Desired time of delivery. Note: Messages can be scheduled for a maximum of 3 days in the future.
$message->setDeliveryTime("tomorrow 8:00AM");

$message->setAttachments([
    '/data/neos/Data/foo.pdf'
]);
$message->send();
```

## Configuration

```yaml
NeosRulez:
  Neos:
    Mailgun:
      apiKey: 'your-mailgun-api-key'
      domain: 'your-mailgun-domain'
#      server: 'https://api.eu.mailgun.net' # for EU servers
```

## Author

* E-Mail: mail@patriceckhart.com
* URL: http://www.patriceckhart.com
