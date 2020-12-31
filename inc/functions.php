<?php
//Se registro el admin menu - como tambien su pagina custom
function wpdocs_register_my_custom_menu_page()
{
    add_menu_page(
        __('My Custom Querys', 'my_custom_query'),
        'My Custom Querys',
        'manage_options',
        'my_custom_query',
        'my_custom_menu_page',
        "dashicons-text-page",
        7
    );
}
add_action('admin_menu', 'wpdocs_register_my_custom_menu_page');
/**
 * Display a custom menu page
 */
function my_custom_menu_page()
{
    // esc_html_e("fasdf", 'my_custom_query');
    if (is_file(plugin_dir_path(__FILE__) . '../templates/admin-page.php')) {
        
        include_once plugin_dir_path(__FILE__) . '../templates/admin-page.php';
    }
}
