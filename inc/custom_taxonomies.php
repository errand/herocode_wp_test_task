<?php

/**
 * Custom Taxonomies registration
 */

add_action( 'init', 'heroCodeRegisterCustomTaxonomies' );

function heroCodeRegisterCustomTaxonomies() {

    $labels = [
        "name" => __( "Бренды", 'heroCode' ),
        "singular_name" => __( "Бренд", 'heroCode' ),
    ];


    $args = [
        "label" => __( "Бренды", 'heroCode' ),
        "labels" => $labels,
        "public" => true,
        "publicly_queryable" => true,
        "hierarchical" => true,
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "query_var" => true,
        "rewrite" => [ 'slug' => 'brands', 'with_front' => true, ],
        "show_admin_column" => false,
        "show_tagcloud" => false,
        "show_in_quick_edit" => true,
        'show_in_rest'        => true,
        "sort" => false,
        "show_in_graphql" => false,
        'meta_box_cb' => false,
    ];
    register_taxonomy( "brands", [ "product", "set" ], $args );
}
