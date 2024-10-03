<?php

if ( !defined( 'ABSPATH' ) ) exit;

/*
 * Function that generates an entry in the Administration menu
 */
function customkiwichat_plugin_menu() {
    add_menu_page('Configuring Custom KiwiChat', //Page title 
        'Custom KiwiChat',                       //Menu title 
        'administrator',                         //Role with permissions 
        'customkiwichat_info',                   //Page id 
        'customkiwichat_settingspage',           //Playback function
        plugins_url('plugin_icon/img/custom-plugin_icon.png'), //Icon
        61                                      //Position
        );

    add_submenu_page('customkiwichat_info',
        'Configuracion',
        'Info',
        'administrator',                     //Role with permissions 
        'customkiwichat_info',               //Page id
        'customkiwichat_settingspage');      //Playback function 

    add_submenu_page('customkiwichat_info',
        'Configuracion',
        'Settings',
        'administrator',                      //Role with permissions
        'custom-kiwichat-settings',           //Page id
        'customkiwichat_settingspage_eu');    //Playback function 

}

add_action('admin_menu', 'customkiwichat_plugin_menu');

/*
 * Function that records values in the internal DB
 */
function customkiwichat_info() {
	
    register_setting('kiwichatcustom-reg',
                     'customkiwichat_nick');
    register_setting('kiwichatcustom-reg',
                     'customkiwichat_server');
    register_setting('kiwichatcustom-reg',
                     'customkiwichat_chan');
    register_setting('kiwichatcustom-reg',
                     'customkiwichat_style');
    register_setting('kiwichatcustom-reg',
                     'customkiwichat_height');
    register_setting('kiwichatcustom-reg',
                     'customkiwichat_width');				 				 
}

add_action('admin_init', 'customkiwichat_info');


/*
 * Function that plays the main configuration page
 */
function customkiwichat_settingspage() {
    // check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }
?>

    <div class="wrap">
        <h2>Custom KiwiChat WordPress Plugin</h2>
        <p>Custom KiwiChat is an online chat client, your IRC client based on kiwiirc</p>
        <div class="card pressthis">
            <h3>Instructions for use</h3>
            <p>Place shortcode in your pages or posts:</p>
			<h4>[customkiwichat]</h4>
            <p>You can specify channel for a specific page instead of using the default channel configured with:</p>
            <h4>[customkiwichat chan=#YourChannel]</h4>
            <br/>
        </div>
	        <div class="card pressthis">
        <p>For more documentation on usage and configuration <a href="https://custom.kiwichat.org" target="_blank" title="Documentatie">Click Here</a></p>
		<p>Current stable version of the plugin 1.0</p>
        <br/>
        </div>
    </div>
<?php
}


/*
 * Function that plays the main configuration page
 */
function customkiwichat_settingspage_eu() {
    // check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }

    //Error message 
    if (isset($_GET['settings-updated'])) {
        add_settings_error('custom_messages', 'custom_message_ok', ('Updated values'), 'updated');
    }
    if (isset($_GET['settings-error'])) {
        add_settings_error('custom_messages', 'custom_message_error', ('A save error occurred'), 'error');
    }

    settings_errors('rcr_messages');
?>

     <div class="wrap">
	 
        <h1>Configuring Custom KiwiChat</h1>
  
        <form method="POST" action="options.php">
            <?php
                settings_fields('kiwichatcustom-reg');
                do_settings_sections('kiwichatcustom-reg');
            ?>
<table width="100%" border="0">
   
<td><em><h4>Connected from http://example.com/</h4></em></td>
	   
		<tr>
    <td><strong><?php _e("Nickname Suggestion:" ); ?></strong></td>
    <td><input type="text" id="customkiwichat_nick" name="customkiwichat_nick" value="<?php echo get_option('customkiwichat_nick'); ?>" size="25"></td>
    <td><em>Default nickname for your chatroom's KiwiChat. (Default is KiwiChat_?) [? is replaced with 5 random numbers]</em></td>
  </tr>
  
    <tr>
    <td><strong><?php _e("Channel:" ); ?></strong></td>
    <td><input type="text" name="customkiwichat_chan"  value="<?php echo get_option('customkiwichat_chan'); ?>" size="25"></td>
    <td><em>The name of your chatroom. (Default is #freenode)</em></td>
  </tr>
						
  <tr>
    <td><strong><?php _e("Custom KiwiChat Theme:" ); ?></strong></td>
    <td><select name="customkiwichat_style"
	            id="customkiwichat_style">
			   <option value="radioactive" <?php selected(get_option('customkiwichat_style'), "radioactive"); ?>>Radioactive</option>
	           <option value="dark" <?php selected(get_option('customkiwichat_style'), "dark"); ?>>Dark</option>
               <option value="nightswatch" <?php selected(get_option('customkiwichat_style'), "nightswatch"); ?>>Nightswatch</option>
               <option value="osprey" <?php selected(get_option('customkiwichat_style'), "osprey"); ?>>Osprey</option>
               <option value="sky" <?php selected(get_option('customkiwichat_style'), "sky"); ?>>Sky</option>
			   <option value="coffee" <?php selected(get_option('customkiwichat_style'), "coffee"); ?>>Coffee</option>
        </select>
    <td><em>Color style of the chatroom. (Default)</em></td>
  </tr>
<tr>
    <td><strong><?php _e("Width:" ); ?></strong></td>
    <td><input type="text" 
	name="customkiwichat_width"
	id="customkiwichat_width"
	value="<?php echo get_option('customkiwichat_width'); ?>" size="8"></td>
    <td><em>Width of your chatroom. (Default is 100%)</em></td>
  </tr>
  
  <tr>
    <td><strong><?php _e("Height:" ); ?></strong></td>
    <td><input type="text"
	name="customkiwichat_height"
	id="customkiwichat_height"
    value="<?php echo get_option('customkiwichat_height'); ?>" size="8"></td>
    <td><em>Height of your chatroom. (Default is 500)</em></td>
  </tr>
<br/>	
</table>		
        <p style="font-weight: bold;">
		NOTE: Users' preferences will always have priority over this configuration. For example, if a user configures that a particular nickname is used and a particular channel is accessed, then that configuration will always have priority over that of that configuration, so it will enter the channel specified in the configuration.</p>
            <?php submit_button(); ?>
        </form>
    </div>


<?php
}
?>
