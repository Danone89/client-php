<?php
/*
 * Pipedrive
 *
 * This file was automatically generated by APIMATIC v2.0 ( https://apimatic.io ).
 */

namespace Pipedrive\Controllers;

use Pipedrive\APIException;
use Pipedrive\APIHelper;
use Pipedrive\Configuration;
use Pipedrive\Models;
use Pipedrive\Exceptions;
use Pipedrive\Http\HttpRequest;
use Pipedrive\Http\HttpResponse;
use Pipedrive\Http\HttpMethod;
use Pipedrive\Http\HttpContext;
use Pipedrive\OAuthManager;
use Pipedrive\Servers;
use Unirest\Request;

/**
 * @todo Add a general description for this controller.
 */
class OAuthAuthorizationController extends BaseController
{
    /**
     * @var OAuthAuthorizationController The reference to *Singleton* instance of this class
     */
    private static $instance;

    /**
     * Returns the *Singleton* instance of this class.
     * @return OAuthAuthorizationController The *Singleton* instance.
     */
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Create a new OAuth 2 token.
     *
     * @param  array  $options    Array with all options for search
     * @param string $options['authorization'] Authorization header in Basic auth format
     * @param string $options['code']          Authorization Code
     * @param string $options['redirectUri']   Redirect Uri
     * @param    array  $fieldParameters    Additional optional form parameters are supported by this endpoint
     * @return mixed response from the API call
     * @throws APIException Thrown if API call fails
     */
    public function createRequestToken(
        $options,
        $fieldParameters = null
    ) {

        //prepare query string for API call
        $_queryBuilder = '/oauth/token';

        //validate and preprocess url
        $_queryUrl = APIHelper::cleanUrl(Configuration::getBaseUri(Servers::OAUTH) . $_queryBuilder);

        //prepare headers
        $_headers = array (
            'user-agent'    => BaseController::USER_AGENT,
            'Accept'        => 'application/json',
            'Authorization'   => $this->val($options, 'authorization')
        );

        //prepare parameters
        $_parameters = array (
            'grant_type'    => 'authorization_code',
            'code'          => $this->val($options, 'code'),
            'redirect_uri'  => $this->val($options, 'redirectUri')
        );
        if (isset($fieldParameters)) {
            $_parameters = array_merge($_parameters, $fieldParameters);
        }

        //call on-before Http callback
        $_httpRequest = new HttpRequest(HttpMethod::POST, $_headers, $_queryUrl, $_parameters);
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnBeforeRequest($_httpRequest);
        }

        //and invoke the API call request to fetch the response
        $response = Request::post($_queryUrl, $_headers, Request\Body::Form($_parameters));

        $_httpResponse = new HttpResponse($response->code, $response->headers, $response->raw_body);
        $_httpContext = new HttpContext($_httpRequest, $_httpResponse);

        //call on-after Http callback
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnAfterRequest($_httpContext);
        }

        //Error handling using HTTP status codes
        if ($response->code == 400) {
            throw new Exceptions\OAuthProviderException('OAuth 2 provider returned an error.', $_httpContext);
        }

        if ($response->code == 401) {
            throw new Exceptions\OAuthProviderException(
                'OAuth 2 provider says client authentication failed.',
                $_httpContext
            );
        }

        //handle errors defined at the API level
        $this->validateResponse($_httpResponse, $_httpContext);

        $mapper = $this->getJsonMapper();

        return $mapper->mapClass($response->body, 'Pipedrive\\Models\\OAuthToken');
    }

    /**
     * Obtain a new access token using a refresh token
     *
     * @param  array  $options    Array with all options for search
     * @param string $options['authorization'] Authorization header in Basic auth format
     * @param string $options['refreshToken']  Refresh token
     * @param string $options['scope']         (optional) Requested scopes as a space-delimited list.
     * @param    array  $fieldParameters    Additional optional form parameters are supported by this endpoint
     * @return mixed response from the API call
     * @throws APIException Thrown if API call fails
     */
    public function createRefreshToken(
        $options,
        $fieldParameters = null
    ) {

        //prepare query string for API call
        $_queryBuilder = '/oauth/token';

        //validate and preprocess url
        $_queryUrl = APIHelper::cleanUrl(Configuration::getBaseUri(Servers::OAUTH) . $_queryBuilder);

        //prepare headers
        $_headers = array (
            'user-agent'    => BaseController::USER_AGENT,
            'Accept'        => 'application/json',
            'Authorization'   => $this->val($options, 'authorization')
        );

        //prepare parameters
        $_parameters = array (
            'grant_type'    => 'refresh_token',
            'refresh_token' => $this->val($options, 'refreshToken'),
            'scope'         => $this->val($options, 'scope')
        );
        if (isset($fieldParameters)) {
            $_parameters = array_merge($_parameters, $fieldParameters);
        }

        //call on-before Http callback
        $_httpRequest = new HttpRequest(HttpMethod::POST, $_headers, $_queryUrl, $_parameters);
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnBeforeRequest($_httpRequest);
        }

        //and invoke the API call request to fetch the response
        $response = Request::post($_queryUrl, $_headers, Request\Body::Form($_parameters));

        $_httpResponse = new HttpResponse($response->code, $response->headers, $response->raw_body);
        $_httpContext = new HttpContext($_httpRequest, $_httpResponse);

        //call on-after Http callback
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnAfterRequest($_httpContext);
        }

        //Error handling using HTTP status codes
        if ($response->code == 400) {
            throw new Exceptions\OAuthProviderException('OAuth 2 provider returned an error.', $_httpContext);
        }

        if ($response->code == 401) {
            throw new Exceptions\OAuthProviderException(
                'OAuth 2 provider says client authentication failed.',
                $_httpContext
            );
        }

        //handle errors defined at the API level
        $this->validateResponse($_httpResponse, $_httpContext);

        $mapper = $this->getJsonMapper();

        return $mapper->mapClass($response->body, 'Pipedrive\\Models\\OAuthToken');
    }


    /**
    * Array access utility method
     * @param  array          $arr         Array of values to read from
     * @param  string         $key         Key to get the value from the array
     * @param  mixed|null     $default     Default value to use if the key was not found
     * @return mixed
     */
    private function val($arr, $key, $default = null)
    {
        if (isset($arr[$key])) {
            return is_bool($arr[$key]) ? var_export($arr[$key], true) : $arr[$key];
        }
        return $default;
    }
}
