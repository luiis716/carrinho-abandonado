<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function cdp_register_post_type() {
    $labels = array(
        'name'               => _x( 'Carrosséis', 'post type general name', 'carrossel-de-produto' ),
        'singular_name'      => _x( 'Carrossel', 'post type singular name', 'carrossel-de-produto' ),
        'menu_name'          => _x( 'Carrosséis', 'admin menu', 'carrossel-de-produto' ),
        'name_admin_bar'     => _x( 'Carrossel', 'add new on admin bar', 'carrossel-de-produto' ),
        'add_new'            => _x( 'Adicionar Novo', 'carrossel', 'carrossel-de-produto' ),
        'add_new_item'       => __( 'Adicionar Novo Carrossel', 'carrossel-de-produto' ),
        'new_item'           => __( 'Novo Carrossel', 'carrossel-de-produto' ),
        'edit_item'          => __( 'Editar Carrossel', 'carrossel-de-produto' ),
        'view_item'          => __( 'Ver Carrossel', 'carrossel-de-produto' ),
        'all_items'          => __( 'Todos os Carrosséis', 'carrossel-de-produto' ),
        'search_items'       => __( 'Buscar Carrosséis', 'carrossel-de-produto' ),
        'parent_item_colon'  => __( 'Carrosséis Pai:', 'carrossel-de-produto' ),
        'not_found'          => __( 'Nenhum carrossel encontrado.', 'carrossel-de-produto' ),
        'not_found_in_trash' => __( 'Nenhum carrossel encontrado no lixo.', 'carrossel-de-produto' )
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'cdp_carousel' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor' )
    );

    register_post_type( 'cdp_carousel', $args );
}
add_action( 'init', 'cdp_register_post_type' );
