<?php
$theme_dir            = get_stylesheet_directory_uri();
$relpath_full_css     = ccss_get_option_text('ccss_themelocation_full_css');
$relpath_critical_css = ccss_get_option_text('ccss_themelocation_critical_css');

if ( empty($relpath_full_css) || is_null($relpath_full_css) || empty($relpath_critical_css) || is_null($relpath_critical_css)){
    return;
}

function ccss_enqueue_full_css() {
    if ( isset($_COOKIE['fullCSS']) && $_COOKIE['fullCSS'] === 'true' ) {

        if(ccss_get_option_boolean('ccss_statuslog')){ ?>
            <script>console.log('Cookie (fullCSS) is set and full css-file is in cache. Generate css-link in head.');</script>
        <?php }

        wp_enqueue_style( 'ccss_fullcss', get_stylesheet_directory_uri().'/'.ccss_get_option_text('ccss_themelocation_full_css'), null, null, 'all' );
    }
}
add_action('wp_enqueue_scripts', 'ccss_enqueue_full_css' );

function ccss_inline_critical_css() {
    if ( !isset($_COOKIE['fullCSS']) || $_COOKIE['fullCSS'] !== 'true' ) { ?>

        <style>
            <?php echo file_get_contents( get_stylesheet_directory_uri().'/'.ccss_get_option_text('ccss_themelocation_critical_css') ); ?>
        </style>

        <script id="js-loadcss">
            <?php if(ccss_get_option_boolean('ccss_statuslog')){ ?>
                console.log('Cookie (fullCSS) is not set and full css-file is not in cache. Inlining critical css in head, loading full css async with js.');
            <?php }

            echo file_get_contents( plugins_url('/ccss_vendor/ccss_scripts.js', __FILE__) ); ?>

            var stylesheet = loadCSS('<?php echo get_stylesheet_directory_uri().'/'.ccss_get_option_text('ccss_themelocation_full_css') ?>', document.getElementById("js-loadcss"));
            onloadCSS(stylesheet, function () {
                var expires = new Date(+new Date + (7 * 24 * 60 * 60 * 1000)).toUTCString();
                document.cookie = 'fullCSS=true; expires=' + expires;
            });
        </script>

        <?php
    }
}
add_action('wp_head', 'ccss_inline_critical_css', 30);

function ccss_noscript_fb() {
    if ( !isset($_COOKIE['fullCSS']) || $_COOKIE['fullCSS'] !== 'true' ) { ?>
        <noscript>
            <link href='<?php echo get_stylesheet_directory_uri().'/'.ccss_get_option_text('ccss_themelocation_full_css') ?>' rel='stylesheet' type='text/css'>
        </noscript>
        <?php
    }
}
add_action('wp_footer', 'ccss_noscript_fb', 30);
