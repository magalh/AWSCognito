<?php
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