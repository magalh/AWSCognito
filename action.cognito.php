<?php
// This is the main action for Cognito redirection
// It will be called by the .htaccess redirect

// Check if Cognito integration is enabled
if ($this->GetPreference('enable_cognito', 0)) {
    // Get Cognito settings
    $settings = $this->GetCognitoSettings();
    
    // Redirect to Cognito login
    $clientId = $settings['clientId'];
    $redirectUri = urlencode($settings['redirectUri']);
    $domain = $settings['domain'];
    
    // Force redirect to Cognito
    header("Location: https://$domain/oauth2/authorize?response_type=code&client_id=$clientId&redirect_uri=$redirectUri&scope=email+openid");
    exit;
}