<?php
defined('ABSPATH') or die("Don't change anything here!");

function customkiwichat_page( $atts ) {
    $url = CUSTOMKIWICHAT_URLBASE."";
	
	 if (get_option('customkiwichat_server') != 'http://example.com/')
       
        $url = $url."".get_option('customkiwichat_server');
	
	if (get_option('customkiwichat_nick') != '')
        $url = $url."/?nick=".str_replace("?", rand(10000,99999), get_option('customkiwichat_nick'));
	
     if (get_option('customkiwichat_style') != '')
        $url = $url."&theme=".get_option('customkiwichat_style');
	
	
	  $channels = isset($atts['chan']) ? $atts['chan'] : '';
     if ($channels == '')
        $channels = get_option('customkiwichat_chan');
     if ($channels != '')
        $url = $url."".$channels;

     

?>
<center>
        <iframe
            marginwidth="0"
            marginheight="0"
            src="<?php echo $url; ?>"
<?php
    if (get_option('customkiwichat_width') != '')
        echo "width=\"".get_option('customkiwichat_width')."\"";
    if (get_option('customkiwichat_height') != '')
        echo "height=\"".get_option('customkiwichat_height')."\"";
?>
            scrolling="no"
            frameborder="0">
        </iframe>
	 </center>
<?php
}

function customkiwichat( $atts ) {
    ob_start();
    customkiwichat_page( $atts );

    return ob_get_clean();
}

add_shortcode( 'customkiwichat', 'customkiwichat' );
?>
