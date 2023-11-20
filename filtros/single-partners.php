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
                            <?php the_post_thumbnail('medium'); ?>
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
                                        echo esc_html($term->name);
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
                                        echo '<li>'. esc_html($term->name) .'</li>';
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
    </div>
    </section>