<?php
#---------------------------------------------------------------------------------------------------
# Module: AWSCognito
# Authors: Magal Hezi, with CMS Made Simple Foundation.
# Copyright: (C) 2025 Magal Hezi, h_magal@hotmail.com
# Licence: GNU General Public License version 3. See http://www.gnu.org/licenses/  
#---------------------------------------------------------------------------------------------------
# CMS Made Simple(TM) is (c) CMS Made Simple Foundation 2004-2020 (info@cmsmadesimple.org)
# Project's homepage is: http://www.cmsmadesimple.org
# Module's homepage is: https://github.com/magalh/AWSCognito
#---------------------------------------------------------------------------------------------------
# This program is free software; you can redistribute it and/or modify it under the terms of the GNU
# General Public License as published by the Free Software Foundation; either version 3 of the 
# License, or (at your option) any later version.
#
# However, as a special exception to the GPL, this software is distributed
# as an addon module to CMS Made Simple.  You may not use this software
# in any Non GPL version of CMS Made simple, or in any version of CMS
# Made simple that does not indicate clearly and obviously in its admin
# section that the site was built with CMS Made simple.
#
# This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; 
# without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
# See the GNU General Public License for more details.
#---------------------------------------------------------------------------------------------------
#
# Amazon Web Services, AWS, and the Powered by AWS logo are trademarks of Amazon.com, Inc. or its affiliates
#---------------------------------------------------------------------------------------------------

class AWSCognito extends CMSModule
{
    const MANAGE_PERM = 'manage_AWSCognito';
    
    public function GetVersion() { return '1.2.1'; }
    public function GetFriendlyName() { return $this->Lang('friendlyname'); }
    public function GetAdminDescription() { return $this->Lang('admindescription'); }
    public function IsPluginModule() { return TRUE; }
    public function HasAdmin() { return TRUE; }
    public function VisibleToAdminUser() { return $this->CheckPermission(self::MANAGE_PERM); }
    public function GetAuthor() { return 'Based on Homlee module'; }
    public function GetAuthorEmail() { return ''; }
    public function UninstallPreMessage() { return $this->Lang('ask_uninstall'); }
    public function GetAdminSection() { return 'security'; }
    public function MinimumCMSVersion() { return '2.2.1'; }

    public function InitializeFrontend() {
        $this->RegisterModulePlugin();
        $this->RestrictUnknownParams();
        
        $this->SetParameterType('action', CLEAN_STRING);
        
        // Register direct route for login interception
        if ($this->GetPreference('enable_cognito', 0)) {
            $this->RegisterRoute('/admin/login.php', ['action' => 'login_intercept']);
        }

    }

    public function InitializeAdmin() {
        $this->CreateParameter('action', 'default', $this->Lang('help_param_action'));
    }
    
    public function GetHelp() { return 'AWS Cognito integration module for CMS Made Simple.'; }
    public function GetChangeLog() { return @file_get_contents(__DIR__.'/doc/changelog.inc'); }
    
    /**
     * Hook to redirect admin login to Cognito and handle logout
     */
    public function DoEvent($originator, $eventname, &$params) {
        // Log all events for debugging
        error_log("AWSCognito: Event triggered - $originator::$eventname");
        
        // Test LoginPre and LogoutPost events
        if ($originator == 'Core' && $eventname == 'LoginPre') {
            echo "<!-- AWSCognito: LoginPre event triggered -->";
            error_log("AWSCognito: LoginPre event triggered with params: " . print_r($params, true));
            
            /*// If Cognito is enabled, try to redirect
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
            }*/
        }

        if ($originator == 'Core' && $eventname == 'LoginPost') {
            echo "<!-- AWSCognito: LoginPost event triggered -->";
            error_log("AWSCognito: LoginPost event triggered");
        }
        
        if ($originator == 'Core' && $eventname == 'LogoutPost') {
            echo "<!-- AWSCognito: LogoutPost event triggered -->";
            error_log("AWSCognito: LogoutPost event triggered");
        }
    }
    
