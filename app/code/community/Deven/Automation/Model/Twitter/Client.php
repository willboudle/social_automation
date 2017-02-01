<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 3/26/2016
 * Time: 4:56 PM
 */

class Deven_Automation_Model_Twitter_Client {

    const REDIRECT_URI_ROUTE = '/';

    const OAUTH_URI = 'https://api.twitter.com/oauth';
    const OAUTH2_SERVICE_URI = 'https://api.twitter.com/1.1';

    const XML_PATH_ENABLED = 'automation/twitter/enabled';
    const XML_PATH_CLIENT_ID = 'automation/twitter/client_id';
    const XML_PATH_CLIENT_SECRET = 'automation/twitter/client_secret';
    const XML_PATH_OAUTH_TOKEN  = 'automation/twitter/oauth_token';
    const XML_PATH_OAUTH_TOKEN_SECRET  = 'automation/twitter/oauth_token_secret';

    protected $clientId = null;
    protected $clientSecret = null;
    protected $oauthToken = null;
    protected $oauthTokenSecret = null;
    protected $redirectUri = null;
    protected $client = null;
    protected $token = null;

    protected $config = array();

    public function __construct() {
        if(($this->isEnabled = $this->_isEnabled())) {
            $this->clientId = $this->_getClientId();
            $this->clientSecret = $this->_getClientSecret();
            $this->oauthToken = $this->_getOauthToken();
            $this->oauthTokenSecret =$this->_getOauthTokenSecret();
            $this->redirectUri = Mage::getModel('core/url')->sessionUrlVar(
                Mage::getUrl(self::REDIRECT_URI_ROUTE)
            );
            $this->config = array(
                'callbackUrl'   => $this->redirectUri,
                'siteUrl'       => self::OAUTH_URI,
                'consumerKey'   => $this->clientId,
                'consumerSecret'=> $this->clientSecret
            );


            $this->token = new Zend_Oauth_Token_Access();

            $this->token->setParams(array(
                'oauth_token' => $this->oauthToken,
                'oauth_token_secret' => $this->oauthTokenSecret,
            ));
        }
    }

    public function isEnabled() {
        return (bool) $this->isEnabled;
    }

    public function getClient() {
        return $this->client;
    }

    public function getClientId() {
        return $this->clientId;
    }

    public function getClientSecret() {
        return $this->clientSecret;
    }

    public function getRedirectUri() {
        return $this->redirectUri;
    }

    public function api($endpoint, $method = 'GET', $params = array(), $image=false, $path, $attr) {
        if(empty($this->token)) {
            throw new Exception(
                Mage::helper('deven_automation')
                    ->__('Unable to proceed without an access token.')
            );
        }

        $url = self::OAUTH2_SERVICE_URI.$endpoint;

        $response = $this->_httpRequest($url, strtoupper($method), $params, $image, $path, $attr);

        return $response;
    }

    protected function _httpRequest($url, $method = 'GET', $params = array(), $image = false, $path, $attr)
    {
        $client = $this->token->getHttpClient($this->config);

        $client->setConfig(new Zend_Config(array('timeout' => 30000)));
        $client->setUri($url);

        switch ($method) {
            case 'GET':
                $client->setMethod(Zend_Http_Client::GET);
                $client->setParameterGet($params);
                break;
            case 'POST':
                $client->setMethod(Zend_Http_Client::POST);
                if($image){
                    $client->setParameterGet($params);
                    $client->setFileUpload($path, $attr);
                } else {
                    $client->setParameterPost($params);
                }
                break;
            case 'DELETE':
                $client->setMethod(Zend_Http_Client::DELETE);
                break;
            default:
                throw new Exception(
                    Mage::helper('deven_automation')
                        ->__('Required HTTP method is not supported.')
                );
        }

        $response = $client->request();

        Mage::log($response->getStatus().' - '. $response->getBody());

        $decoded_response = json_decode($response->getBody());

        if($response->isError()) {
            $status = $response->getStatus();
            if(($status == 400 || $status == 401 || $status == 429)) {
                if(isset($decoded_response->error->message)) {
                    $message = $decoded_response->error->message;
                } else {
                    $message = Mage::helper('deven_automation')
                        ->__('Unspecified OAuth error occurred.');
                }

                throw new Exception($message);
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

    protected function _getOauthToken() {
        return $this->_getStoreConfig(self::XML_PATH_OAUTH_TOKEN);
    }

    protected function _getOauthTokenSecret() {
        return $this->_getStoreConfig(self::XML_PATH_OAUTH_TOKEN_SECRET);
    }

    protected function _getStoreConfig($xmlPath)
    {
        return Mage::getStoreConfig($xmlPath, Mage::app()->getStore()->getId());
    }

} 