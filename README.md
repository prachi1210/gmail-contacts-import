# Gmail Contacts Import

A simple web app in PHP allowing login with Google using oAuth 2.0 and import contacts using Contacts 3.0 API.
Each login is stored in a database.

####Instructions for setup
  1. Modify variables for connection.inc.php.sample according to your local machine and save it as connection.inc.php
  2. Go to console.developers.google.com and create a project. 
  
     > Enable Google+ API and Contacts 3.0 API
     
     > Create credentials to access your enabled APIs
     
     > Set Authorized JavaScript origins and redirect URIs
  3. Modify variables for constants.inc.php.sample according to ClientId and ClientSecret received from Google Developers site.
  4. For importcontacts.php to work, you'd require [Google APIs Client Library](https://github.com/google/google-api-php-client)


####Issues to be fixed 
  createAuthUrl() returns an encoded url with a raw '&' character as a separator.
  
  See [Similar Issue on Google APIs Client Library](https://github.com/google/google-api-php-client/issues/76)
  
