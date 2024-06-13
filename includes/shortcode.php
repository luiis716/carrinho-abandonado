<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'cdp_product_carousel_shortcode' ) ) {
    function cdp_product_carousel_shortcode( $atts ) {
        $atts = shortcode_atts( array(
            'id' => '',
        ), $atts, 'cdp_carousel' );

        $carousel_id = intval( $atts['id'] );

        if ( ! $carousel_id ) {
            return '';
        }

        $category_id = get_post_meta( $carousel_id, 'cdp_product_category', true );
        $product_quantity = get_post_meta( $carousel_id, 'cdp_product_quantity', true );
        $disable_button = get_post_meta( $carousel_id, 'cdp_disable_button', true );
        $autoplay = get_post_meta( $carousel_id, 'cdp_autoplay', true );
        $autoplay_speed = get_post_meta( $carousel_id, 'cdp_autoplay_speed', true );
        $cards_per_row_desktop = get_post_meta( $carousel_id, 'cdp_cards_per_row_desktop', true );
        $cards_per_row_tablet = get_post_meta( $carousel_id, 'cdp_cards_per_row_tablet', true );
        $cards_per_row_mobile = get_post_meta( $carousel_id, 'cdp_cards_per_row_mobile', true );
        $image_size = get_post_meta( $carousel_id, 'cdp_image_size', true );
        $title_size = get_post_meta( $carousel_id, 'cdp_title_size', true );
        $price_size = get_post_meta( $carousel_id, 'cdp_price_size', true );
        $card_margin = get_post_meta( $carousel_id, 'cdp_card_margin', true );

        $args = array(
            'post_type' => 'product',
            'posts_per_page' => $product_quantity,
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'term_id',
                    'terms' => $category_id,
                ),
            ),
        );

        $query = new WP_Query( $args );

        ob_start();
        if ( $query->have_posts() ) {
            $autoplay_attr = $autoplay ? 'true' : 'false';
            $autoplay_speed_attr = $autoplay_speed ? $autoplay_speed : 3000;
            $image_size_style = $image_size ? 'style="max-width:' . esc_attr( $image_size ) . 'px;"' : '';
            $title_size_style = $title_size ? 'style="font-size:' . esc_attr( $title_size ) . 'px;"' : '';
            $price_size_style = $price_size ? 'style="font-size:' . esc_attr( $price_size ) . 'px;"' : '';
            $card_margin_style = $card_margin ? 'style="margin:' . esc_attr( $card_margin ) . 'px;"' : '';

            echo '<div class="cdp-carousel-wrapper">';
            echo '<div class="cdp-carousel" data-autoplay="' . $autoplay_attr . '" data-autoplay-speed="' . esc_attr( $autoplay_speed_attr ) . '" data-cards-per-row-desktop="' . esc_attr( $cards_per_row_desktop ) . '" data-cards-per-row-tablet="' . esc_attr( $cards_per_row_tablet ) . '" data-cards-per-row-mobile="' . esc_attr( $cards_per_row_mobile ) . '">';
            while ( $query->have_posts() ) {
                $query->the_post();
                global $product;
                ?>
                <div class="cdp-product" <?php echo $card_margin_style; ?>>
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="cdp-product-image" <?php echo $image_size_style; ?>>
                            <?php the_post_thumbnail( 'full' ); ?>
                        </div>
                    <?php endif; ?>
                    <h3 <?php echo $title_size_style; ?>><?php the_title(); ?></h3>
                    <p <?php echo $price_size_style; ?>><?php echo $product->get_price_html(); ?></p>
                    <?php if ( ! $disable_button ) : ?>
                        <a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" class="button"><?php esc_html_e( 'Comprar', 'carrossel-de-produto' ); ?></a>
                    <?php endif; ?>
                </div>
                <?php
            }
            echo '</div>';
            echo '</div>';
        }
        wp_reset_postdata();

        return ob_get_clean();
    }

    add_shortcode( 'cdp_carousel', 'cdp_product_carousel_shortcode' );
}
