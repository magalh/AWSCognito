<?php
session_start();

$code = $_GET['code'];
$module = $this;
$settings = $module->GetCognitoSettings();

$clientSecret = $settings['clientSecret'];
$clientId = $settings['clientId'];
$domain = $settings['domain'];
$redirectUri = $settings['redirectUri'];

$ch = curl_init("https://$domain/oauth2/token");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    'grant_type' => 'authorization_code',
    'client_id' => $clientId,
    'client_secret' => $clientSecret,
    'code' => $code,
    'redirect_uri' => $redirectUri
]));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/x-www-form-urlencoded'
]);

$response = json_decode(curl_exec($ch), true);
$idToken = $response['id_token'];

$payload = json_decode(base64_decode(explode('.', $idToken)[1]), true);

$username = $payload['cognito:username'] ?? null;
$email = $payload['email'] ?? null;

if (!$username) {
    die("No username found in token");
}

$user = find_admin_user_by_username($username);
if ($user) {
    $login_ops = \CMSMS\LoginOperations::get_instance();
    $login_ops->save_authentication($user);
    setcookie("cognito_user_session", 1, 0, "/admin", "", true, true);
    header("Location: /admin/");
    exit;
} else {
    die("Access denied: no matching CMS user for username $username");
}

/**
 * A function find a matching user id given a username
 *
 * @internal
 * @access private
 * @param string the username
 * @return object The matching user object if found, or null otherwise.
 */
function find_admin_user_by_username($username)
{
    $gCms = \CmsApp::get_instance();
    $config = $gCms->GetConfig();
    $userops = $gCms->GetUserOperations();

    foreach ($userops->LoadUsers() as $user) {
        if (strcasecmp($user->username, $username) === 0) {
            return $user; // Found matching admin user
        }
    }

    return null;
}