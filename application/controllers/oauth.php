<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of hello
 *
 * @author witzhsiao
 */
class Oauth extends CI_Controller {
    
    public function test()
    {
        $this->load->view('test_console');
    }
    
    
    public function request_token()
    {

        require_once 'Zend/Oauth/Consumer.php';

        session_start();

        //$CONSUMER_KEY = 'ad7237ff6a12ef92209e11f9963965a804f8e3dae';
        //$CONSUMER_SECRET = '5084315b8abed62238665201a095fa52';
        
        $CONSUMER_KEY = $_REQUEST['ck'];
        $CONSUMER_SECRET = $_REQUEST['cs'];

        // Multi-scoped token.
        $SCOPES = array(
//            'https://docs.google.com/feeds/',
//            'https://spreadsheets.google.com/feeds/'
        );

        $oauthOptions = array(
            'requestScheme' => Zend_Oauth::REQUEST_SCHEME_HEADER,
            'version' => '1.0',
            'consumerKey' => $CONSUMER_KEY,
            'consumerSecret' => $CONSUMER_SECRET,
            'signatureMethod' => 'HMAC-SHA1',
            'callbackUrl' => 'http://localhost:8888/CI_OauthTestConsole/index.php/oauth/authorize_done',
            'requestTokenUrl' => 'http://hello.local:8888/oauth.php/request_token',
            'userAuthorizationUrl' => 'http://hello.local:8888/oauth.php/authorize',
            'accessTokenUrl' => 'http://hello.local:8888/oauth.php/access_token'
        );

        $consumer = new Zend_Oauth_Consumer($oauthOptions);

        // When using HMAC-SHA1, you need to persist the request token in some way.
        // This is because you'll need the request token's token secret when upgrading
        // to an access token later on. The example below saves the token object as a session variable.
        if (!isset($_SESSION['ACCESS_TOKEN'])) {
            $request_token = $consumer->getRequestToken();
            
            $_SESSION['REQUEST_TOKEN'] = serialize($request_token);
        
            

            $response = array(
                'oauth_token' => $request_token->getToken(),
                'oauth_secret' => $request_token->getTokenSecret()
            );
            echo json_encode($response);
        }
    }
    
    public function authorize_done() {
        if(isset($_REQUEST['oauth_token']) && isset($_REQUEST['oauth_verifier'])) {
            session_start();
            
            $_SESSION['oauth_token'] = $_REQUEST['oauth_token'];
            $_SESSION['oauth_verifier'] = $_REQUEST['oauth_verifier'];
            
            echo '<h1>Congratulation!</h1></br>';
            echo '<h2>Now, you can grant the access token!</h2>';
        } else {
//            echo '<h1>Congratulation!</h1></br>';
            echo '<h2>Sorry! You need to authorize first!</h2>';
        }
//        echo '<h3>oauth_token: ' . $_REQUEST['oauth_token'] . '</h3></br>';
//        echo '<h3>oauth_verifier: ' . $_REQUEST['oauth_verifier'] . '</h3></br>';
    }
    
    public function access_token() {
        
        require_once 'Zend/Oauth/Consumer.php';
        session_start();
        
        $CONSUMER_KEY = $_REQUEST['ck'];
        $CONSUMER_SECRET = $_REQUEST['cs'];

        // Multi-scoped token.
        $SCOPES = array(
//            'https://docs.google.com/feeds/',
//            'https://spreadsheets.google.com/feeds/'
        );

        $oauthOptions = array(
            'requestScheme' => Zend_Oauth::REQUEST_SCHEME_HEADER,
            'version' => '1.0',
            'consumerKey' => $CONSUMER_KEY,
            'consumerSecret' => $CONSUMER_SECRET,
            'signatureMethod' => 'HMAC-SHA1',
            'callbackUrl' => 'http://localhost:8888/CI_OauthTestConsole/index.php/oauth/authorize_done',
            'requestTokenUrl' => 'http://hello.local:8888/oauth.php/request_token',
            'userAuthorizationUrl' => 'http://hello.local:8888/oauth.php/authorize',
            'accessTokenUrl' => 'http://hello.local:8888/oauth.php/access_token'
        );

        $consumer = new Zend_Oauth_Consumer($oauthOptions);
        
        $queryData = array (
            'oauth_token' => $_SESSION['oauth_token'], 
            'oauth_verifier' => $_SESSION['oauth_verifier']
        );
        $access_token = $consumer->getAccessToken($queryData, unserialize($_SESSION['REQUEST_TOKEN']));
        $response = array(
            'oauth_token' => $access_token->getToken(),
            'oauth_secret' => $access_token->getTokenSecret()
        );
        
        echo $access_token->getToken();
    }
    
//    public function authorize()
//    {
//        
//    }
}

