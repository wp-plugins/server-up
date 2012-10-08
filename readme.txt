=== Server-Up for Wordpress ===
Contributors: Arnaud Grousset
Tags: badge, widget, widgets, plugin, plugins, sidebar, port checking, server cheking, server status, port status
Requires at least: 2.8
Tested up to: 3.3.2
Stable tag: 1.2

Allows to show the status of a list of server as a Widget and a Shortcode

== Description ==

Allows to show the status of a list of server as a Widget and a Shortcode. 
The plugin tempts to connect to a specific port on a server (defined by address, or hostname).
If the connection fails, the plugin considers that the server is offline. Otherwise, the server is online.

= Credits =

Base on the work of jonesy44, aviable here : http://www.hawkee.com/snippet/5404/

== Installation ==

1. Unzip `server-up` and upload the contained files to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

= Add the sidebar widget =

1. Install the `Server-Up` widget through the 'Design -> Widgets' menu in WordPress

= (Optional, for advanced users) Add `serverup` to a post or a page =

1. Type `[serverup]` into a post's or a page's body text.

= (Optional, for advanced users) Add `serverup` to a template =

1. Enter `<?php echo do_shortcode('[serverup]'); ?>` into a suitable template file.

== Frequently Asked Questions ==
Fail to install : I have notice a problem with the downloaded Zip-file in wordpress.org official site. I'm working on it. So, you can download the plugin at this location : http://www.eleyone.fr/wp-content/uploads/2012/06/server-up.zip

== Developer Notes ==
This is just an Beta, so dont cry if there are Problems! If you need help just write a mail to grousset.a@gmail.com, at least in english, in french, if possible.

In the future, i plan to add a automatic refresh on widget, with ajax.

== Changelog ==
= 1.2 =
* Adding visibility checkbox to the admin panel of server
* Fixing icon display in serveur listing in admin panel
* Fixing icon save when modify server

= 1.1 =
* Changing HTML code for widget render and shortcode render.
* Changing widget registering implementation to the WordPress v2.8 implementation.

= 1.0 =
* First inoffcial Release