<h2>Introduction</h2>
<p>The AWSCognito module provides seamless integration between CMS Made Simple and Amazon Web Services (AWS) Cognito for Admin authentication and management. This module enables your CMS to leverage AWS Cognito's robust identity and access management capabilities, allowing for secure admin authentication, and profile management.</p>

<h3>Features</h3>
<ul>
    <li>Admin authentication via AWS Cognito</li>
    <li>Secure password management and reset functionality</li>
    <li>Multi-factor authentication (MFA) support</li>
    <li>Session management and token handling</li>
</ul>

<h3>AWS Credentials Setup</h3>
<p>Before using this module, you need to obtain the necessary credentials from AWS:</p>

<h4>1. Create an AWS Account</h4>
<p>If you don't have an AWS account, sign up at <a href="https://aws.amazon.com" target="_blank">aws.amazon.com</a></p>

<h4>2. Set up AWS Cognito User Pool</h4>
<ol>
    <li>Log into the AWS Management Console</li>
    <li>Navigate to Amazon Cognito service</li>
    <li>Click "Create user pool"</li>
    <li>Configure your user pool settings (Sign-in options, Authentication methods, etc.)</li>
</ol>

<h4>3. Set up callbacks</h4>
<ol>
    <li>Applications -> App client</li>
    <li>Click on Login pages Tab -> Edit</li>
    <li>Allowed callback URLs: copy from module</li>
    <li>Allowed sign-out URLs - optional: Your website homepage</li>
</ol>

<h4>4. Register Users</h4>
<ol>
    <li>Navigate to User management -> Users</li>
    <li>Click "Create user"</li>
    <li>Configure your user settings and match username with your local user username.</li>
</ol>

<h4>5. Required Configuration Values</h4>
<p>You'll need these values for the module configuration:</p>
<ul>
    <li><strong>Cognito domain:</strong> Cognito domain or Custom Cognito domain (Branding -> Domain)</li>
    <li><strong>User Pool Client ID:</strong> Found in your User Pool's App clients section (Applications -> App clients)</li>
    <li><strong>User Pool Client secret:</strong> Found in your User Pool's App clients section (Applications -> App clients)</li>
</ul>

<h3>Usage</h3>
<p>After installation and configuration with your AWS credentials:</p>
<ol>
    <li>Configure the module with your AWS Cognito credentials in the admin panel</li>
</ol>

<h3>Security Considerations</h3>
<ul>
    <li>Store AWS credentials securely and never commit them to version control</li>
    <li>Enable MFA for enhanced security</li>
    <li>Regularly rotate access keys</li>
    <li>Monitor AWS CloudTrail logs for suspicious activity</li>
</ul>

<h3>Feedback/Support</h3>
<p>This module does not include commercial support. However, there are a number of resources available to help you with it:</p>
<ul>
  <li>For the latest version of this module or to file a Feature Request or Bug Report, please visit the <a href="https://github.com/magalh/AWSCognito" target="_blank">AWSCognito GitHub Page</a>.</li>
    <li>If you didn't find an answer to your question, you are warmly invited to open a new issue on the <a href="https://github.com/magalh/AWSCognito/issues" target="_blank">AWSCognito GitHub Issues Page</a>.</li>
</ul>

<h3>Copyright and License</h3>
<p>Copyright &copy; 2025, AWSCognito Module Developer. All Rights Are Reserved.</p>
<p>This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.</p>
<p>However, as a special exception to the GPL, this software is distributed
as an addon module to CMS Made Simple.  You may not use this software
in any Non GPL version of CMS Made simple, or in any version of CMS
Made simple that does not indicate clearly and obviously in its admin
section that the site was built with CMS Made simple.</p>
<p>This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
Or read it <a href="http://www.gnu.org/licenses/licenses.html#GPL">online</a>
</p>