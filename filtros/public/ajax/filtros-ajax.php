<?php
function custom_search_process_results_ajax() {
    if (isset($_GET['s'])) {
        $search_query = sanitize_text_field($_GET['s']);
        $specialty = isset($_GET['specialty']) ? sanitize_text_field($_GET['specialty']) : '';
        $country = isset($_GET['country']) ? sanitize_text_field($_GET['country']) : '';
        if ( $_GET['country'] !== '' || $_GET['specialty'] !== '') {
            $args = array(
                'post_type' => 'partners', 
                's' => $search_query,   
                'posts_per_page' => -1,
                'tax_query' => array(
                    'relation' => 'OR',
                    array(
                        'taxonomy' => 'specialty',
                        'field' => 'slug',
                        'terms' => $specialty,
                    ),
                    array(
                        'taxonomy' => 'country',
                        'field' => 'slug',
                        'terms' => $country,
                    ),
                ),
            );
        } else {
            $args = array(
                'post_type' => 'partners', 
                's' => $search_query,   
                'posts_per_page' => -1
            );
        }
        $query = new WP_Query($args);
        $results = array();
        $term_country = array();
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $taxonomies = get_object_taxonomies('partners');
                foreach ($taxonomies as $taxonomy) {
                    $terms = wp_get_post_terms(get_the_ID(), $taxonomy);

                    if (!empty($terms)) {
                        foreach ($terms as $term) {
                            if ($term->taxonomy == 'specialty') {
                                $term_specialty = $term->name;
                            }
                        }
                    }
                }
                foreach ($taxonomies as $taxonomy) {
                    $terms = wp_get_post_terms(get_the_ID(), $taxonomy);

                    if (!empty($terms)) {
                        foreach ($terms as $term) {
                            if ($term->taxonomy == 'country') {
                                $term_country [] = $term->name;
                            }
                        }
                    }
                }
                $results[] = array(
                    'title'     => get_the_title(),
                    'link'      =>  get_permalink(), 
                    'content'   => get_the_excerpt(),
                    'thumbnail' => get_the_post_thumbnail_url(),
                    'country'   => $term_country,
                    'specialty' => $term_specialty,
                );
            }
            wp_reset_postdata();
        } else {
            $results[] = 'No Results';
        }

        echo json_encode($results);

        die();
    }
}
add_action('wp_ajax_custom_search', 'custom_search_process_results_ajax');
add_action('wp_ajax_nopriv_custom_search', 'custom_search_process_results_ajax');   

?>