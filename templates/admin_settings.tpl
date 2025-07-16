<h3>{$mod->Lang('settings')}</h3>

<div class="pageoverflow">
    {$startform}
    <div class="pageoverflow">
        <p class="pagetext">{$mod->Lang('enable_cognito')}:</p>
        <p class="pageinput">
            <input type="checkbox" name="{$actionid}enable_cognito" value="1" {if $enable_cognito}checked="checked"{/if} />
            
                {if $login_hook_valid}
                    <span style="color: green; margin-left: 10px;">✓ Login hook active</span>
                {else}
                    <span style="color: red; margin-left: 10px;">⚠ Login hook missing</span>
                {/if}
            
        </p>
    </div>
    
    <div class="pageoverflow">
        <p class="pagetext">{$mod->Lang('client_id')}:</p>
        <p class="pageinput">
            <input type="text" name="{$actionid}clientId" value="{$clientId}" size="50" maxlength="255" />
        </p>
    </div>
    
    <div class="pageoverflow">
        <p class="pagetext">{$mod->Lang('client_secret')}:</p>
        <p class="pageinput">
            <input type="text" name="{$actionid}clientSecret" value="{$clientSecret}" size="50" maxlength="255" />
        </p>
    </div>
    
    <div class="pageoverflow">
        <p class="pagetext">{$mod->Lang('domain')}:</p>
        <p class="pageinput">
            <input type="text" name="{$actionid}domain" value="{$domain}" size="50" maxlength="255" />
            <br/>
            <span class="description">{$mod->Lang('domain_help')}</span>
        </p>
    </div>
    
    <div class="pageoverflow">
        <p class="pagetext">{$mod->Lang('redirect_uri')}:</p>
        <p class="pageinput">
            <input type="text" value="{$redirectUri}" size="80" readonly="readonly" onclick="this.select();" style="background-color: #f0f0f0;" />
            <br/>
            <span class="description">{$mod->Lang('redirect_uri_help')}</span>
        </p>
    </div>
    
    <div class="pageoverflow">
        <p class="pagetext">&nbsp;</p>
        <p class="pageinput">{$submit}</p>
    </div>
    {$endform}
</div>