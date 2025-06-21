<?php
if (!$this->CheckPermission('Modify Site Preferences')) {
    return $this->Lang('error_permission');
}

// Remove permissions
$this->RemovePermission(AWSCognito::MANAGE_PERM);

// Remove preferences
$this->RemovePreference();

// Remove event handlers
$this->RemoveEventHandler('Core', 'LoginPre');
$this->RemoveEventHandler('Core', 'LogoutPost');

// Restore original .htaccess file
$this->UpdateAdminHtaccess(false);

// All done
return true;