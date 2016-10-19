<?php 
/*
Plugin Name: WebTorrent
Description: WebTorrent is a streaming torrent client for the web browser. Visit http://webtorrent.io/
Version:     0.1
Author:      Rune Piselli
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: my-toolset
*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

function webtorrent_scripts() {
  wp_enqueue_script('webtorrent_js', plugin_dir_url(__FILE__) . 'js/webtorrent.min.js');
  wp_enqueue_script('moment_js', plugin_dir_url(__FILE__) . 'js/moment.min.js');
  wp_enqueue_style( 'webtorrent_css', plugin_dir_url(__FILE__) . 'css/style.css');
}
add_action( 'wp_enqueue_scripts', 'webtorrent_scripts' );	


add_action( 'admin_menu', 'webtorrent_menu' );

function webtorrent_menu() {
	add_options_page( 'WebTorrent Options', 'WebTorrent', 'manage_options', 'webtorrent', 'webtorrent_options' );
}

function webtorrent_options() {
    
    if (!current_user_can('manage_options'))
    {
      wp_die( __('You do not have sufficient permissions to access this page.') );
    }

    $hidden_field_name = 'mt_submit_hidden';
    
    if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
        
        check_admin_referer( 'webtorrent-plugin-settings');
        $torrent_link_enabled = filter_var($_POST['torrent_link_enabled'], FILTER_VALIDATE_BOOLEAN);
        $show_seed_leech_info = filter_var($_POST['show_seed_leech_info'], FILTER_VALIDATE_BOOLEAN);
        $show_download_info = filter_var($_POST['show_download_info'], FILTER_VALIDATE_BOOLEAN);
        $torrents_directory = sanitize_text_field($_POST['torrents_directory']);
    
        update_option( 'torrent_link_enabled', $torrent_link_enabled);
        update_option( 'show_seed_leech_info', $show_seed_leech_info);
        update_option( 'show_download_info', $show_download_info);
        update_option( 'torrents_directory', $torrents_directory);
    

?>
<div class="updated"><p><strong><?php _e('settings saved.', 'menu-test' ); ?></strong></p></div>
<?php

    }

$torrent_link_enabled = get_option('torrent_link_enabled', true);

$show_seed_leech_info = get_option('show_seed_leech_info', true);

$show_download_info = get_option('show_download_info', true);

$torrents_directory = get_option('torrents_directory');

if(empty($torrents_directory)){
	$torrents_directory = "torrents";
}




    // Now display the settings editing screen

    echo '<div class="wrap">';

    // header

    echo "<h2>" . __( 'Webtorrent Settings', 'menu-test' ) . "</h2>";

    // settings form
    
    ?>

<form name="form1" method="post" action="">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

<p><?php _e("Show torrent link:", 'menu-test' ); ?>
<input type="radio" id="torrent_link_enabled" name="torrent_link_enabled" <?php if($torrent_link_enabled == true) echo 'checked="checked"'; ?> value="true" />yes
<input type="radio" id="torrent_link_enabled" name="torrent_link_enabled" <?php if($torrent_link_enabled == false) echo 'checked="checked"'; ?> value="false" />no
</p>

<p><?php _e("Show seed leech info:", 'menu-test' ); ?>
<input type="radio" id="show_seed_leech_info" name="show_seed_leech_info" <?php if($show_seed_leech_info == true) echo 'checked="checked"'; ?> value="true" />yes
<input type="radio" id="show_seed_leech_info" name="show_seed_leech_info" <?php if($show_seed_leech_info == false) echo 'checked="checked"'; ?> value="false" />no
</p>
<p><?php _e("Show download info:", 'menu-test' ); ?>
<input type="radio" id="show_download_info" name="show_download_info" <?php if($show_download_info == true) echo 'checked="checked"'; ?> value="true" />yes
<input type="radio" id="show_download_info" name="show_download_info" <?php if($show_download_info == false) echo 'checked="checked"'; ?> value="false" />no
</p>
<p><?php _e("Torrents directory:", 'menu-test' ); ?>
<input type="text" id="torrents_directory" name="torrents_directory" value="<?php echo $torrents_directory; ?>"/>Torrents directory relative to the uploads directory
</p>
<p class="submit">
<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
</p>
<?php wp_nonce_field( 'webtorrent-plugin-settings' );?>
</form>
</div>
<?php
}

function webtorrent_shortcode($atts){
   $torrent_link_enabled = get_option('torrent_link_enabled');
   $show_seed_leech_info = get_option('show_seed_leech_info');
   $show_download_info = get_option('show_download_info');
   $torrents_directory = get_option('torrents_directory');

if(empty($torrent_link_enabled)){
	$torrent_link_enabled = "true";
}

$show_seed_leech_info = get_option('show_seed_leech_info');
if(empty($show_seed_leech_info)){
	$show_seed_leech_info = "true";
} 
 
$show_download_info = get_option('show_download_info');
if(empty($show_download_info)){
	$show_download_info = "true";
}

$torrents_directory = get_option('torrents_directory');
if(empty($torrents_directory)){
	$torrents_directory = "torrents";
}

     $webtorrent_atts = shortcode_atts( array(
        'torrent_link_enabled' => $torrent_link_enabled,
        'show_seed_leech_info' => $show_seed_leech_info,
        'show_download_info' => $show_download_info,
        'torrents_directory' => $torrents_directory,
        'url' => 'none',
        'file' => 'none',
    ), $atts );
  
  $torrentId = $webtorrent_atts['url'];
  
  if($webtorrent_atts['file'] <> 'none' && validate_file( $webtorrent_atts['file'])== false){
  	 $uploads = wp_upload_dir();
     $upload_url = $uploads['baseurl']; 
     $torrentId = $upload_url.'/'.$torrents_directory.'/'.$webtorrent_atts['file'];
  }
  
  
  $path=explode("?",$torrentId);
  $filename=basename($path[0]);
     
?>
   <div id="webtorrent">
      <div id="output">
        <div id="progressBar"></div>
        <!-- The video player will be added here -->
      </div>
      <!-- Statistics -->
      <div id="status">
<?php if($webtorrent_atts['show_seed_leech_info']==true) { ?>      
        <div>
          <span class="show-leech">Downloading </span>
          <span class="show-seed">Seeding </span>
<?php if($webtorrent_atts['torrent_link_enabled']==true) { ?>          
          <code>
            <!-- Informative link to the torrent file -->
            <a id="torrentLink" href="<?php echo esc_url( $torrentId )?>"><?php echo esc_attr($filename) ?></a>
          </code>
<?php }?>          
          <span class="show-leech"> from </span>
          <span class="show-seed"> to </span>
          <code id="numPeers">0 peers</code>.
        </div>
<?php }?>        
<?php if($webtorrent_atts['show_download_info']==true) { ?>          
        <div>
          <code id="downloaded"></code>
          of <code id="total"></code>
          — <span id="remaining"></span><br/>
          &#x2198;<code id="downloadSpeed">0 b/s</code>
          / &#x2197;<code id="uploadSpeed">0 b/s</code>
        </div>
<?php } ?>        
      </div>
    </div>
    
<script type="text/javascript">
var torrentId = '<?php echo esc_url( $torrentId )?>'

var client = new WebTorrent()

// HTML elements
var $body = document.body
var $progressBar = document.querySelector('#progressBar')
var $numPeers = document.querySelector('#numPeers')
var $downloaded = document.querySelector('#downloaded')
var $total = document.querySelector('#total')
var $remaining = document.querySelector('#remaining')
var $uploadSpeed = document.querySelector('#uploadSpeed')
var $downloadSpeed = document.querySelector('#downloadSpeed')

// Download the torrent
client.add(torrentId, function (torrent) {

  // Stream the file in the browser
  torrent.files[0].appendTo('#output')

  // Trigger statistics refresh
  torrent.on('done', onDone)
  setInterval(onProgress, 500)
  onProgress()

  // Statistics
  function onProgress () {
    // Peers
    $numPeers.innerHTML = torrent.numPeers + (torrent.numPeers === 1 ? ' peer' : ' peers')

    // Progress
    var percent = Math.round(torrent.progress * 100 * 100) / 100
    $progressBar.style.width = percent + '%'
    $downloaded.innerHTML = prettyBytes(torrent.downloaded)
    $total.innerHTML = prettyBytes(torrent.length)

    // Remaining time
    var remaining
    if (torrent.done) {
      remaining = 'Done.'
    } else {
      remaining = moment.duration(torrent.timeRemaining / 1000, 'seconds').humanize()
      remaining = remaining[0].toUpperCase() + remaining.substring(1) + ' remaining.'
    }
    $remaining.innerHTML = remaining

    // Speed rates
    $downloadSpeed.innerHTML = prettyBytes(torrent.downloadSpeed) + '/s'
    $uploadSpeed.innerHTML = prettyBytes(torrent.uploadSpeed) + '/s'
  }
  function onDone () {
    $body.className += ' is-seed'
    onProgress()
  }
})

// Human readable bytes util
function prettyBytes(num) {
  var exponent, unit, neg = num < 0, units = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB']
  if (neg) num = -num
  if (num < 1) return (neg ? '-' : '') + num + ' B'
  exponent = Math.min(Math.floor(Math.log(num) / Math.log(1000)), units.length - 1)
  num = Number((num / Math.pow(1000, exponent)).toFixed(2))
  unit = units[exponent]
  return (neg ? '-' : '') + num + ' ' + unit
}
</script>    

<?php
}
add_shortcode('webtorrent', 'webtorrent_shortcode');

?>