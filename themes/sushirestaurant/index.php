<?php

/**
 * This it the main template file
 * 
 * This is the most generic template file in a WordPress theme
 * and is required for a theme (the other being style.css).
 * used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 */

get_header(); ?>
    <section class="general-masthead">
        <h1><?php the_title(); ?></h1>
    </section>
    <section>
        <?php the_content(); ?>
    </section>

<?php get_footer(); ?>