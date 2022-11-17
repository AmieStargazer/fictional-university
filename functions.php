<?php

function university_files() {
    //ADDED js
    wp_enqueue_script('main-university-js' , get_theme_file_uri('/build/index.js'),array('jquery'),'1.0', true);
    // added stylesheet & fonts etc
    wp_enqueue_style('custom-google-fonts' , '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome' , '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('university_main_styles' , get_theme_file_uri('/build/style-index.css'));
    wp_enqueue_style('university_extra_styles' , get_theme_file_uri('/build/index.css'));
}

add_action('wp_enqueue_scripts' , 'university_files');

function university_features() {
    //adds menu option to WP Admin
    register_nav_menu('headerMenuLocation', 'Header Menu Location');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    // created featured image section n wp-admin - blog posts & custom posts with additional step in custom query in prof. ost type>university-post-types.php
    //register_nav_menu('footerLocationOne', 'Footer Location One');   //adds menu option to WP Admin
    //register_nav_menu('footerLocationTwo', 'Footer Location Two');   //adds menu option to WP Admin
}

add_action('after_setup_theme' , 'university_features');
function university_adjustment_queries($query) {
    if (!is_admin() AND  is_post_type_archive('program') AND is_main_query()) {
        $query->set ('orderby' , 'title');
        $query->set ('order' , 'ASC');
        $query->set ('posts_per_page' , -1);
    }

    if (!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()) {
        $today = date('Ymd');
        $query->set('meta_key' , 'event_date');
        $query->set('orderby' , 'meta_value_num');
        $query->set('order' , 'ASC');
        $query->set('meta_query' , [
                [
                'key' => 'event_date',
                  'compare' => '>=',
                  'value' => $today,
                  'type' => 'numeric'
            ]
    ]);
    }
}

add_action('pre_get_posts', 'university_adjustment_queries');
