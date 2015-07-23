<?php /* ?ini charset="utf-8"?

# eZ Publish configuration file for Mailchimp Subscribe

[MailchimpSettings]
# Get the API Key and List ID from mailchimp
# Override the values below in /settings/override/mailchimp.ini.append.php
APIKey=99999999999999999999999999999999-us1
ListID=9999999999

# For compatibility with EAB's Galahad extension, we can have a different list
# for subscribe and for synchronisation
# 510f384c6d is the List ID for "Aylett Nurseries Newsletter"
SubscribeListID=510f384c6d

DoubleOptIn=true

[RecaptchaSettings]
Use=enabled
SiteKey=99999999999999999999999999999999
SecretKey=99999999999999999999999999999999

*/
