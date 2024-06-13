<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function cdp_add_admin_menu() {
    add_menu_page(
        __( 'Carrossel de Produto', 'carrossel-de-produto' ),
        __( 'Carrossel de Produto', 'carrossel-de-produto' ),
        'manage_options',
        'carrossel-de-produto',
        'cdp_admin_page',
        'dashicons-images-alt2'
    );
    add_submenu_page(
        'carrossel-de-produto',
        __( 'Todos os Carrosséis', 'carrossel-de-produto' ),
        __( 'Todos os Carrosséis', 'carrossel-de-produto' ),
        'manage_options',
        'edit.php?post_type=cdp_carousel'
    );
    add_submenu_page(
        'carrossel-de-produto',
        __( 'Adicionar Novo Carrossel', 'carrossel-de-produto' ),
        __( 'Adicionar Novo', 'carrossel-de-produto' ),
        'manage_options',
        'post-new.php?post_type=cdp_carousel'
    );
}

add_action( 'admin_menu', 'cdp_add_admin_menu' );

function cdp_admin_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Configurações do Carrossel de Produto', 'carrossel-de-produto' ); ?></h1>
        <p><?php esc_html_e( 'Utilize o menu ao lado para adicionar e gerenciar seus carrosséis.', 'carrossel-de-produto' ); ?></p>
    </div>
    <?php
}

function cdp_add_meta_boxes() {
    add_meta_box(
        'cdp_carousel_settings',
        __( 'Configurações do Carrossel', 'carrossel-de-produto' ),
        'cdp_carousel_settings_callback',
        'cdp_carousel'
    );

    add_meta_box(
        'cdp_carousel_style',
        __( 'Estilo do Carrossel', 'carrossel-de-produto' ),
        'cdp_carousel_style_callback',
        'cdp_carousel'
    );

    add_meta_box(
        'cdp_carousel_shortcode',
        __( 'Shortcode do Carrossel', 'carrossel-de-produto' ),
        'cdp_carousel_shortcode_callback',
        'cdp_carousel',
        'side'
    );
}

add_action( 'add_meta_boxes', 'cdp_add_meta_boxes' );

function cdp_carousel_settings_callback( $post ) {
    wp_nonce_field( 'cdp_save_carousel_settings', 'cdp_carousel_settings_nonce' );

    $category_id = get_post_meta( $post->ID, 'cdp_product_category', true );
    $product_quantity = get_post_meta( $post->ID, 'cdp_product_quantity', true );
    $disable_button = get_post_meta( $post->ID, 'cdp_disable_button', true );
    $autoplay = get_post_meta( $post->ID, 'cdp_autoplay', true );
    $autoplay_speed = get_post_meta( $post->ID, 'cdp_autoplay_speed', true );
    $cards_per_row_desktop = get_post_meta( $post->ID, 'cdp_cards_per_row_desktop', true );
    $cards_per_row_tablet = get_post_meta( $post->ID, 'cdp_cards_per_row_tablet', true );
    $cards_per_row_mobile = get_post_meta( $post->ID, 'cdp_cards_per_row_mobile', true );

    $categories = get_terms( array(
        'taxonomy' => 'product_cat',
        'hide_empty' => false,
    ) );

    ?>
    <table class="form-table">
        <tr valign="top">
            <th scope="row"><?php esc_html_e( 'Categoria de Produtos', 'carrossel-de-produto' ); ?></th>
            <td>
                <select name="cdp_product_category">
                    <?php foreach ( $categories as $category ) : ?>
                        <option value="<?php echo esc_attr( $category->term_id ); ?>" <?php selected( $category_id, $category->term_id ); ?>><?php echo esc_html( $category->name ); ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php esc_html_e( 'Quantidade de Produtos', 'carrossel-de-produto' ); ?></th>
            <td>
                <input type="number" name="cdp_product_quantity" value="<?php echo esc_attr( $product_quantity ); ?>" min="1" max="20" />
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php esc_html_e( 'Desativar Botão de Compra', 'carrossel-de-produto' ); ?></th>
            <td>
                <input type="checkbox" name="cdp_disable_button" value="1" <?php checked( $disable_button, 1 ); ?> />
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php esc_html_e( 'Auto Play', 'carrossel-de-produto' ); ?></th>
            <td>
                <input type="checkbox" name="cdp_autoplay" value="1" <?php checked( $autoplay, 1 ); ?> />
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php esc_html_e( 'Velocidade do Auto Play (ms)', 'carrossel-de-produto' ); ?></th>
            <td>
                <input type="number" name="cdp_autoplay_speed" value="<?php echo esc_attr( $autoplay_speed ); ?>" min="100" />
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php esc_html_e( 'Cards por Linha (Desktop)', 'carrossel-de-produto' ); ?></th>
            <td>
                <input type="number" name="cdp_cards_per_row_desktop" value="<?php echo esc_attr( $cards_per_row_desktop ); ?>" min="1" max="6" />
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php esc_html_e( 'Cards por Linha (Tablet)', 'carrossel-de-produto' ); ?></th>
            <td>
                <input type="number" name="cdp_cards_per_row_tablet" value="<?php echo esc_attr( $cards_per_row_tablet ); ?>" min="1" max="6" />
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php esc_html_e( 'Cards por Linha (Mobile)', 'carrossel-de-produto' ); ?></th>
            <td>
                <input type="number" name="cdp_cards_per_row_mobile" value="<?php echo esc_attr( $cards_per_row_mobile ); ?>" min="1" max="6" />
            </td>
        </tr>
    </table>
    <?php
}

