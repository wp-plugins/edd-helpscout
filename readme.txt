=== HelpScout integration for Easy Digital Downloads ===
Contributors: DvanKooten
Donate link: https://dannyvankooten.com/donate/
Tags: easy-digital-downloads,helpscout,edd,support,help scout
Requires at least: 3.8
Tested up to: 4.1
Stable tag: 1.0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easy Digital Downloads integration for HelpScout. Shows purchase information right from your HelpScout interface.

== Description ==

HelpScout integration for Easy Digital Downloads is a WordPress plugin that will show customer information right from your HelpScout dashboard.

Activating the plugin and configuring the integration will add the following information to your HelpScout dashboard:

- All payments by the customer (email address must match)
- A link to resent purchase receipts
- All purchased "downloads"
- The used payment method. Links to the transaction in PayPal or Stripe.

If using the Software Licensing add-on, the following information is shown as well:

- License keys. Links to the Site Manager in Easy Digital Downloads.
- Active sites, with a link to deactivate the license for the given site.

**How to install and configure**

Have a look at the [installation instructions](https://wordpress.org/plugins/edd-helpscout/installation/).

**More information**

- Developers; follow or contribute to the [plugin on GitHub](https://github.com/dannyvankooten/edd-helpscout)
- Other [WordPress plugins](https://dannyvankooten.com/wordpress-plugins/#utm_source=wp-plugin-repo&utm_medium=link&utm_campaign=more-info-link) by [Danny van Kooten](https://dannyvankooten.com#utm_source=wp-plugin-repo&utm_medium=link&utm_campaign=more-info-link)
- [@DannyvanKooten](https://twitter.com/dannyvankooten) on Twitter

== Installation ==

To get this up an running, you'll need to configure a few things in WordPress and HelpScout.

= WordPress =

1. Upload the contents of **edd-helpscout.zip** to your plugins directory, which usually is `/wp-content/plugins/`.
1. Activate the **HelpScout integration for Easy Digital Downloads** plugin
1. Set the **HELPSCOUT_SECRET_KEY** constant in your `/wp-config.php` file. This should be a random string of 40 characters.


_Example_
`
define( 'HELPSCOUT_SECRET_KEY', 'ueCQWKbZ48BT6UGmCFbaqXtbLaDZu1v6rnBLZjKD' );
`

= HelpScout =

1. Go to the [HelpScout custom app interface](https://secure.helpscout.net/apps/custom/).
1. Enter the following settings.

**App Name:** Easy Digital Downloads

**Content Type:** Dynamic Content

**Callback URL:** https://your-site.com/edd-hs-api/customer-data.json _(I recommend using HTTPS)_

**Secret Key:** The value of your **HELPSCOUT_SECRET_KEY** constant.


== Frequently Asked Questions ==

= HelpScout just shows "Invalid Signature" =

Make sure the "Secret Key" setting for your HelpScout application matches the value of your `HELPSCOUT_SECRET_KEY` constant. This key is used to authorize requests coming from HelpScout.

== Screenshots ==

1. Purchases and other information related to the customer is shown in the bottom right corner of your HelpScout interface.

== Changelog ==

= 1.0.2 =

**Improvements**

- The plugin used to "listen" to all requests to the site. It will now (after confirmation) only listen to requests to `/edd-hs-api/customer-data.json`.

= 1.0.1 =

**Fixed**

- Issue with nonces not working properly for the admin actions. Now using the HelpScout signature to validate requests.

**Improvements**

- Minor code & inline documentation improvements

**Additions**

- Added "renewal" label to renewals

= 1.0.2 =

Plugin now uses a single URL endpoint to use as the HelpScout App Callback URL.

