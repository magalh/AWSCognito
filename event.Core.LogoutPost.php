<?php
// This file handles the LogoutPost event

error_log("AWSCognito: LogoutPost event file triggered");

// If Cognito is enabled, redirect to Cognito logout
if ($this->GetPreference('enable_cognito', 0)) {
    $settings = $this->GetCognitoSettings();
    
    if (!empty($settings['clientId']) && !empty($settings['domain'])) {
        // Clear session and cookies
        if (isset($_SESSION[CMS_USER_KEY])) {
            unset($_SESSION[CMS_USER_KEY]);
        }
        session_destroy();
        setcookie("cognito_user_session", "", time() - 3600, "/admin", "", true, true);
        
        // Redirect to Cognito logout
        $logoutUri = urlencode(CMS_ROOT_URL);
        header("Location: https://{$settings['domain']}/logout?client_id={$settings['clientId']}&logout_uri={$logoutUri}");
        exit;
    }
}