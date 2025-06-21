<?php
// This file handles the LoginPre event

error_log("AWSCognito: LoginPre event file triggered");

// If Cognito is enabled, try to redirect
if ($this->GetPreference('enable_cognito', 0)) {
    $settings = $this->GetCognitoSettings();
    if (!empty($settings['clientId']) && !empty($settings['domain'])) {
        error_log("AWSCognito: LoginPre - Attempting to redirect to Cognito");
        $redirectUri = urlencode($settings['redirectUri']);
        header("Location: https://{$settings['domain']}/oauth2/authorize?response_type=code&client_id={$settings['clientId']}&redirect_uri={$redirectUri}&scope=email+openid");
        exit;
    } else {
        error_log("AWSCognito: LoginPre - Missing clientId or domain settings");
    }
} else {
    error_log("AWSCognito: LoginPre - Cognito integration not enabled");
}