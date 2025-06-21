<?php
// This file handles the LoginPost event

error_log("AWSCognito: LoginPost event file triggered");

// Set a cookie to indicate the user is authenticated with Cognito
if ($this->GetPreference('enable_cognito', 0)) {
    setcookie("cognito_user_session", "1", time() + 3600, "/admin", "", true, true);
    error_log("AWSCognito: LoginPost - Set cognito_user_session cookie");
}