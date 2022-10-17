# TINT API Client

## Install
`composer require mango-chutney/tint-api-client`

## Usage

```php
use MangoChutney\TintApiClient\Client;

$client = Client();

$client->getPublicPosts('tint_slug');

```

## Lint

`composer lint`

## Test

`php -S localhost:8000 router.php`
