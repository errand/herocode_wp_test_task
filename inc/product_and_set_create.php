<?php

/**
 * This file contain the logic of creating the Product which triggers creation of Set.
 */

add_action( 'wp_after_insert_post', 'shatskikhCreateSetAfterProductInserted', 10, 3 );

function shatskikhCreateSetAfterProductInserted($post_id, $post, $post_before) {

    $discount = 0.2;

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
        $products_in_set = getPostsInBrand('product', $brand_id);

        $priceInSet = 0;

        foreach ($products_in_set as $product) {
            $priceInSet += get_post_meta($product->ID, 'product_price')[0];
        }

        /**
         * Let's delete previous Set of the same Brand
         */
        $branded_set = getPostsInBrand('set', $brand_id);

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
                    'product_price' => ($priceInSet - $priceInSet * $discount),
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
 * Display the list of the Products in Set
 */

add_filter('the_content', 'shatskikhRewriteSetContent');

function shatskikhRewriteSetContent() {
    global $post;

    if( is_singular() ) {
        if( 'set' == $post->post_type ) {

            $product_brand = wp_get_post_terms($post->ID, 'brands');
            if($product_brand) {
                $products_in_set = getPostsInBrand('product', $product_brand[0]->term_id);

                $content = '<h2>В данный набор входит:</h2>';
                $content .= '<ul>';

                foreach ($products_in_set as $product) {
                    $content .= '<li>' . $product->post_title . '</li>';
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

        return;
    }
}

/**
 * Helper function to get Sets in Brand
 */

function getPostsInBrand(string $type, int $brand_id): array
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
