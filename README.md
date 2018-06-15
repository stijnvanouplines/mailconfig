# Mailconfig
Simple IMAP/SMTP AutoDiscover, AutoConfig and MobileConfig

*This project is still in development. We are going to document how to implement on an Apache/NGINX server*

This project provides:
* AutoDiscover (Outlook)
* AutoConfig (Thunderbird)
* MobileConfig (MacOS/iOS)

## About
This script ensures that the data about incoming/outgoing mailservers, authentication, connection security etc. are automatically entered in your mail client. AutoDiscover is supported by two frequently used mail clients: Outlook for Windows (AutoDiscover) and Thunderbird for Mac and Windows (AutoConfig). Apple Mail for macOS / iOS does not support AutoDiscover or AutoConfig, for that we have an alternative: MobileConfig! Navigate with your Apple device (Safari browser) to `mailconfig.mycompany.com/mobileconfig`, enter your email address and press the submit button. Your Apple device will recognize and open the file. You must give permission to install the profile. Then enter your password and you are ready to go!

## Installation
Clone the repo:
```bash
git clone https://github/solitweb/mailconfig
```
Move all the files in the [dist](https://github.com/solitweb/mailconfig/tree/master/dist) folder to a (sub)domain e.g. `mailconfig.mycompany.com`. Make the [public](https://github.com/solitweb/mailconfig/tree/master/dist/public) folder your web directory.

## Configuration
You need to copy the [config.example.php](https://github.com/solitweb/mailconfig/blob/master/dist/config.example.php) to `config.php`. Next, edit the configuration variables:

```php
return [
    'company_name' => 'My Company',
    'company_url' => 'https://mycompany.com',

    'domain' => 'mailconfig.mycompany.com',
    'domain_required' => true,
    'ttl' => '168',

    'language_dir' => '../languages',
    'fallback_locale' => 'en',
 
    'imap' => [
        'host' => 'imap.mycompany.com',
        'port' => '993',
        'socket' => 'SSL',
    ],

    'smtp' => [
        'host' => 'smtp.mycompany.com',
        'port' => '587',
        'socket' => 'SSL',
    ],

    'ssl' => [
        'cert' => 'ssl/cert.pem',
        'key' => 'ssl/key.pem',
        'ca' => 'ssl/ca.pem',
    ],
];
```

### SSL
Provide your users with a extra layer of trust and add a SSL certificate, the mobileconfig will then be signed. move the `cert`, `key` and `ca` files to the `ssl/` directory.

## Translations
We added some languages and we are happy to receive pull requests to add more languages :blush:. Just create a new file, the filename must be a [proper language code](https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes) and the file extension `.json`. For example:
* en.json
* nl.json
* fr.json
* ...

Add the template displayed here and fill in the open values:
```json
{
    "Enter your email address": "",
    "Enter your email address and receive a configuration profile to configure your email on your device.": "",
    "All rights reserved.": "",
    "Submit": ""
}
```
Move the file to the `languages/` folder. That's it! Your file will now be recognized by the script and your language wil be available from the dropdown menu.

*To disable a language just delete the language file from the language folder.*

## Todo
- [ ] Document how to implement on a Apache/NGINX server
- [ ] Document how to configure DNS settings