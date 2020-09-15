<?php

namespace ImpressoLabs\LaravelSignInWithHuawei\Providers;

use Illuminate\Support\Arr;
use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\InvalidStateException;
use Laravel\Socialite\Two\ProviderInterface;
use Laravel\Socialite\Two\User;

class HuaweiProvider extends AbstractProvider implements ProviderInterface
{
    protected $encodingType = PHP_QUERY_RFC3986;
    protected $scopeSeparator = " ";

    protected function getAuthUrl($state)
    {
        //https://oauth-login.cloud.huawei.com/.well-known/openid-configuration
        return $this->buildAuthUrlFromBase(
            'https://oauth-login.cloud.huawei.com/oauth2/v3/authorize',
            $state
        );
    }

    protected function getCodeFields($state = null)
    {
        $fields = [
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUrl,
            'scope' => $this->formatScopes($this->getScopes(), $this->scopeSeparator),
            'response_type' => 'code',
            'response_mode' => 'form_post',
        ];



        if ($this->usesState()) {
            $fields['state'] = $state;
        }

        $fields["grant_type"] = "authorization_code";
        $fields["scope"] = "profile email";

        return array_merge($fields, $this->parameters);
    }

    protected function getTokenUrl()
    {
        return "https://oauth-login.cloud.huawei.com/oauth2/v3/token";
    }

    public function getAccessToken($code)
    {


        $response = $this->getHttpClient()
            ->post(
                $this->getTokenUrl(),
                [
                    'headers' => [
                        'Authorization' => 'Basic '. base64_encode(
                            $this->clientId . ':' . $this->clientSecret
                        ),
                    ],
                    'body' => $this->getTokenFields($code),
                ]
            );

        return $this->parseAccessToken($response->getBody());
    }

    protected function parseAccessToken($response)
    {
        $data = $response->json();

        return $data['access_token'];
    }

    protected function getTokenFields($code)
    {
        $fields = parent::getTokenFields($code);
        $fields["grant_type"] = "authorization_code";
        $fields["scope"] = "profile email";



        return $fields;
    }

    protected function getUserByToken($token)
    {

        $claims = explode('.', $token)[1];
        return json_decode(base64_decode($claims), true);
    }

    public function user()
    {
        $response = $this->getAccessTokenResponse($this->getCode());

        $user = $this->mapUserToObject($this->getUserByToken(
            Arr::get($response, 'id_token')
        ));


        return $user
            ->setToken(Arr::get($response, 'id_token'))
            ->setRefreshToken(Arr::get($response, 'refresh_token'))
            ->setExpiresIn(Arr::get($response, 'expires_in'));
    }

    protected function mapUserToObject(array $user)
    {
        if (request()->filled("user")) {
            $userRequest = json_decode(request("user"), true);

            if (array_key_exists("name", $userRequest)) {
                $user["name"] = $userRequest["name"];
                $fullName = trim(
                    ($user["name"]['family_name'] ?? "")
                    . " "
                    . ($user["name"]['given_name'] ?? "")
                );
            }
        }

        return (new User)
            ->setRaw($user)
            ->map([
                "id" => $user["sub"],
                "name" => $fullName ?? null,
                "email" => $user["email"] ?? null,
            ]);
    }
}