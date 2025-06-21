<?php
if (isset($params['__c']) && $params['__c'] == $_SESSION[CMS_SECURE_PARAM_NAME]) {
    unset($_SESSION[CMS_USER_KEY]);
    session_destroy();
    echo "Logout successful.";
    exit();
}

setcookie("cognito_user_session", "", time() - 3600, "/admin", "", true, true);

$module = $this;
$settings = $module->GetCognitoSettings();

$clientId = $settings['clientId'];
$logoutUri = urlencode(CMS_ROOT_URL);
$domain = $settings['domain'];

header("Location: https://$domain/logout?client_id=$clientId&logout_uri=$logoutUri");
exit;