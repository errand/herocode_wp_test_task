<?php

/**
 * Register Custom meta fields here
 */

add_action( 'init', 'statskikhRegisterRustomMeta');

function statskikhRegisterRustomMeta(){

    register_meta(
        'post',
        'product_price', // meta key
        array(
            'type'           => 'number',
            'single'         => true,
            'show_in_rest'   => true,
        )
    );

}
