=== Plugin Name ===
Contributors: runsh
Donate link: http://webtorrent.io/
Tags:0.1
Requires at least: 3.0.1
Tested up to: 4.5.4
Stable tag: 0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

This plugin adds WebTorrent support to Wordpress.

This technology permits to stream video using torrents reducing the server bandwith. For more infos visit http://webtorrent.io

To use the plugin install it and then insert the [webtorrent] shortcode in your posts and pages. The webtorrent shortcode supports the following attributes:

* file - if you want to specify only the filename of the torrent to use. The path will be the plugin baseurl + the torrents directory specified in the settings + the filename
* url - the url of the torrent
* torrent_link_enabled - enables the torrent link, the default is true
* show_seed_leech_info - shows the seed/leech infos, the default is true
* show_download_info - shows the download infos, the default is true
* torrents_directory - the torrents directory relative to the upload base directory used in conjunction with the file attribute to build the url, the default is torrents

Many of them can be set globally in the plugin settings page.

An example of a shortcode is:

[webtorrent url="https://webtorrent.io/torrents/sintel.torrent" show_seed_leech_info="false"]

== Installation ==

1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place the shortcode in your post, pages etc. [webtorrent url="https://webtorrent.io/torrents/sintel.torrent"] or [webtorrent file="sintel.torrent"]

== Frequently Asked Questions ==

= When you would suggest this technology? =

Mostly when you have a lot of users for the same media content, so that they can share the streaming effort.

= Can I play more videos on the same page? =

No it's currently not supported.

== Screenshots ==

1. /assets/screenshot-1.png
2. /assets/screenshot-2.png

== Changelog ==

= 0.1 =

* First version


