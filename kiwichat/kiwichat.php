<?php		
/*
 * Plugin Name:       Custom KiwiChat
 * Plugin URI:        http://example.com/plugin-name-uri/
 * Description:       Custom KiwiChat is an online chat client, your IRC client based on kiwiirc Add your networks. Join your channels.
 * Author:            Your Name or Your Company
 * Version:           1.0
 * Author URI:        http://example.com/plugin-name-uri/
 * License:           GPLv3 or later
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       kiwichat
 */

define( 'CUSTOMKIWICHAT_VERSION', '1.0' );

define( 'CUSTOM_KIWICHAT', plugin_dir_path( __FILE__ ) );

define( 'CUSTOMKIWICHAT_URLBASE', 'http://example.com' );


if ( is_admin() ) {
    require_once( CUSTOM_KIWICHAT . 'admin/admin.php' );
}
require_once( CUSTOM_KIWICHAT . 'public/index.php' );


function customkiwichat_plugin_links( $actions, $plugin_file ) {
    static $plugin;

    if ( !isset($plugin) )
        $plugin = plugin_basename(__FILE__);

    if ( $plugin == $plugin_file ) {
        $settings = array('settings' => '<a href="admin.php?page=custom-kiwichat-settings">Configurare</a>');
        $site_link = array('support' => '<a href="https://custom.kiwichat.org/help" target="_blank">Support</a>');
        $actions = array_merge($site_link, $actions);
        $actions = array_merge($settings, $actions);
    }
    return $actions;
}

add_filter( 'plugin_action_links', 'customkiwichat_plugin_links', 10, 5 );

/* Am setat valorile implicite */
function customkiwichat_set_defaults()
{
    $config = array(
	'customkiwichat_server'    => 'http://example.com',
        'customkiwichat_nick'      => 'KiwiChat_?',
        'customkiwichat_style'     => 'Default',
        'customkiwichat_chan'      => '#freenode',
        'customkiwichat_height'    => '500',
        'customkiwichat_width'     => '100%',
    );

    foreach ( $config as $key => $value )
    {
        if (!get_option($key)) {
            update_option($key, $value);
        }
    }
}

register_activation_hook( __FILE__, 'customkiwichat_set_defaults');

?>
