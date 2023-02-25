<?php

/**
 * Custom Post Types registration
 */

add_action( 'init', 'shatskikhRegisterPostTypes' );

function shatskikhRegisterPostTypes(){

    register_post_type( 'product', [
        'label'  => null,
        'labels' => [
            'name'               => __('Товары', 'shatskikh'),
            'singular_name'      => __('Товар', 'shatskikh'),
            'add_new'            => __('Добавить', 'shatskikh'),
            'add_new_item'       => __('Добавление товара', 'shatskikh'),
            'edit_item'          => __('Редактирование', 'shatskikh'),
            'new_item'           => __('Новый', 'shatskikh'),
            'view_item'          => __('Смотреть', 'shatskikh'),
            'search_items'       => __('Искать', 'shatskikh'),
            'not_found'          => __('Не найдено', 'shatskikh'),
            'not_found_in_trash' => __('Не найдено в корзине', 'shatskikh'),
            'parent_item_colon'  => '',
            'menu_name'          => __('Товары', 'shatskikh'),
        ],
        'description'         => '',
        'public'              => true,
        'menu_icon'           => 'dashicons-products',
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'show_in_rest'        => true,
        'supports'            => [ 'title', 'editor','thumbnail', 'revisions', 'custom-fields'], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
        'taxonomies'          => ['brands'],
        'has_archive'         => false,
        'query_var'           => true,
    ] );
    register_post_type( 'set', [
        'label'  => null,
        'labels' => [
            'name'               => __('Наборы', 'shatskikh'),
            'singular_name'      => __('Набор', 'shatskikh'),
            'add_new'            => __('Добавить', 'shatskikh'),
            'add_new_item'       => __('Добавление набора', 'shatskikh'),
            'edit_item'          => __('Редактирование', 'shatskikh'),
            'new_item'           => __('Новый', 'shatskikh'),
            'view_item'          => __('Смотреть', 'shatskikh'),
            'search_items'       => __('Искать', 'shatskikh'),
            'not_found'          => __('Не найдено', 'shatskikh'),
            'not_found_in_trash' => __('Не найдено в корзине', 'shatskikh'),
            'parent_item_colon'  => '',
            'menu_name'          => __('Наборы', 'shatskikh'),
        ],
        'description'         => '',
        'public'              => true,
        'menu_icon'           => 'dashicons-layout',
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'show_in_rest'        => true,
        'supports'            => [ 'title', 'editor','thumbnail', 'revisions', 'custom-fields' ], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
        'taxonomies'          => ['brands'],
        'has_archive'         => false,
        'query_var'           => true,
    ] );
}
