<?php
/**
 * Template Name: Filtro
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
                    <label for="search">Partner name:</label>
                    <input type="text" name="s" id="search" />
                </div>
                <div class="item-filter">   
                    <label for="specialty">Speciality:</label>
                    <select name="specialty" id="specialty">
                        <option value=""></option>
                        <?php
                            $specialties = get_terms(array(
                                'taxonomy'      => 'specialty',
                                'hide_empty'    => true
                            ));
                            if (!empty( $specialties )){
                                foreach ($specialties as $specialty) {
                                    echo "<option value='{$specialty->name}'> {$specialty->name} </option>";
    
                                }
                            }
                        ?>
                        
                    </select>
                </div>
                <div class="item-filter">   
                    <label for="country">Country:</label>
                    <select name="country" id="country">
                        <option value=""></option>
                        <?php
                            $countries = get_terms(array(
                                'taxonomy'      => 'country',
                                'hide_empty'    => true
                            ));
                            if (!empty( $countries )){
                                foreach ($countries as $country) {
                                    echo "<option value='{$country->name}'> {$country->name} </option>";
    
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <input type="submit" value="Search" />
                </div>
            </form>
        </div>
    </div>
</section>
<section class="cards-partners">
    <div class="container">
     
    <?php
    if (isset($_GET['s'])) {
        ?>
        <div id="custom-search-results" class="custom-search-results"></div>
        <?php
    } else {
        $args = array(
            'post_type' => 'partners',
            'post_status' => 'publish',
            'posts_per_page' => 100, 
        );
    
        $query = new WP_Query($args);
        ?>
        <div id="custom-search-results" class="custom-search-results">
            <?php
            if ($query->have_posts()) {

                while ($query->have_posts()) :
                    $query->the_post();
                    ?>   
    
                    <div class="result">
                        
                        <a href="<?php echo get_permalink() ?>">
                            <div class="img" style="background-image: url( <?php echo get_the_post_thumbnail_url() ?>);">
                            </div>
                        </a>
                        
                        <h2>
                            <a href="<?php echo get_permalink()?>" class="cta"><?php the_title(); ?></a>
                        </h2>
                        <p class="elipsis excerpt"><?php echo get_the_excerpt(); ?></p>
                        <p>
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
                        </p>
                        <span class="separator"></span>
                        <p class="country">
                            <ul>
                            <?php
                                $taxonomies = get_object_taxonomies('partners');
                                
                                foreach ($taxonomies as $taxonomy) {
                                    $terms = wp_get_post_terms(get_the_ID(), $taxonomy);
    
                                    if (!empty($terms)) {
                                        foreach ($terms as $term) {
                                            if ($term->taxonomy == 'country') {
                                                echo '<li>' . esc_html($term->name) . '</li>';
                                            }
                                        }
                                    }
                                }
                            ?>
                            </ul>
                        </p>
                    </div>
                    
                    <?php
                endwhile;
                wp_reset_postdata();
            } else {
                echo 'No hay partners disponibles.';
            }
    }
        ?>
    </div>
       
    </div>
</section>

<script>
    jQuery(document).ready(function ($) {
        $('#custom-search').submit(function () {
            var searchQuery = $('#search').val(); 
            var specialty = $('#specialty').val(); 
            var country = $('#country').val(); 

            // Verifica si el campo de búsqueda está vacío
            if (searchQuery.trim() === '' && specialty.trim() === '' &&  country.trim() === '' ) {
                alert('Please, enter some data in the search filters.');
                return false; // Detén el envío del formulario
            }
            var data = $(this).serialize();
            $.ajax({
                type: 'GET',
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                data: data + '&action=custom_search',
                success: function (response) {
                    var result = JSON.parse(response);
                    var countriesList = '';
                    if (result[0] === 'No Results'){
                        alert('No results available');
                    } else {
                        $('#custom-search-results').html('');
                        $.each(result, function(i, el) {
                            if (el.specialty === null) {
                                el.specialty = '';
                            }

                            if (el.country === null) {
                                el.country = '';
                            }

                            if (Array.isArray(el.country) && el.country.length > 0) {
                                countriesList = '<ul>'; 
                                el.country.forEach(function(country) {
                                    countriesList += '<li>' + country + '</li>';
                                });
                                countriesList += '</ul>'; 
                            }
                            
                            $('#custom-search-results').append('<div class="result"><a href="' +  el.link + '"><div class="img" style="background-image: url('+ el.thumbnail +' );"></div></a><h2><a href="' + el.link + '" class="cta" >' + el.title + '</a></h2><p class="elipsis excerpt">' + el.content + '</p> <p>' + el.specialty + ' </p><span class="separator"></span><p class="country">' + countriesList + '</p></div>');
                            
                            //    $('#custom-search-results').append('<div class="result"><a href="' +  el.link + '"><div class="img" style="background-image: url('+ el.thumbnail +' );"></div></a><h2><a href="' + el.link + '" class="cta" >' + el.title + '</a></h2><p class="elipsis excerpt">' + el.content + '</p> <p>' + el.specialty + ' </p><span class="separator"></span><p class="country">' + el.country + '</p></div>');
                        });
                    }
                }
            });
            return false;
        });
    });
</script>
