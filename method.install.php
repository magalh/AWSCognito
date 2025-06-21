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
\Events::CreateEvent('Core', 'LoginPre');
\Events::CreateEvent('Core', 'LoginPost');
\Events::CreateEvent('Core', 'LogoutPost');

// Register event handlers
$this->AddEventHandler('Core', 'LoginPre');
$this->AddEventHandler('Core', 'LoginPost');
$this->AddEventHandler('Core', 'LogoutPost');

// All done
return true;