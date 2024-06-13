<?php
/*
Plugin Name: Carrossel de Produto
Description: Plugin para criar carrossel de produtos com nome, valor, quantidade, botão de compra e imagem.
Version: 1.1
Author: Padrão Bots
License: GPLv2 or later
Text Domain: carrossel-de-produto
Domain Path: /languages
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define plugin path.
define( 'CDP_PATH', plugin_dir_path( __FILE__ ) );

// Carregar a tradução.
function cdp_load_textdomain() {
    load_plugin_textdomain( 'carrossel-de-produto', false, basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'init', 'cdp_load_textdomain' );

// Load admin menu.
require_once CDP_PATH . 'admin/admin-menu.php';

// Load custom post type for carousels.
require_once CDP_PATH . 'includes/post-type.php';

// Load shortcode.
require_once CDP_PATH . 'includes/shortcode.php';

// Load assets.
function cdp_enqueue_assets() {
    wp_enqueue_style( 'cdp-slick-style', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css' );
    wp_enqueue_style( 'cdp-slick-theme', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css' );
    wp_enqueue_style( 'cdp-style', plugins_url( 'assets/css/style.css', __FILE__ ) );
    wp_enqueue_script( 'cdp-slick-script', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js', array('jquery'), null, true );
    wp_enqueue_script( 'cdp-script', plugins_url( 'assets/js/script.js', __FILE__ ), array('jquery', 'cdp-slick-script'), null, true );
}
add_action( 'wp_enqueue_scripts', 'cdp_enqueue_assets' );
