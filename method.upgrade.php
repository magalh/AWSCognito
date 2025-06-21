<?php
if (!$this->CheckPermission('Modify Site Preferences')) {
    return $this->Lang('error_permission');
}

switch($oldversion) {
    case '1.0.0':
        // Remove old event handlers
        $this->RemoveEventHandler('Core', 'LoginPost');
        $this->RemoveEventHandler('Core', 'CheckPageRequestStart');
        
        // LoginPre is now used in 1.0.3, so we don't remove it here
        
        // No break here - all upgrades should cascade
    case '1.0.1':
        // Add logout event handler
        $this->AddEventHandler('Core', 'LogoutPost', false);
        
        // No break here - all upgrades should cascade
    case '1.0.2':
        // Switch from LoginDisplay to LoginPre
        $this->RemoveEventHandler('Core', 'LoginDisplay');
        $this->AddEventHandler('Core', 'LoginPre', false);
        
        // No break here - all upgrades should cascade
    case '1.0.3':
        // Create .htaccess file for admin login redirect
        if ($this->GetPreference('enable_cognito', 0)) {
            $this->UpdateAdminHtaccess(true);
        }
        
        // No break here - all upgrades should cascade
    case '1.0.4':
        // Update .htaccess file with more comprehensive rules
        if ($this->GetPreference('enable_cognito', 0)) {
            $this->UpdateAdminHtaccess(true);
        }
        
        // No break here - all upgrades should cascade
    case '1.0.5':
        // Remove admin_login_intercept.php as it's no longer needed
        $file = $this->GetModulePath() . '/action.admin_login_intercept.php';
        if (file_exists($file)) {
            @unlink($file);
        }
        
        // No break here - all upgrades should cascade
    case '1.0.6':
        // Remove redirectUri preference as it's now fixed
        $this->RemovePreference('redirectUri');
        
        // No break here - all upgrades should cascade
    case '1.0.7':
        // Update .htaccess file to use THE_REQUEST for more reliable matching
        if ($this->GetPreference('enable_cognito', 0)) {
            $this->UpdateAdminHtaccess(true);
        }
        
        // No break here - all upgrades should cascade
    case '1.0.8':
        // Improve .htaccess handling when disabling the module
        if ($this->GetPreference('enable_cognito', 0)) {
            $this->UpdateAdminHtaccess(true);
        } else {
            $this->UpdateAdminHtaccess(false);
        }
        
        // No break here - all upgrades should cascade
}

// Always return true for successful upgrade
return true;