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

if( !defined('CMS_VERSION') ) exit;

if (!$this->CheckPermission(AWSCognito::MANAGE_PERM)) {
    return;
}

// Save settings if form was submitted
if (isset($params['submit'])) {
    $enable_cognito_old = $this->GetPreference('enable_cognito', 0);
    $enable_cognito_new = isset($params['enable_cognito']) ? 1 : 0;
    
    $this->SetPreference('enable_cognito', $enable_cognito_new);
    $this->SetPreference('clientId', $params['clientId']);
    $this->SetPreference('clientSecret', $params['clientSecret']);
    $this->SetPreference('domain', $params['domain']);
    
    $this->UpdateAdminHtaccess($enable_cognito_new);
    
    echo $this->ShowMessage($this->Lang('settings_saved'));
}

// Get current settings
$settings = $this->GetCognitoSettings();
$enable_cognito = $this->GetPreference('enable_cognito', 0);

// Create the settings form
$smarty->assign('startform', $this->CreateFormStart($id, 'defaultadmin', $returnid));
$smarty->assign('endform', $this->CreateFormEnd());
$smarty->assign('submit', $this->CreateInputSubmit($id, 'submit', $this->Lang('submit')));

$smarty->assign('enable_cognito', $enable_cognito);
$smarty->assign('clientId', $settings['clientId']);
$smarty->assign('clientSecret', $settings['clientSecret']);
$smarty->assign('domain', $settings['domain']);
$smarty->assign('redirectUri', $settings['redirectUri']);

echo $this->ProcessTemplate('admin_settings.tpl');