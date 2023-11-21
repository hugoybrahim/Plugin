<?php
/**
 * Template Name: Single
 *
 */

?>
<link rel="stylesheet" type="text/css" href="<?php echo plugin_dir_url(__FILE__) . 'style.css'; ?>">

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partners</title>
</head>
<body>
<header>

</header>

<section class="partners">
    <div class="container">
        <h1> Partners WhatsApp Developers 2023 </h1>
        <p> Find the best developers in your city for Whatsapp development. </p>
   
      

        <div class="custom-search-form">
            <form id="custom-search" action="" method="GET">
                <div class="item-filter">   
                   
                </div>
                <div class="item-filter">   
                </div>
                <div class="item-filter">   
                    
                </div>
                <div class="form-group">
                  
                </div>
            </form>
        </div>
    </div>
</section>
<section class="single">
    <div class="container">
        <div class="back">
            <a href="<?php home_url() ?>/partners"> Back to the partners</a>
        </div>
        <?php
        // Inicia el loop de WordPress
        if (have_posts()) :
            while (have_posts()) : the_post();
                // Contenido del post individual
                ?>
                <article id="post-<?php the_ID(); ?>" >
                <span></span>
                <header class="entry-header">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="post-thumbnail">
                            <?php 
                                $website_data = get_post_meta(get_the_ID(), 'website', true);
                                echo '<a href="' . $website_data['url'] . '">';
                                the_post_thumbnail('medium'); 
                                echo '</a>';
                            ?>
                        </div>
                    <?php endif; ?>
                </header>
                    <div class="entry-content">
                    <h1><?php the_title(); ?></h1>
                        <?php the_content(); ?>
                    </div>
                    <div class="post-meta">
                    <?php
                        $taxonomies = get_object_taxonomies('partners');
                        
                        foreach ($taxonomies as $taxonomy) {
                            $terms = wp_get_post_terms(get_the_ID(), $taxonomy);

                            if (!empty($terms)) {
                                foreach ($terms as $term) {
                                    if ($term->taxonomy == 'specialty') {
                                        $url = esc_url(add_query_arg(array('specialty_id' => $term->term_id), home_url() . '/partners/'));

                                        echo '<a href="' . $url . '"><li>'. esc_html($term->name) .'</a></li>';
                                    }
                                }
                            }
                        }
                        ?>
                        <ul>
                        <?php
                        foreach ($taxonomies as $taxonomy) {
                            $terms = wp_get_post_terms(get_the_ID(), $taxonomy);
                            if (!empty($terms)) {
                                foreach ($terms as $term) {
                                    if ($term->taxonomy == 'country') {
                                        $url = esc_url(add_query_arg(array('country_id' => $term->term_id), home_url() . '/partners/'));

                                        echo '<a href="' . $url . '"><li>'. esc_html($term->name) .'</a></li>';
                                    }
                                }
                            }
                        }
                        ?>
                        </ul>

                    </div>
                </article>
                <?php
            endwhile;
        else :
            // Mensaje si no se encuentra el post
            echo 'No se encontró el Partner.';
        endif;
        ?>
        <br><br>
        <div class="relations">

            <?php
                $terms = get_the_terms(get_the_ID(), 'country');

                if ($terms && !is_wp_error($terms)) {
                    $current_country = $terms[0]->term_id;

                
                    $related_posts_args = array(
                        'post_type' => 'partners', 
                        'posts_per_page' => 3,  
                        'orderby' => 'rand',
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'country',
                                'field' => 'id',
                                'terms' => $current_country,
                            ),
                        ),
                        'post__not_in' => array(get_the_ID()),
                    );

                    $related_posts_query = new WP_Query($related_posts_args);

                    if ($related_posts_query->have_posts()) {
                        echo '<h2>Related Posts.</h2>';
                        echo '<div class="result-posts">';

                        while ($related_posts_query->have_posts()) {
                            $related_posts_query->the_post();
                            echo '<a href="' . get_permalink() . '"><div class="result-cards"><img src="' . get_the_post_thumbnail_url() . '" alt="img"> <h3>' . get_the_title() . '</h3></a></div>';
                        }

                        echo '</div>';
                    }

                    // Restaurar la información de post original
                    wp_reset_postdata();
                }
                ?>
        </div>
    </div>
    </section>

