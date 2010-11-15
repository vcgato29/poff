<!doctype html>
<html>
  <!--
Copyright Facebook Inc.

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
-->
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>Connect JavaScript - jQuery Login Example</title>
  </head>
  <body>
    <h1>Connect JavaScript - jQuery Login Example</h1>
    <div>
      <button id="login">Login</button>
      <button id="logout">Logout</button>
      <button id="disconnect">Disconnect</button>
    </div>
    <div id="user-info" style="display: none;"></div>
    

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>

    <div id="fb-root"></div>
    <script>
      // initialize the library with the API key
   	  window.fbAsyncInit = function() {
	    FB.init({appId: 'd4f4a4800e3770f12ccad4f300d91f44', status: true, cookie: true,
	             xfbml: true});
	  };
	  (function() {
	    var e = document.createElement('script'); e.async = true;
	    e.src = document.location.protocol +
	      '//connect.facebook.net/en_US/all.js';
	    document.getElementById('fb-root').appendChild(e);
	  }());

      $('#login').bind('click', function() {
        FB.login(handleSessionResponse, {perms: "email"});
      });

      $('#logout').bind('click', function() {
        FB.logout(handleSessionResponse);
      });

      $('#disconnect').bind('click', function() {
        FB.api({ method: 'Auth.revokeAuthorization' }, function(response) {
          clearDisplay();
        });
      });

      // no user, clear display
      function clearDisplay() {
        $('#user-info').hide('fast');
      }

      // handle a session response from any of the auth related calls
      function handleSessionResponse(response) {
        // if we dont have a session, just hide the user info
        if (!response.session) {
          clearDisplay();
          return;
        }

        
		var perms = response.perms.split(',');
		for(z in perms){
			if(perms[0] == 'email'){
				var link = '<?php echo url_for('@facebook', array('action' => 'connect')) ?>';
				window.location = link;
			}
		}

        // if we have a session, query for the user's profile picture, name and email
        FB.api(
          {
            method: 'fql.query',
            query: 'SELECT name, pic FROM profile WHERE id=' + FB.getSession().uid
          },
          function(response) {
            var user = response[0];


            
			//FB.api({method: 'fql.query',
				//	query: 'SELECT email FROM user WHERE uid=' + FB.getSession().uid},function(response){
						//alert('Your mail is mine now >D ' + response[0].email);
			//});

            
            $('#user-info').html('<img src="' + user.pic + '">' + user.name).show('fast');
          }
        );
      }
    </script>
  </body>
</html>