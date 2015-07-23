#eabmcsubscribe

eZ Publish 'legacy' extension providing a form allowing users to subscribe to Mailchimp.

##Summary

This eZ Publish 'legacy' extension provides a form allowing users to subscribe to Mailchimp.
It is based on [v2 of the MailChimp API](http://apidocs.mailchimp.com/api/2.0/)
and includes version 2.0.6 of the official client/wrapper.

##Options

The built-in options are:

* A consent checkbox for subscribers to tick before proceeding - disabled by default,
enabled by overriding a template

* Double opt-in - enabled by default, disabled by overriding settings

* Version 2.0 of the [ReCaptcha widget](https://developers.google.com/recaptcha/intro)
 - enabled by default, disabled by overriding settings

##License

[GNU General Public License 2.0](http://www.gnu.org/licenses/gpl-2.0.html)

##Copyright

Copyright (C) 2015 [Enterprise AB Ltd](http://eab.uk)

##Requirements

Requires eZ Publish 4 or 5.

##Installation

1. If you are using composer and have access to the EAB package repository, run:

        composer require eab/mailchimpsubscribe --update-no-dev --prefer-dist

   Otherwise, download and copy the `eabmcsubscribe` folder to the `extension` folder.

2. Edit `settings/override/site.ini.append.php`

3. Under `[ExtensionSettings]` add:

        ActiveExtensions[]=eabmcsubscribe

4. Copy `mailchimp.ini.append.php` to `settings/override/mailchimp.ini.append.php`
and edit it to customise the settings for your website.

5. Clear the cache and regenerate the autoload arrays:

        php bin/php/ezcache.php --clear-all
        php bin/php/ezpgenerateautoloads.php

##Usage

The URL of the subscribe form is at:

http://www.example.com/mailchimp/subscribe

##Customization

* To add text and images to the subscribe form override
`design/standard/templates/mailchimp/subscribe.tpl` in your own design template.

* To enable the consent checkbox for subscribers to tick before proceeding
override `design/standard/templates/mailchimp/subscribe.tpl` in your own
design template and add a `consent` parameter to the `{include uri="design:mailchimp/signup.tpl"}` line.
For example:

        {include uri="design:mailchimp/signup.tpl" consent="I agree to everything"}

* To disable the ReCaptcha widget edit `settings/override/mailchimp.ini.append.php`:

        [RecaptchaSettings]
        Use=disabled

* To disable double opt-in edit `settings/override/mailchimp.ini.append.php`:

        [MailchimpSettings]
        DoubleOptIn=disabled
