=== GOT-WP-Login-Register ===
Contributors: Rodgath
Tags: login, signin, register, signup, google, google login, google sign in, google one tap, google signup, google register, google auth, open id
Requires at least: 5.0
Tested up to: 5.5
Stable tag: 1.0
Requires PHP: 5.6
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Secure WordPress signin and signup using Google One-Tap and Google SignIn button through Google Authentication API.

== Description ==

This plugin allows user account creation and management using the Google Authentication API. 

Users can login securely to their existing WordPress account with their Google email.

Users who are not registered on a WordPress website can securely register and create an account using their Google email.


### General Features:

* Easy to use options panel.
* Seemless WordPress user account creation using the user's Google email.
* Completely customizable using the options panel; *position, layout, color, size, shape and more*.
* Works with any WordPress theme.
* Visible only to non-logged in users.
* Modern browsers compatible.
* Shortcode support. 
* Customizable look and feel.
* Automatic Constant Updates.


### Google One-Tap Features:

* One-Tap has 3 Contexts: *"Sign in with Google"*, *"Sign up with Google"*, *"Use with Google"*
* Login UX Mode: *Popup window* or *Google page redirection*.
* Auto-select(Yes/No): Whether or not to return an ID token automatically, without any user interaction.
* Cancel on tap outside(Yes/No): Whether or not to cancel the One Tap request if the user clicks outside of the prompt.


### Google Signin Button Features:

* *Position* — Above the form, Top of the form, Bottom of the form.
* *Style* — Standard, Icon.
* *Theme* — Outline, Blue-filled, Black-filled.
* *Size* — Large, Medium, Small.
* *Text* — Sign in with Google, Sign up with Google, Continue with Google, Sign in.
* *Shape* — Rectangular, Pill, Circle, Square.
* *Custom width* — Enter the preferred widget width.
* *Logo alignment* — Align left or right.
* *Google SignIn button* — shortcode on any page using `[gotwplr]` with options support.

= Please Vote On This Plugin =
Your votes count! Thank you.

== Installation ==

1. Download and unzip the latest release zip file.
1. Using WordPress plugin uploader, upload **GOT WP Login Register** plugin zip file to your WordPress site OR upload the entire plugin directory 'got-wp-login-register' to the '/wp-content/plugins/' directory.
1. Activate the plugin through the 'Plugins' menu in WordPress administration panel.
1. You will get an alert to install *Dilaz Panel* options framework plugin; Install and activate it.
1. Go to **GOT WP LR Panel** options page.
1. Add your Google **Client Id** and configure other settings.

== Frequently Asked Questions ==

= Do I need a Google account to use this plugin? =

Yes. You need to create a Google web application on [Google API Console](https://console.cloud.google.com/home "Google APIs & Services").

= Do I need to create a Google web application? =

Yes. Before you can integrate Google Sign-In or Google One-Tap into your website, you must have a Google API project. In the project, you create a client ID, which you need to call the sign-in or one-tap API.

= How do I create a Google API project? =

[Click here for detailed instructions on how to setup a Google API project](https://rodgath.github.io/GOT-WP-Login-Register/#setup-google-api).

== Screenshots ==

1. Google One-Tap prompt.
2. Google One-Tap prompt within a webpage.
3. Google SignIn button before the login form.
4. Google SignIn button at the top of the login form.
5. Google SignIn button at the bottom of the login form.
6. Options panel.

== Changelog ==

= 1.0 =
*Release Date - 10th July, 2021*
* Initial Release