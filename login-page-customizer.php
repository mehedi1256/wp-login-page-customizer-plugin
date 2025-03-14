<?php

/**
 * Plugin Name: WP Login Page Customizer
 * Description: This plugin will customize logo, text color and background color.
 * Author: Mehedi Hassan Shovo
 * Version: 1.0
 * Author URI: http://example.com  
 * Plugin URI: http://example.com
 * Text Domain: login-page-customizer
 */

if (!defined("ABSPATH")) {
    exit;
}

add_action("admin_menu", "wlc_add_submenu");

function wlc_add_submenu()
{
    add_submenu_page("options-general.php", "WP Login Page Customizer", "WP Login Page Customizer", "manage_options", "wp-login-page-customizer", "wlc_handle_login_settings_page");
}

// create login page customizer layout
function wlc_handle_login_settings_page()
{
    ob_start();

    include_once plugin_dir_path(__FILE__) . "template/login_settings_layout.php";

    $content = ob_get_contents();

    ob_end_clean();

    echo $content;
}

// Register settings for login page

add_action("admin_init", "wlc_login_page_settings_field_registration");

function wlc_login_page_settings_field_registration()
{
    register_setting("wlc_login_page_settings_field_group", "wlc_login_page_text_color");
    register_setting("wlc_login_page_settings_field_group", "wlc_login_page_background_color");
    register_setting("wlc_login_page_settings_field_group", "wlc_login_page_logo");

    // create a section here and add settings field
    add_settings_section("wlc_login_page_section_id", "Login Page Customizer Settings", null, "wp-login-page-customizer");

    // Text Color
    add_settings_field("wlc_login_page_text_color", "Page Text Color", "wlc_login_page_text_color_input", "wp-login-page-customizer", "wlc_login_page_section_id");

    // Background Color
    add_settings_field("wlc_login_page_background_color", "Page Background Color", "wlc_login_page_background_color_input", "wp-login-page-customizer", "wlc_login_page_section_id");

    // Login page logo
    add_settings_field("wlc_login_page_logo", "Login Page Logo", "wlc_login_page_logo_input", "wp-login-page-customizer", "wlc_login_page_section_id");
}

// Text color settings
function wlc_login_page_text_color_input()
{
    $text_color = get_option("wlc_login_page_text_color", "");
?>
    <input type="text" name="wlc_login_page_text_color" placeholder="Text Color" value="<?= $text_color ?>" />
<?php
}

// Background color settings
function wlc_login_page_background_color_input()
{
    $background_color = get_option("wlc_login_page_background_color", "");
?>
    <input type="text" name="wlc_login_page_background_color" placeholder="Background Color" value="<?= $background_color ?>" />
<?php
}

// Logo color settings
function wlc_login_page_logo_input()
{
    $logo = get_option("wlc_login_page_logo", "");
?>
    <input type="text" name="wlc_login_page_logo" placeholder="Enter Logo URL" value="<?= $logo ?>" />
<?php
}

// Render Custom Login Page Settings to Login Screen
add_action("login_enqueue_scripts", "wlc_login_page_customizer_settings");

function wlc_login_page_customizer_settings() {
    $text_color = get_option("wlc_login_page_text_color", "");
    $background_color = get_option("wlc_login_page_background_color", "");
    $logo = get_option("wlc_login_page_logo", "");

    ?>
    <style>
        <?php
        if(!empty($text_color)) {
            ?>
            div#login,
            a.wp-login-lost-password, 
            p#backtoblog a {
                color: <?php echo $text_color ?> !important;
            }
            <?php
        }
        ?>
    </style>
    <?php
}