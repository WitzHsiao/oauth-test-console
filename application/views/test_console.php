<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script src="http://code.jquery.com/jquery-1.7.2.min.js" type="text/javascript"></script>
        <style type="text/css">
            .input_width {
                width: 400px;
            }
            
            .readonly_textarea {
                width: 600px;
                height: 100px;
            }
        </style>
    </head>
    <body>
        <h1> API & OAuth test console for Developers </h1>
        <br />
        <p>
            <label>Consumer Key:</label>
            <input type="text" id="ck" name="ck" class="input_width" />
        </p>
        <p>
            <label>Consumer Secret:</label>
            <input type="text" id="cs" name="cs" class="input_width" />
        </p>
        <p>
            <label>Token Key:</label>
            <input type="text" id="tk" name="tk" class="input_width" />
        </p>
        <p>
            <label>Token Secret:</label>
            <input type="text" id="ts" name="ts" class="input_width" />
        </p>
        <p>
            <button id="btn_get_request_token" onclick="get_request_token()">Get Request Token</button>
            <button id="btn_open_authorization_url" onclick="open_authorization_url()">Open Authorization URL</button>
            <button id="btn_get_acesss_token" onclick="get_access_token()">Get Access Token</button>
        </p>
        <p>
            <label>api: </label>
            <input type="text" id="api" name="api" class="input_width" />
            <button id="btn_invoke_api">Invoke api</button>
        </p>
        <p>
            <label>Request: </label>
            <textarea class="readonly_textarea" id="request" readonly></textarea>
        </p>
        <p>
            <label>Response: </label>
            <textarea class="readonly_textarea" id="response" readonly></textarea>
        </p>
        
        <script  type="text/javascript">
            
            function get_request_token() {
                var consumerKey = $('#ck').val();
                var consumerSecret = $('#cs').val();
                var url = 'http://localhost:8888/CI_OauthTestConsole/index.php/oauth/request_token';
                
                $.post(url, 
                    { ck: consumerKey, cs: consumerSecret}, 
                    function(data){
                        $('#tk').val(data.oauth_token);
                        $('#ts').val(data.oauth_secret);
                    }, 
                    'json'
                );
            }
            
            function open_authorization_url() {
                var url = 'http://hello.local:8888/oauth/authorize?oauth_token=' + $('#tk').val();
                window.open(url);
            }
            
            function get_access_token() {
                var url = 'http://localhost:8888/CI_OauthTestConsole/index.php/oauth/access_token?request_token=' + 
                    $('#tk').val() + '&ck=' + $('#ck').val() + '&cs=' + $('#cs').val();
                window.open(url);
            }
        </script>
    </body>
</html>