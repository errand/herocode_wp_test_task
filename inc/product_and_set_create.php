<?php

/**
 * This file contain the logic of creating the Product which triggers creation of Set.
 */

add_action( 'wp_after_insert_post', 'heroCodeCreateSetAfterProductInserted', 10, 3 );

function heroCodeCreateSetAfterProductInserted($post_id, $post, $post_before) {

    if( 'product' !== $post->post_type) {
        return;
    }

    if ($post->post_status !== 'publish') {
        return;
    }

    if (wp_get_post_terms($post_id, 'brands')) {

        /**
         * Get Brand data of the Product
         */
        $product_brands = wp_get_post_terms($post_id, 'brands');
        $brand_name = $product_brands[0]->name ?: null;
        $brand_id = $product_brands[0]->term_id ?: null;

        /**
         * Let's sum all prices of Products in Set
         */
        $priceInSet = heroCodeCalculateTotalPriceInBrand($brand_id);

        /**
         * Update previous Set of the same Brand if exist
         */
        $branded_set = heroCodeGetPostsInBrand('set', $brand_id);

        if($branded_set) {
            update_post_meta( $branded_set[0]->ID, 'product_price', $priceInSet);
        } else {
            $newSetOptions = array(
                'post_title' => 'Набор товаров: ' . $brand_name,
                'post_content' => '',
                'post_status' => 'publish',
                'post_type' => 'set',
                //'tax_input' => array( 'brands' => $brand_id ), // see bellow
                'meta_input'   => array(
                    'product_price' => $priceInSet,
                ),
            );

            $newSetId = wp_insert_post($newSetOptions);

            // ‘tax_input’ in the arguments only works on wp_insert_post if the function is being called by a user with “assign_terms” access
            if($brand_id) {
                wp_set_object_terms($newSetId, $brand_id, 'brands');
            }
        }
    }
}


/**
 * Update the Set Price when Product updates
 */

add_action('updated_post_meta', 'heroCodeUpdateSetPriceOnUpdate', 0, 4);

function heroCodeUpdateSetPriceOnUpdate($meta_id, $post_id, $meta_key, $meta_value) {
    if( 'product_price' == $meta_key ) {
        heroCodeUpdateSetPrice($post_id);
    }
}

/**
 * Update the Set Price when Product deleted
 */
add_action( 'trashed_post', 'heroCodeUpdateSetPriceOnDelete');

function heroCodeUpdateSetPriceOnDelete( $post_id ) {
    heroCodeUpdateSetPrice($post_id);
}

/**
 * Display the list of the Products in Set
 */

add_filter('the_content', 'heroCodeRewriteSetContent');

function heroCodeRewriteSetContent() {
    global $post;

    if( is_singular() ) {
        if( 'set' == $post->post_type ) {

            $product_brand = wp_get_post_terms($post->ID, 'brands');
            if($product_brand) {
                $products_in_set = heroCodeGetPostsInBrand('product', $product_brand[0]->term_id);

                if($products_in_set) {
                    $content = '<h2>В данный набор входит:</h2>';
                    $content .= '<ul>';

                    foreach ($products_in_set as $product) {
                        $content .= '<li><a href="'.get_permalink($product->ID).'">' . $product->post_title . '</a></li>';
                    }
                    $content .= '</ul>';
                    $content .= '<hr/>';
                    $content .= '<h5>Итоговая стоимость со скидкой</h5>';
                    $content .= '<h3>' . number_format(get_post_meta($post->ID, 'product_price')[0]) . '</h3>';
                } else {
                    $content = __("This set doesn't contain Products");
                }

                return $content;
            }

        }

        return;
    }
}

/**
 * Helper function to get Sets in Brand
 */

function heroCodeGetPostsInBrand(string $type, int $brand_id): array
{
    return get_posts([
        'post_type' => $type,
        'numberposts' => -1,
        'post_status'=>'publish',
        'tax_query' => [
            [
                'taxonomy' => 'brands',
                'field'    => 'term_id',
                'terms'    => $brand_id
            ]
        ],
    ]);
}

/**
 * Calculate total Price in the Set with discount
 */

function heroCodeCalculateTotalPriceInBrand(int $brand_id, mixed $discount = 0.2): mixed {
    $products_in_set = heroCodeGetPostsInBrand('product', $brand_id);

    $priceInSet = 0;

    foreach ($products_in_set as $product) {
        $priceInSet += get_post_meta($product->ID, 'product_price')[0];
    }

    return $priceInSet - $priceInSet * $discount;
}

/**
 * Update Branded Set Price
 */

function heroCodeUpdateSetPrice($post_id) {
    $product_brands = wp_get_post_terms($post_id, 'brands');
    $brand_id = $product_brands[0]->term_id ?: null;
    $branded_set = heroCodeGetPostsInBrand('set', $brand_id);
    $priceInSet = heroCodeCalculateTotalPriceInBrand($brand_id);

    if($branded_set) {
        update_post_meta( $branded_set[0]->ID, 'product_price', $priceInSet);
    }
}
