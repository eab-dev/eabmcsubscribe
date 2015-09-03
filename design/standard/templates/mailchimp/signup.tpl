{* Display Mailchimp sign up form
 *
 * Usage: {include uri="design:mailchimp/signup.tpl" consent="A consent message" signup="Text for the sign up button"}
 * The parameters are optional
 *
 *}

<form id="signup" action={"mailchimp/subscribe"|ezurl} method="post">
    <div class="block">
        <label for="fname">First name:</label>
        <input type="text" name="fname" id="fname" required="required"/>
    </div>
    <div class="block">
        <label for="lname">Last name:</label>
        <input type="text" name="lname" id="lname" required="required"/>
    </div>
    <div class="block">
        <label for="email">Email address:</label>
        <input type="email" name="email" id="email" required="required"/>
    </div>
    {if $consent}
    <div class="block">
        <label for="consent">{$consent|wash}</label>
        <input type="checkbox" name="consent" id="consent" value="1"/>
    </div>
    {else}
    <input type="hidden" name="consent" value="1"/>
    {/if}

    {if array('enabled', 'true')|contains( ezini( 'RecaptchaSettings', 'Use', 'mailchimp.ini' ))}
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <div class="g-recaptcha" data-sitekey="{ezini( 'RecaptchaSettings', 'SiteKey', 'mailchimp.ini' )}"></div>
    {/if}

    <div class="block buttons">
        <input class="button" type="submit" name="submit" value="{first_set( $signup, 'Sign up' )}"/>
    </div>

</form>

{*

<div id="message"></div>

{literal}
<script type="text/javascript">
$(document).ready(function() {
    $( '#signup' ).submit(function() {
        $( '#message' ).html( "Adding your email address..." );
        $.ajax({
            url: '/mailchimp/subscribe/ajax',
            data: $( '#signup' ).serialize(),
            success: function( msg ) {
                $( '#message' ).html( msg );
            }
        });
        return false;
    });
});
</script>
{/literal}
 *}
