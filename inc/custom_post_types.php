<?php

/**
 * Custom Post Types registration
 */

add_action( 'init', 'heroCodeRegisterPostTypes' );

function heroCodeRegisterPostTypes(){

    register_post_type( 'product', [
        'label'  => null,
        'labels' => [
            'name'               => __('Товары', 'heroCode'),
            'singular_name'      => __('Товар', 'heroCode'),
            'add_new'            => __('Добавить', 'heroCode'),
            'add_new_item'       => __('Добавление товара', 'heroCode'),
            'edit_item'          => __('Редактирование', 'heroCode'),
            'new_item'           => __('Новый', 'heroCode'),
            'view_item'          => __('Смотреть', 'heroCode'),
            'search_items'       => __('Искать', 'heroCode'),
            'not_found'          => __('Не найдено', 'heroCode'),
            'not_found_in_trash' => __('Не найдено в корзине', 'heroCode'),
            'parent_item_colon'  => '',
            'menu_name'          => __('Товары', 'heroCode'),
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
            'name'               => __('Наборы', 'heroCode'),
            'singular_name'      => __('Набор', 'heroCode'),
            'add_new'            => __('Добавить', 'heroCode'),
            'add_new_item'       => __('Добавление набора', 'heroCode'),
            'edit_item'          => __('Редактирование', 'heroCode'),
            'new_item'           => __('Новый', 'heroCode'),
            'view_item'          => __('Смотреть', 'heroCode'),
            'search_items'       => __('Искать', 'heroCode'),
            'not_found'          => __('Не найдено', 'heroCode'),
            'not_found_in_trash' => __('Не найдено в корзине', 'heroCode'),
            'parent_item_colon'  => '',
            'menu_name'          => __('Наборы', 'heroCode'),
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
