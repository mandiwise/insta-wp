# Insta WP

## Description

Insta WP is a light-weight, jQuery-based WordPress plugin that allows you to embed Instagram image feeds in WordPress posts and pages using simple shortcodes.

Some features:

* Save your Instagram API authentication information directly in the Insta WP settings page
* Generate as many shortcodes as you like based on your desired image feed settings
* Customize the look of your feed (minimal baked-in CSS and unique class names for image feed containers makes this a breeze)

*Play it safe!*

You can implement one `[insta-hash ... ]` and one `[insta-user ... ]` shortcode on the same post or page, but things go sideways when you try to implement two of the same type of Insta WP shortcode within the same post or page. Hoping to sort this bug out in for a future release.

Watch for the following features in future releases of Insta WP:

* Option to create an image feed based on latitude and longitude coordinates
* Add an image feed pagination option to the shortcode (so a visitor can load more images from the feed by clicking a button)
* Localization of the plugin text

## Installation

1. Upload the insta-wp folder and its contents to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to the Appearance > Widget page, place the widget in your sidebar, and adjust the settings as needed.

## Frequently Asked Questions

### Why do I need to register for the Instagram API to use this plugin?

Take this under good authority ñ it's better to be in control of your own API key. If you rely on a plugin developer to supply an API key for you, and that developer then closes their Instagram account or otherwise vanishes into thin air, then the Instagram feed(s) on your website will stop working.

Don't worry, registering for the Instagram API isn't as onerous as it sounds (and you don't need to to know anything about web development to do it).

### How do I register for the Instagram API and get a Client ID?

Follow these simple steps to register for the Instagram API and create a Client ID to use with the Insta WP plugin on your WordPress site:

1. Visit [instagram.com/developer](http://instagram.com/developer) and log into your normal Instagram account.
2. Complete the developer sign up form.
3. Click the "Register a New Client" button. You'll go to the "Register new OAuth Client" form.
4. Enter the name of your WordPress site in the "Application Name" field.
5. Add a (very) brief description of your site in the "Description" field.
6. Enter your site URL In the "Website" field (e.g. http://www.yoursite.com).
7. Enter the URL for the Insta WP settings page from your WP admin area in the "Redirect URI" field (e.g. http://www.yoursite.com/wp-admin/plugins.php?page=insta-wp-options).
8. Click the "Register" button.
9. On the "Manage Clients" page, copy and paste the Client ID for the client you just created into the corresponding field on the Insta WP settings page in WordPress.

### How do I get an Instagram Access Token?

Getting an Access Token on your own can be tricky, but luckily this handy app can help you out:

1. Go to the [Pinceladasdaweb Token Generator](http://www.pinceladasdaweb.com.br/instagram/access-token/) and click the "Get Token" button.
2. You'll be prompted to log into your Instagram account.
3. Once you enter your username and password you'll be prompted to authorize access for the app. Click the "Authorize" button.
4. Copy and paste the generated Access Token into the corresponding field on the Insta WP settings page in WordPress.

If you're paranoid, you can always log into the Instagram developer area, click your username in the top right-hand corner, select "Edit Profile" from the drop-down, click the "Manage Applications" menu option, and revoke access for the Pinceladasdaweb Token Generator after you've grabbed your token and saved it in WordPress.

### Why don't X images always show up when I set `show="X"` in the hash tag shortcode?

According to Spectragram's developer this likely has to do with the method by which tagged items are fetched (it searches for "recently tagged" images vs. "all time" images). 

## Screenshots

1. Insta WP settings page
2. Instagram feed output

## Changelog

### 1.0
* Plugin initial release.

### Credit Roll

Insta WP could not have been made possible without:

* Tom McFarlin's time-saving [WordPress Plugin Boilerplate](https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate). Why start from scratch when you don't have to?
* Gilbert Pellegrom's [WordPress Settings Framework](https://github.com/gilbitron/WordPress-Settings-Framework) for plugins. Easy to work with, highly recommended.
* Adrian Quevedo's fantastic [jQuery Spectragram](https://github.com/adrianengine/jquery-spectragram) plugin... no fuss, no muss when it comes to working with the Instagram API and jQuery.

## Author Information

This plugin was originally created by [Mandi Wise](http://mandiwise.com/).

## License

Copyright (c) 2013, Mandi Wise

Insta WP is licensed under the GPL v2 or later (+ MIT for Wordpress Settings Framework).

> This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License, version 2, as published by the Free Software Foundation.

> This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

> You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA