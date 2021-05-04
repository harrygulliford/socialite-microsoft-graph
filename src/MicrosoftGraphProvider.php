<?php

namespace HarryGulliford\SocialiteMicrosoftGraph;

use Illuminate\Support\Arr;
use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\ProviderInterface;
use Laravel\Socialite\Two\User;

class MicrosoftGraphProvider extends AbstractProvider implements ProviderInterface
{
    /**
     * {@inheritdoc}
     */
    protected $scopes = ['User.Read'];

    /**
     * {@inheritdoc}
     */
    protected $scopeSeparator = ' ';

    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase(
            'https://login.microsoftonline.com/'.$this->getTenantId().'/oauth2/v2.0/authorize',
            $state
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenUrl()
    {
        return 'https://login.microsoftonline.com/'.$this->getTenantId().'/oauth2/v2.0/token';
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get('https://graph.microsoft.com/v1.0/me/', [
            'headers' => [
                'Authorization' => 'Bearer '.$token,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenFields($code)
    {
        return array_merge(parent::getTokenFields($code), [
            'grant_type' => 'authorization_code',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function mapUserToObject(array $user)
    {
        // Mapping default Laravel user keys to the keys that are nested in the
        // response from the provider.
        return (new User)->setRaw($user)->map([
            'id' => $user['id'],
            'name' => $user['displayName'],
            'email' => $user['userPrincipalName'],

            // The following values are not always required by the provider. We
            // cannot guarantee they will exist in the $user array.
            'businessPhones' => Arr::get($user, 'businessPhones'),
            'displayName' => Arr::get($user, 'displayName'),
            'givenName' => Arr::get($user, 'givenName'),
            'jobTitle' => Arr::get($user, 'jobTitle'),
            'mail' => Arr::get($user, 'mail'),
            'mobilePhone' => Arr::get($user, 'mobilePhone'),
            'officeLocation' => Arr::get($user, 'officeLocation'),
            'preferredLanguage' => Arr::get($user, 'preferredLanguage'),
            'surname' => Arr::get($user, 'surname'),
            'userPrincipalName' => Arr::get($user, 'userPrincipalName'),
        ]);
    }

    /**
     * The tenant globally unique identifier, used to scope sign-on activity to
     * a singular organization or domain.
     *
     * @return string
     */
    private function getTenantId()
    {
        return config('services.microsoft-graph.tenant_id', 'common');
    }
}
