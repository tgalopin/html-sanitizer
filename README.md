# html-purifier

Safer, faster and easier to extend HTML purifier

## Installation

```
composer require tgalopin/html-purifier
```

## Usage

```php
<?php

$purifier = HtmlPurifier\Purifier::create([
    'allowed_tags' => [
        'a' => [
            'allowed_hosts' => ['symfony.com', '*.symfony.com'],
            'force_target_blank' => ['except_hosts' => ['symfony.com', '*.symfony.com']],
        ],
        'img' => [
            'allowed_hosts' => ['symfony.com', '*.symfony.com'],
            'allow_data_uri' => false,
            'force_https' => true,
        ],
        'div' => [],
    ],
]);

$safeHtml = $purifier->purify($untrustedHtml);
```
