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