<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 3/26/2016
 * Time: 4:55 PM
 */

class Deven_Automation_Model_Pinterest_Client {

    const REDIRECT_URI_ROUTE = 'adminhtml/pinterest/authorize';

    const XML_PATH_ENABLED = 'automation/pinterest/enabled';
    const XML_PATH_CLIENT_ID = 'automation/pinterest/client_id';
    const XML_PATH_CLIENT_SECRET = 'automation/pinterest/client_secret';
    const XML_PATH_ACCESS_TOKEN = 'automation/pinterest/access_token';

    const OAUTH2_SERVICE_URI = 'https://api.pinterest.com/v1';
    const OAUTH2_AUTH_URI = 'https://api.pinterest.com/oauth';
    const OAUTH2_TOKEN_URI = 'https://api.pinterest.com/v1/oauth/token';

    protected $clientId = null;
    protected $clientSecret = null;
    protected $redirectUri = null;
    protected $state = '';
    protected $scope = array('read_public', 'write_public',
        'read_relationships', 'write_relationships');

    protected $token = null;

    public function __construct($params = array())
    {
        if(($this->isEnabled = $this->_isEnabled())) {

            if($this->_getAccessToken()) {
                $this->token = $this->_getAccessToken();
            }
            $this->clientId = $this->_getClientId();
            $this->clientSecret = $this->_getClientSecret();
            $this->redirectUri = Mage::getModel('core/url')->sessionUrlVar(
                Mage::getUrl(self::REDIRECT_URI_ROUTE)
            );

            if(!empty($params['scope'])) {
                $this->scope = $params['scope'];
            }

            if(!empty($params['state'])) {
                $this->state = $params['state'];
            }
        }
    }

    public function isEnabled()
    {
        return (bool) $this->isEnabled;
    }

    public function getClientId()
    {
        return $this->clientId;
    }

    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    public function getRedirectUri()
    {
        return $this->redirectUri;
    }

    public function getScope()
    {
        return $this->scope;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setState($state)
    {
        $this->state = $state;
    }

    public function setAccessToken($token)
    {
        $this->token = $token;
    }

    public function getAccessToken()
    {
        if(empty($this->token)) {
            $this->fetchAccessToken();
        }

        return $this->token;
    }

    public function createAuthUrl()
    {
        $url =
            self::OAUTH2_AUTH_URI.'?'.
            http_build_query(
                array(
                    'response_type' => 'code',
                    'client_id' => $this->clientId,
                    'state' => $this->state,
                    'scope' => implode(',', $this->scope),
                    'redirect_uri' => $this->redirectUri,
                )
            );
        return $url;
    }

    public function api($endpoint, $method = 'GET', $params = array())
    {
        if(empty($this->token)) {
            $this->fetchAccessToken();
        }

        $url = self::OAUTH2_SERVICE_URI.$endpoint;

        $method = strtoupper($method);

        $params = array_merge(array(
            'access_token' => $this->token
        ), $params);

        $response = $this->_httpRequest($url, $method, $params);

        return $response;
    }

    protected function fetchAccessToken()
    {
        if(!($code = Mage::app()->getRequest()->getParam('code'))) {
            throw new Exception(
                Mage::helper('deven_automation')
                    ->__('Unable to retrieve access code.')
            );
        }

        $response = $this->_httpRequest(
            self::OAUTH2_TOKEN_URI,
            'POST',
            array(
                'code' => $code,
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'grant_type' => 'authorization_code'
            )
        );

        $this->token = $response;
    }

    protected function _httpRequest($url, $method = 'GET', $params = array())
    {
        $client = new Zend_Http_Client($url);

        $client->setConfig(new Zend_Config(array('timeout' => 30000, 'adapter' => 'Zend_Http_Client_Adapter_Curl',
            'curloptions' => array(CURLOPT_SSL_VERIFYPEER => false))));

        switch ($method) {
            case 'GET':
                $client->setParameterGet($params);
                break;
            case 'POST':
                $client->setParameterPost($params);
                break;
            case 'DELETE':
                $client->setParameterGet($params);
                break;
            default:
                throw new Exception(
                    Mage::helper('deven_automation')
                        ->__('Required HTTP method is not supported.')
                );
        }

        $response = $client->request($method);

        Mage::log($response->getStatus().' - '. $response->getBody());

        $decoded_response = json_decode($response->getBody());

        /*
         * Per http://tools.ietf.org/html/draft-ietf-oauth-v2-27#section-5.1
         * Facebook should return data using the "application/json" media type.
         * Facebook violates OAuth2 specification and returns string. If this
         * ever gets fixed, following condition will not be used anymore.
         */
        if(empty($decoded_response)) {
            $parsed_response = array();
            parse_str($response->getBody(), $parsed_response);

            $decoded_response = json_decode(json_encode($parsed_response));
        }

        if($response->isError()) {
            $status = $response->getStatus();
            if(($status == 400 || $status == 401)) {
                if(isset($decoded_response->message)) {
                    $message = $decoded_response->message;
                } else {
                    $message = Mage::helper('deven_automation')
                        ->__('Unspecified OAuth error occurred.');
                }

                throw new Deven_Automation_PinterestOAuthException($message);
            } else {
                $message = sprintf(
                    Mage::helper('deven_automation')
                        ->__('HTTP error %d occurred while issuing request.'),
                    $status
                );

                throw new Exception($message);
            }
        }

        return $decoded_response;
    }

    protected function _isEnabled()
    {
        return $this->_getStoreConfig(self::XML_PATH_ENABLED);
    }

    protected function _getClientId()
    {
        return $this->_getStoreConfig(self::XML_PATH_CLIENT_ID);
    }

    protected function _getClientSecret()
    {
        return $this->_getStoreConfig(self::XML_PATH_CLIENT_SECRET);
    }

    protected function _getAccessToken()
    {
        return $this->_getStoreConfig(self::XML_PATH_ACCESS_TOKEN);
    }

    protected function _getStoreConfig($xmlPath)
    {
        return Mage::getStoreConfig($xmlPath, Mage::app()->getStore()->getId());
    }

}

class Deven_Automation_PinterestOAuthException extends Exception
{}