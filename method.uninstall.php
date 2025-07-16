<?php
if (!$this->CheckPermission('Modify Site Preferences')) {
    return $this->Lang('error_permission');
}

// Remove permissions
$this->RemovePermission(AWSCognito::MANAGE_PERM);
$this->UpdateAdminLogin(false);
// Remove preferences
$this->RemovePreference();

// Remove event handlers
$this->RemoveEventHandler('Core', 'OnLogin');
$this->RemoveEventHandler('Core', 'LoginPre');
$this->RemoveEventHandler('Core', 'LoginPost');
$this->RemoveEventHandler('Core', 'LogoutPost');
\Events::RemoveEvent('Core', 'OnLogin');

// Restore original .htaccess file
$this->UpdateAdminHtaccess(false);

// All done
return true;