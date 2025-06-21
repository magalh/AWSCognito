Version 1.0.7 - June 2024
-----------------------
* Changed redirectUri to be a fixed value instead of a configurable setting
* Made redirectUri field read-only in the admin settings
* Added click-to-select functionality for easy copying

Version 1.0.6 - June 2024
-----------------------
* Removed redundant admin_login_intercept.php file
* Simplified route registration in InitializeFrontend method

Version 1.0.5 - June 2024
-----------------------
* Enhanced .htaccess rules for more comprehensive redirection
* Added rules to handle /admin/ directory access
* Added rules to properly handle logout with query parameters
* Improved .htaccess management to update existing rules

Version 1.0.4 - June 2024
-----------------------
* Added .htaccess-based redirection for admin login page
* Created UpdateAdminHtaccess method to manage .htaccess redirects
* Added direct cognito action for .htaccess redirection

Version 1.0.3 - June 2024
-----------------------
* Changed from LoginDisplay to LoginPre event for better login interception
* Fixed login redirect issue

Version 1.0.2 - June 2024
-----------------------
* Fixed login page redirect issue
* Added logout handling to redirect to Cognito logout
* Added LogoutPost event handler
* Added route for admin/logout.php

Version 1.0.1 - June 2024
-----------------------
* Improved login page interception to redirect before form display
* Added LoginDisplay event handler
* Added admin_login_intercept action
* Added upgrade method for seamless version updates

Version 1.0.0 - June 2024
-----------------------
* Initial release
* Basic AWS Cognito integration
* Admin settings page for configuration