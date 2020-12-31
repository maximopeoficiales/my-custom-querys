<?php

/* 
     Plugin Name: My Custom Querys 
     Plugin URI: 
     Description: Ejecuta y muestra cualquier consulta de la BD de tu Wordpress
     Version: 1.0.0
     Author Uri: Maximo Junior Apaza Chirhuana
     Text Domain: My Custom Querys
*/

/* Previene que puedan ver este codigo  */

if (!defined('ABSPATH')) die();

function my_custom_query_init()
{

	$args = array(
		'label' => __('My Custom Querys', 'my_custom_querys'), /* nombre del boton */
		'description' => __('My Custom Querys', 'my_custom_querys'),
		'labels' => "",
		'supports' => array(''),
		'hierarchical' => true, /* false porque no tiene un padre quien le asigne un template*/
		'public' => true,
		'show_ui' => false,
		'show_in_menu' => true,
		'menu_position' => 7,    /* de 5 en la barra de navegacion */
		'menu_icon' => 'dashicons-text-page', /* dash icon de wordpress*/
		'show_in_admin_bar' => false,
		'show_in_nav_menus' => false,
		'can_export' => true, /* permitir la exportacion en un backup */
		'has_archive' => true,
		'exclude_from_search' => false, /* permitira la busqueda */
		'publicly_queryable' => true,
		'capability_type' => 'page',
	);
	register_post_type('my_custom_query', $args);
}
add_action('init', 'my_custom_query_init', 0);
require 'inc/functions.php';
require 'inc/endpoints.php';