function cdp_carousel_style_callback( $post ) {
    wp_nonce_field( 'cdp_save_carousel_style', 'cdp_carousel_style_nonce' );

    $image_size = get_post_meta( $post->ID, 'cdp_image_size', true );
    $title_size = get_post_meta( $post->ID, 'cdp_title_size', true );
    $price_size = get_post_meta( $post->ID, 'cdp_price_size', true );
    $card_margin = get_post_meta( $post->ID, 'cdp_card_margin', true );

    ?>
    <table class="form-table">
        <tr valign="top">
            <th scope="row"><?php esc_html_e( 'Tamanho da Imagem (px)', 'carrossel-de-produto' ); ?></th>
            <td>
                <input type="number" name="cdp_image_size" value="<?php echo esc_attr( $image_size ); ?>" min="50" />
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php esc_html_e( 'Tamanho do Título (px)', 'carrossel-de-produto' ); ?></th>
            <td>
                <input type="number" name="cdp_title_size" value="<?php echo esc_attr( $title_size ); ?>" min="10" />
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php esc_html_e( 'Tamanho do Preço (px)', 'carrossel-de-produto' ); ?></th>
            <td>
                <input type="number" name="cdp_price_size" value="<?php echo esc_attr( $price_size ); ?>" min="10" />
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php esc_html_e( 'Margem entre Cards (px)', 'carrossel-de-produto' ); ?></th>
            <td>
                <input type="number" name="cdp_card_margin" value="<?php echo esc_attr( $card_margin ); ?>" min="0" />
            </td>
        </tr>
    </table>
    <?php
}

function cdp_carousel_shortcode_callback( $post ) {
    ?>
    <p><?php esc_html_e( 'Use o shortcode abaixo para adicionar este carrossel em suas páginas ou posts:', 'carrossel-de-produto' ); ?></p>
    <p><code>[cdp_carousel id="<?php echo esc_attr( $post->ID ); ?>"]</code></p>
    <?php
}

function cdp_save_carousel_settings( $post_id ) {
    if ( ! isset( $_POST['cdp_carousel_settings_nonce'] ) ) {
        return $post_id;
    }
    $nonce = $_POST['cdp_carousel_settings_nonce'];
    if ( ! wp_verify_nonce( $nonce, 'cdp_save_carousel_settings' ) ) {
        return $post_id;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $post_id;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return $post_id;
    }

    if ( isset( $_POST['cdp_product_category'] ) ) {
        update_post_meta( $post_id, 'cdp_product_category', sanitize_text_field( $_POST['cdp_product_category'] ) );
    }

    if ( isset( $_POST['cdp_product_quantity'] ) ) {
        update_post_meta( $post_id, 'cdp_product_quantity', intval( $_POST['cdp_product_quantity'] ) );
    }

    if ( isset( $_POST['cdp_disable_button'] ) ) {
        update_post_meta( $post_id, 'cdp_disable_button', sanitize_text_field( $_POST['cdp_disable_button'] ) );
    }

    if ( isset( $_POST['cdp_autoplay'] ) ) {
        update_post_meta( $post_id, 'cdp_autoplay', sanitize_text_field( $_POST['cdp_autoplay'] ) );
    } else {
        update_post_meta( $post_id, 'cdp_autoplay', 0 );
    }

    if ( isset( $_POST['cdp_autoplay_speed'] ) ) {
        update_post_meta( $post_id, 'cdp_autoplay_speed', intval( $_POST['cdp_autoplay_speed'] ) );
    }

    if ( isset( $_POST['cdp_cards_per_row_desktop'] ) ) {
        update_post_meta( $post_id, 'cdp_cards_per_row_desktop', intval( $_POST['cdp_cards_per_row_desktop'] ) );
    }

    if ( isset( $_POST['cdp_cards_per_row_tablet'] ) ) {
        update_post_meta( $post_id, 'cdp_cards_per_row_tablet', intval( $_POST['cdp_cards_per_row_tablet'] ) );
    }

    if ( isset( $_POST['cdp_cards_per_row_mobile'] ) ) {
        update_post_meta( $post_id, 'cdp_cards_per_row_mobile', intval( $_POST['cdp_cards_per_row_mobile'] ) );
    }
}

function cdp_save_carousel_style( $post_id ) {
    if ( ! isset( $_POST['cdp_carousel_style_nonce'] ) ) {
        return $post_id;
    }
    $nonce = $_POST['cdp_carousel_style_nonce'];
    if ( ! wp_verify_nonce( $nonce, 'cdp_save_carousel_style' ) ) {
        return $post_id;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $post_id;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return $post_id;
    }

    if ( isset( $_POST['cdp_image_size'] ) ) {
        update_post_meta( $post_id, 'cdp_image_size', intval( $_POST['cdp_image_size'] ) );
    }

    if ( isset( $_POST['cdp_title_size'] ) ) {
        update_post_meta( $post_id, 'cdp_title_size', intval( $_POST['cdp_title_size'] ) );
    }

    if ( isset( $_POST['cdp_price_size'] ) ) {
        update_post_meta( $post_id, 'cdp_price_size', intval( $_POST['cdp_price_size'] ) );
    }

    if ( isset( $_POST['cdp_card_margin'] ) ) {
        update_post_meta( $post_id, 'cdp_card_margin', intval( $_POST['cdp_card_margin'] ) );
    }
}

add_action( 'save_post', 'cdp_save_carousel_settings' );
add_action( 'save_post', 'cdp_save_carousel_style' );
