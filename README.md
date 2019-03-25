# Mollie Connect Provider for OAuth 2.0 Client
[![Latest Version](https://img.shields.io/github/release/janyksteenbeek/mollie-connect-oauth2-php.svg?style=flat-square)](https://github.com/janyksteenbeek/mollie-connect-oauth2-php/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Total Downloads](https://img.shields.io/packagist/dt/janyksteenbeek/mollie-connect-oauth2.svg?style=flat-square)](https://packagist.org/packages/janyksteenbeek/mollie-connect-oauth2)

This package provides [Mollie Connect](https://docs.mollie.com/oauth/overview) OAuth 2.0 support for the PHP League's [OAuth 2.0 Client](https://github.com/thephpleague/oauth2-client).

## Installation

To install, use Composer:

```
composer require janyksteenbeek/mollie-connect-oauth2
```

You will need an [Mollie account](https://www.mollie.com/dashboard/signup/1861791?lang=en) _(referral link)_ and a 
registered application in order to use the Mollie Connect API.

## Usage

Usage is the same as The League's OAuth client, using `JanykSteenbeek\MollieConnect\OAuth2\Client\Provider\MollieConnect` as the provider.

### Authorization Code Flow

```php
<?php
session_start();

$provider = new \JanykSteenbeek\MollieConnect\OAuth2\Client\Provider([
    'clientId'          => '{mollie-connect-client-id}',
    'clientSecret'      => '{mollie-connect-client-secret}',
    'redirectUri'       => 'https://example.com/callback-url',
]);

if (!isset($_GET['code'])) {

    // If we don't have an authorization code, we will fetch one from Mollie
    $authUrl = $provider->getAuthorizationUrl();
    $_SESSION['oauth2_state'] = $provider->getState();
    header('Location: ' . $authUrl);
    exit;

// Check given state against previously stored one to mitigate CSRF attacks.
} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2_state'])) {

    unset($_SESSION['oauth2_state']);
    exit('Invalid state');

} else {

    // Try to get an access token (using the authorization code grant)
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);

    // Optional: Now you have a token you can look up a organization's profile data
    try {

        // We got an access token, let's now get the organization's details
        $account = $provider->getResourceOwner($token);

        // Use these details to create a new profile
        printf('Welcome %s!', $account->getName());

    } catch (Exception $e) {
        // Failed to get user details
        exit('Something went wrong fetching your organization details.');
    }

    // Use this to interact with an API on the organization's behalf
    $mollieToken = $token->getToken();
}
```

### Scopes

You can find a list of usable scopes [here](https://docs.mollie.com/oauth/permissions)

## Credits

- [Janyk Steenbeek](https://github.com/janyksteenbeek)
- [All contributors](https://github.com/janyksteenbeek/mollie-connect-oauth2-php/contributors)


## License

The MIT License (MIT). Please see the [License file](https://github.com/janyksteenbeek/mollie-connect-oauth2-php/blob/master/LICENSE) for more information.