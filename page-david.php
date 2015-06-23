<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); ?>


<div id="main-content" class="main-content">

<?php
	if ( is_front_page() && twentyfourteen_has_featured_posts() ) {
		// Include the featured content template.
		get_template_part( 'featured-content' );
	}
?>
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">


<?php
	
	//$events = tribe_get_events();

	$events = tribe_get_events( array(
	'start_date' => '2015-06-01 00:00',
	'end_date'   => '2015-09-30 23:59',

/*
	'meta_query' => array(
		array(
			'key' => '_ecp_custom_2',
			'value' => 'Jeffrey Lee',
		)),
*/

));



	// The result set may be empty
	if ( empty( $events ) ) {
	    echo 'Sorry, nothing found.';
	}	



	foreach ($events as $event) {
		echo get_the_title( $event ) . '<br/>';
		echo $event ->EventStartDate;

		echo $event ->post_content;

		//var_dump($event);
		echo '<hr>';
	}

?>


			

<br><br><br><br><br><br>
			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();

					// Include the page content template.
					get_template_part( 'content', 'page' );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
				endwhile;
			?>

		</div><!-- #content -->
	</div><!-- #primary -->
	<?php get_sidebar( 'content' ); ?>
</div><!-- #main-content -->


<?php
get_sidebar();
get_footer();
 ?>