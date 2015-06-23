<?php
/**
 * The template page file for displaying regional events
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @author radii
 */

get_header(); ?>

<!-- CONTENTS BEGIN HERE -->
<div class="content-body">
	<!-- BANNER BEGINS HERE -->
	<div class="jumbotron"></div>
	<!-- MAIN TITLE BEGINS HERE -->
	<div class="main-title">
		<div class="container">
			<h1><a href="#"><i class="fa fa-bars"></i></a> <?php the_title(); ?></h1>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<?php while ( have_posts() ) : the_post(); ?>

					<div id="main-content">
						<p><?php the_content(); ?></p>
					</div>
				<?php endwhile; // end of the loop. ?>
				<!-- SEARCH BAR BEGINS HERE -->
				<div id="tribe-events-bar">

							<form id="tribe-bar-form" class="tribe-clearfix" name="tribe-bar-form" method="get" action="<?php bloginfo('url'); ?>/events/">

								<!-- Mobile Filters Toggle -->

								<div id="tribe-bar-collapse-toggle" <?php if ( count( $views ) == 1 ) { ?> class="tribe-bar-collapse-toggle-full-width"<?php } ?>>
									<?php _e( 'Find Events', 'tribe-events-calendar' ) ?><span class="tribe-bar-toggle-arrow"></span>
								</div>

								<div class="tribe-bar-filters">
									<div class="tribe-bar-filters-inner tribe-clearfix">
										<div class="tribe-bar-search-filter">
											<input data-bind="label" type="text" placeholder="Enter keyword..." value="" id="tribe-bar-search" name="tribe-bar-search">	
										</div>	
										<div class="tribe-bar-date-filter">
											<label for="tribe-from-bar-date" class="label-tribe-from-bar-date"><i class="fa fa-calendar"></i> From</label>
											<input type="text" placeholder="Date" value="" id="tribe-bar-date" data-date-format="yyyy-mm-dd" style="position: relative; z-index:10000" name="tribe-bar-date">
											<input type="hidden" value="" class="tribe-no-param" id="tribe-bar-date-day" name="tribe-bar-date-day">								
										</div>
										<div class="tribe-bar-submit">
											<input class="tribe-events-button tribe-no-param" type="submit" name="submit-bar" value="<?php _e( 'Filter', 'tribe-events-calendar' ) ?>" />
										</div><!-- .tribe-bar-submit -->
									</div><!-- .tribe-bar-filters-inner -->
								</div><!-- .tribe-bar-filters -->

							</form><!-- #tribe-bar-form -->

						</div><!-- #tribe-events-bar -->
				<div class="page-header text-center">
					<h1>Upcoming <?php the_title(); ?></h1>
				</div>
				<!-- EVENT BOXES BEGINS HERE -->
				<div class="col-md-12 events">
					<?php       
						// Display Upcoming events with the category slug "regional-events"
						global $post;
						$eventsposts = tribe_get_events( array( 'eventDisplay'=>'upcoming', 'tribe_events_cat'=>'regional-events', 'posts_per_page' => 50 ) );	
					
						foreach($eventsposts as $post) : ?>

						<div class="col-md-4 event-box-container">
							<div class="col-md-3 event-date">
								<p>
									<span class="day">
									<?php 
										// Displays starting date
										echo tribe_get_start_date( null, false, $dateFormat = 'd' ); 
									?>
									</span>
									<span class="month">
										<?php 
											// Displays Month
											echo tribe_get_start_date( null, false, $dateFormat = 'M' );  
										?>
									</span>
								</p>
								<div class="event-line"></div>
								<p class="event-discount">5% off</p>
							</div>
							<div class="col-md-9 event-description">
								<h3>
									<strong><?php the_title(); ?></strong> 
									<?php
										// Displays city and or country if fields are filled
										if (empty( tribe_get_city() || tribe_get_country() )) {
											echo '';
										} else {
											echo '<br>' . tribe_get_city() . ', ' . tribe_get_country(); 
										}
									?>
								</h3>
								<?php echo wp_trim_words( get_the_content(), 15, '...' ); ?></p>
								<a href="<?php 	the_permalink(); ?>" class="viewmore">View More</a>
							</div>
						</div>

					<?php endforeach; ?>
				</div>
				<div class="page-header text-center">
					<h1>Past Regional Events</h1>
				</div>
				<!-- EVENT BOXES BEGINS HERE -->
				<div class="col-md-12 events">
					<?php       
						// Display Past events with the category slug "regional-events"
						global $post;
						$eventsposts = tribe_get_events( array( 'eventDisplay'=>'past', 'tribe_events_cat'=>'industry-events', 'posts_per_page' => 50 ) );	
					
						foreach($eventsposts as $post) : ?>

						<div class="col-md-4 event-box-container">
							<div class="col-md-3 event-date">
								<p>
									<span class="day">
									<?php 
										// Displays starting date
										echo tribe_get_start_date( null, false, $dateFormat = 'd' ); 
									?>
									</span>
									<span class="month">
										<?php 
											// Displays Month
											echo tribe_get_start_date( null, false, $dateFormat = 'M' );  
										?>
									</span>
								</p>
								<div class="event-line"></div>
								<p class="event-discount">5% off</p>
							</div>
							<div class="col-md-9 event-description">
								<h3>
									<strong><?php the_title(); ?></strong> 
									<?php
										// Displays city and or country if fields are filled
										if (empty( tribe_get_city() || tribe_get_country() )) {
											echo '';
										} else {
											echo '<br>' . tribe_get_city() . ', ' . tribe_get_country(); 
										}
									?>
								</h3>
								<?php echo wp_trim_words( $post->post_content, 15, '...' ); ?></p>
								<a href="<?php 	the_permalink(); ?>" class="viewmore">View More</a>
							</div>
						</div>

					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</div>		

<?php get_footer(); ?>