<?php
/*
Plugin Name: icur-from-x
Description: Redirects to custom template when coming from configured hostnames
*/

define('ICUR_FROM_X_DEBUG', false); // Set to true to enable debug output

function icur_from_x_register_settings()
{
    add_option('icur_from_x_hostnames', '');
    add_option('icur_from_x_custom_html', '');
    register_setting('icur_from_x_options_group', 'icur_from_x_hostnames', 'sanitize_text_field');
    register_setting('icur_from_x_options_group', 'icur_from_x_custom_html', 'wp_kses_post');
}
add_action('admin_init', 'icur_from_x_register_settings');

function icur_from_x_register_options_page()
{
    add_options_page('ICUR From X', 'ICUR From X', 'manage_options', 'icur-from-x', 'icur_from_x_options_page');
}
add_action('admin_menu', 'icur_from_x_register_options_page');

function icur_from_x_options_page()
{
    ?>
    <div style="background-image: url('<?php echo plugins_url('icur-from-x/Sargent_MadameX.jpeg') ?>'); background-size: 20%; background-position: top right; background-repeat: no-repeat; background-attachment: fix;">

    <h2>ICUR From X Settings</h2>
    <form method="post" action="options.php">
        <?php
        settings_fields('icur_from_x_options_group');
        do_settings_sections('icur_from_x_options_group');
        wp_nonce_field('icur_from_x_save_settings', 'icur_from_x_nonce');
        ?>
        <label for="icur_from_x_hostnames">Hostnames (comma-separated):</label>
        <input type="text" id="icur_from_x_hostnames" name="icur_from_x_hostnames" value="<?php echo esc_attr(get_option('icur_from_x_hostnames')); ?>" />
        <br><br>
        <label for="icur_from_x_custom_html">Custom HTML:</label><br>
        <textarea id="icur_from_x_custom_html" name="icur_from_x_custom_html" rows="10" cols="50"><?php echo esc_textarea(get_option('icur_from_x_custom_html')); ?></textarea>
        <?php submit_button(); ?>
    </form>
    </div>
    <?php
}

function icur_from_x_template_redirect()
{
    if (isset($_SERVER['HTTP_REFERER'])) {
        $hostnames_option = get_option('icur_from_x_hostnames');
        $hostnames = array_map('trim', explode(',', $hostnames_option));
        foreach ($hostnames as $hostname) {
            if (strpos($_SERVER['HTTP_REFERER'], $hostname) !== false) {
                $template = plugin_dir_path(__FILE__) . 'icur-from-x-template.php';
                if (file_exists(get_template_directory() . '/icur-from-x-template.php')) {
                    $template = get_template_directory() . '/icur-from-x-template.php';
                }
                include $template;
                exit;
            }
        }
    }
}
add_action('template_redirect', 'icur_from_x_template_redirect');

function icur_from_x_debug_footer()
{
    if (ICUR_FROM_X_DEBUG && isset($_SERVER['HTTP_REFERER'])) {
        echo '<div style="position: fixed; bottom: 0; left: 0; background: #fff; color: #000; padding: 10px; border: 1px solid #000;">';
        echo 'Referrer: ' . esc_html($_SERVER['HTTP_REFERER']);
        echo '</div>';
    }
}
add_action('wp_footer', 'icur_from_x_debug_footer');
