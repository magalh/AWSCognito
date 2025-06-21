# AWS Cognito Module for CMS Made Simple (v1.2.1)

This module integrates AWS Cognito authentication with CMS Made Simple admin login.

## Features

- Redirects admin login to AWS Cognito authentication
- Maps Cognito users to CMS Made Simple admin users
- Configurable settings for Cognito integration

## Installation

1. Install the module through the Module Manager
2. Configure the module settings with your AWS Cognito credentials
3. Enable the Cognito integration

## Configuration

1. Go to Extensions > AWS Cognito
2. Enter your AWS Cognito credentials:
   - Client ID
   - Client Secret
   - Cognito Domain
   - Redirect URI
3. Check "Enable AWS Cognito Authentication"
4. Save settings

## Requirements

- CMS Made Simple 2.2.1 or higher

## Notes

- The Cognito username must match the CMS Made Simple admin username
- Make sure your Cognito app is properly configured with the correct redirect URI