<?php
if (!$this->CheckPermission('Modify Site Preferences')) {
    return $this->Lang('error_permission');
}

// Create permissions
$this->CreatePermission(AWSCognito::MANAGE_PERM, 'Manage AWS Cognito Settings');

// Set default preferences
$this->SetPreference('enable_cognito', 0);
$this->SetPreference('clientId', '');
$this->SetPreference('clientSecret', '');
$this->SetPreference('domain', '');
$this->SetPreference('redirectUri', CMS_ROOT_URL . '/index.php?mact=AWSCognito,cntnt01,cognito_callback,0&showtemplate=false');

// Create events if they don't exist
\Events::CreateEvent('Core', 'OnLogin');
\Events::CreateEvent('Core', 'LoginPre');

// Register event handlers
$this->RegisterEvents();
