<?php
    /* Template Name: mailchimp-api-template */

    // Exit if accessed directly
    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }

get_header('mc'); ?>

<?php remove_filter ('the_content', 'wpautop'); ?>

<?php
// YOUR POST LOOP STARTS HERE
while ( have_posts() ) : the_post(); ?>

<?php
// Display the post content
// Note the "entry" class this is used for styling purposes so it's important to use it on any content element ?>

    <?php the_content(); ?>


<?php
// YOUR POST LOOP ENDS HERE
endwhile; ?>