    /**
     * Get the Cognito settings
     */
    public function GetCognitoSettings() {
        $settings = [
            'clientId' => $this->GetPreference('clientId', ''),
            'clientSecret' => $this->GetPreference('clientSecret', ''),
            'domain' => $this->GetPreference('domain', ''),
            'redirectUri' => CMS_ROOT_URL . '/index.php?mact=AWSCognito,cntnt01,cognito_callback,0&showtemplate=false'
        ];
        
        return $settings;
    }

    /**
     * Create or update the .htaccess file in the admin directory
     * to redirect login.php to our Cognito action
     */
    public function UpdateAdminHtaccess($enable = true) {
        $config = \cms_utils::get_config();
        $admin_dir = $config['root_path'] . '/' . $config['admin_dir'];
        $htaccess_file = $config['root_path'] . '/.htaccess';
        
        // Backup existing .htaccess if it exists
        if (file_exists($htaccess_file) && !file_exists($htaccess_file . '.bak')) {
            copy($htaccess_file, $htaccess_file . '.bak');
        }
        
        if ($enable) {
            // Create or update .htaccess file
            $module_name = 'AWSCognito';
            $base_url = CMS_ROOT_URL;
            
            $htaccess_content = "# AWSCognito module redirect\n";
            $htaccess_content .= "<IfModule mod_rewrite.c>\n";
            $htaccess_content .= "RewriteEngine On\n\n";
            
            // Redirect /admin/ to Cognito login if not authenticated
            $htaccess_content .= "\tRewriteCond %{REQUEST_URI} ^/".$config['admin_dir']."/?$\n";
            $htaccess_content .= "\tRewriteCond %{HTTP_COOKIE} !cognito_user_session=1\n";
            $htaccess_content .= "\tRewriteRule ^admin/?$ {$base_url}/index.php?mact={$module_name},cntnt01,cognito,0&showtemplate=false [R=302,L]\n\n";
            
            // Redirect /admin/login.php to Cognito login - using THE_REQUEST for more reliable matching
            $htaccess_content .= "\t# Redirect /admin/login.php to Cognito login if not already authenticated\n";
            $htaccess_content .= "\tRewriteCond %{THE_REQUEST} ^[A-Z]{3,}\\s/".$config['admin_dir']."/login\\.php [NC]\n";
            $htaccess_content .= "\tRewriteRule ^ {$base_url}/index.php?mact={$module_name},cntnt01,cognito,0&showtemplate=false [R=302,L]\n\n";
            
            // Redirect /admin/logout.php to Cognito logout
            $htaccess_content .= "\t# Redirect /".$config['admin_dir']."/logout.php to Cognito logout\n";
            $htaccess_content .= "\tRewriteCond %{REQUEST_URI} ^/".$config['admin_dir']."/logout.php$\n";
            $htaccess_content .= "\tRewriteCond %{QUERY_STRING} ^__c=([a-z0-9]+)$\n";
            $htaccess_content .= "\tRewriteRule ^".$config['admin_dir']."/logout.php$ {$base_url}/index.php?mact={$module_name},cntnt01,cognito_logout,0&cntnt01__c=%1&showtemplate=false [R=302,L]\n";
            
            $htaccess_content .= "</IfModule>\n";
            
            // Append to existing .htaccess or create new one
            if (file_exists($htaccess_file)) {
                // Check if our rule already exists
                $current_content = file_get_contents($htaccess_file);
                if (strpos($current_content, 'AWSCognito module redirect') === false) {
                    file_put_contents($htaccess_file, "\n" . $htaccess_content, FILE_APPEND);
                } else {
                    // Replace existing AWSCognito rules
                    $new_content = preg_replace('/# AWSCognito module redirect.*?<\/IfModule>\n/s', $htaccess_content, $current_content);
                    file_put_contents($htaccess_file, $new_content);
                }
            } else {
                file_put_contents($htaccess_file, $htaccess_content);
            }
        } else {
            // When disabling, always remove the rules from the current .htaccess file
            if (file_exists($htaccess_file)) {
                $content = file_get_contents($htaccess_file);
                // Check if our rules exist in the file
                if (strpos($content, 'AWSCognito module redirect') !== false) {
                    // Remove our rules from the file
                    $content = preg_replace('/\n*# AWSCognito module redirect.*?<\/IfModule>\n*/s', "\n", $content);
                    file_put_contents($htaccess_file, $content);
                }
            }
        }
        
        return true;
    }
}