<?php function ccss_main_tab() {
	add_plugins_page(
		'Critical Css',
		'Critical Css',
		'manage_options',
		'ccss_plugin_options',
		'bap_plugin_menu'
	);
}
add_action('admin_menu', 'ccss_main_tab' );

function bap_plugin_menu() { ?>
	<div class="wrap">
		<div id="icon-plugins" class="icon32"></div>
		<h2><?php _e('Critical Css: Settings', 'ccss'); ?></h2>
		<?php settings_errors(); ?>

		<form method="post" action="options.php">
			<?php
			settings_fields('ccss_plugin_options');
			do_settings_sections('ccss_plugin_options');
			submit_button(); ?>
		</form>
	</div>
<?php }

// --------------------------------------------------------------------------------------------------------------------------------

function ccss_plugin_default_options() {
	$defaults = array(
        'ccss_themelocation_full_css' => null,
        'ccss_themelocation_critical_css' => null,
	);
	return apply_filters( 'ccss_plugin_default_options', $defaults );
}

// INIT -----------------------------------------------------------------------------------------------------------------------------

function ccss_plugin_initialize_options() {
	if(false == get_option('ccss_plugin_options')) {
		add_option('ccss_plugin_options', apply_filters('ccss_plugin_default_options', ccss_plugin_default_options()));
	}

    // Settings section -------------------------------------------------------------------------------------------------------------------------

    add_settings_section(
        'ccss_styles_location',
        __('', 'ccss'),
        'ccss_section_callback',
        'ccss_plugin_options'
    );

    // Settings section callback ---------------------------------------

    function ccss_section_callback() {
        echo '<p>' . __( 'Your full css-file could be your theme style.css', 'ccss' ) . '</p>';
    }

    // Setting fields ---------------------------------------

    add_settings_field(
        'ccss_themelocation_full_css',
        'Path to full CSS (relative from your theme):',
        'ccss_themelocation_full_css_callback',
        'ccss_plugin_options',
        'ccss_styles_location',
        array( 
            __( '<strong>Theme-folder/</strong> <em>enter/path-to/full.css</em>', 'ccss' ),
        )
    );

    add_settings_field(
        'ccss_themelocation_critical_css',
        'Path to critical CSS (relative from your theme):',
        'ccss_themelocation_critical_css_callback',
        'ccss_plugin_options',
        'ccss_styles_location',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __( '<strong>Theme-folder/</strong> <em>enter/path-to/critical.css</em>', 'ccss' ),
        )
    );

    // Setting fields callbacks ---------------------------------------

    function ccss_themelocation_full_css_callback($args) {
        $options = get_option('ccss_plugin_options');
        $html = '<input type="text" id="ccss_themelocation_full_css" name="ccss_plugin_options[ccss_themelocation_full_css]" value="' . esc_url_raw($options['ccss_themelocation_full_css']) . '" />';
        $html .= '<label for="ccss_themelocation_full_css">&nbsp;'  . $args[0] . '</label>';
        echo $html;
    }

    function ccss_themelocation_critical_css_callback($args) {
        $options = get_option('ccss_plugin_options');
        $html = '<input type="text" id="ccss_themelocation_critical_css" name="ccss_plugin_options[ccss_themelocation_critical_css]" value="' . esc_url_raw($options['ccss_themelocation_critical_css']) . '" />';
        $html .= '<label for="ccss_themelocation_critical_css">&nbsp;'  . $args[0] . '</label>';
        echo $html;
    }

    // Register and sanitize -------------------------------------------------------------------------------------------------------------------------

	register_setting(
		'ccss_plugin_options',
		'ccss_plugin_options',
		'ccss_validate_sanitize_input'
	);
}

add_action( 'admin_init', 'ccss_plugin_initialize_options' );



//-----------------------------------------------------------------------------------------------------------------------------------

function ccss_validate_sanitize_input($input) {
	$output = array();
	foreach($input as $key => $value){
		if(isset($input[$key])){
			$output[$key] = strip_tags(stripslashes($input[$key]));
		}
	}
	return apply_filters('ccss_validate_sanitize_input', $output, $input);
}

function ccss_get_option_text($fieldID){
    $options = get_option('ccss_plugin_options');
    return $value = strip_tags(stripslashes($options[$fieldID]));
}