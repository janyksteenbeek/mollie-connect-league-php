<?php

namespace JanykSteenbeek\MollieConnect\OAuth2\Client\Provider;

use JanykSteenbeek\MollieConnect\OAuth2\Client\Provider\Resources\MollieConnectResourceOwner;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;

class MollieConnect extends AbstractProvider
{
    use BearerAuthorizationTrait;
    const BASE_AUTHORIZATION_URL = 'https://www.mollie.com/oauth2/authorize';

    /**
     * Get authorization url to begin OAuth2 flow.
     *
     * @return string
     */
    public function getBaseAuthorizationUrl()
    {
        return self::BASE_AUTHORIZATION_URL;
    }

    /**
     * Get access token URL to retrieve token.
     *
     * @param array $params
     * @return string
     */
    public function getBaseAccessTokenUrl(array $params)
    {
        return 'https://api.mollie.com/oauth2/tokens';
    }

    /**
     * Get provider URL to fetch organization details.
     *
     * @param AccessToken $token
     * @return string
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return 'https://api.mollie.com/v2/organizations/me';
    }

    /**
     * Get the default scopes used by this provider.
     *
     * @return array
     */
    protected function getDefaultScopes()
    {
        return ['organizations.read'];
    }

    /**
     * Check a provider response for errors.
     *
     * @param ResponseInterface $response
     * @param array|string $data
     *
     * @throws IdentityProviderException
     */
    protected function checkResponse(ResponseInterface $response, $data)
    {
        if ($response->getStatusCode() >= 400) {
            throw new IdentityProviderException(
                $data['title'] ?: $response->getReasonPhrase(),
                $response->getStatusCode(),
                $response
            );
        }
    }

    /**
     * Generate a user object from a successful user details request.
     *
     * @param array $response
     * @param AccessToken $token
     *
     * @return MollieConnectResourceOwner
     */
    protected function createResourceOwner(array $response, AccessToken $token)
    {
        return new MollieConnectResourceOwner($response);
    }
}
