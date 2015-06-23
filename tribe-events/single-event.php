<?php
/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$event_id = get_the_ID();

?>

<div id="tribe-events-content" class="tribe-events-single vevent hentry">

	<p class="tribe-events-back">
		<a href="<?php echo esc_url( tribe_get_events_link() ); ?>"> <?php _e( '&laquo; All Events', 'tribe-events-calendar' ) ?></a>
	</p>

	<!-- Notices -->
	<?php tribe_events_the_notices() ?>

	<?php the_title( '<h2 class="tribe-events-single-event-title summary entry-title">', '</h2>' ); ?>

	<div class="tribe-events-schedule updated published tribe-clearfix">
		<?php echo tribe_events_event_schedule_details( $event_id, '<h3>', '</h3>' ); ?>
		<?php if ( tribe_get_cost() ) : ?>
			<span class="tribe-events-divider">|</span>
			<span class="tribe-events-cost"><?php echo tribe_get_cost( null, true ) ?></span>
		<?php endif; ?>
	</div>

	<!-- Event header -->
	<div id="tribe-events-header" <?php tribe_events_the_header_attributes() ?>>
		<!-- Navigation -->
		<h3 class="tribe-events-visuallyhidden"><?php _e( 'Event Navigation', 'tribe-events-calendar' ) ?></h3>
		<ul class="tribe-events-sub-nav">
			<li class="tribe-events-nav-previous"><?php tribe_the_prev_event_link( '<span>&laquo;</span> %title%' ) ?></li>
			<li class="tribe-events-nav-next"><?php tribe_the_next_event_link( '%title% <span>&raquo;</span>' ) ?></li>
		</ul>
		<!-- .tribe-events-sub-nav -->
	</div>
	<!-- #tribe-events-header -->

	<?php while ( have_posts() ) :  the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<!-- Event featured image, but exclude link -->
			<?php echo tribe_event_featured_image( $event_id, 'full', false ); ?>

			<!-- Event content -->
			<?php do_action( 'tribe_events_single_event_before_the_content' ) ?>









			<!-- START: TABBING OF CUSTOM FIELDS HERE - dyoshida -->
			<?php

			// Init check for the following ACF fields that help build the tabs and tab content
			$tabs = array('agenda', 'speakers', 'accommodation', 'professional_development_seminar', 'registration');

			// Build event tab array
			$eventTabsNameArray = array();
			$eventTabsLabelArray = array();
			$eventTabsContentArray = array();



			// Add stuff to event tab array
			for($x = 0; $x < count($tabs); $x++) {

				//$tmp_str = get_field($tabs[$x]); // grab the contents from ACF
				$acfItem = get_field_object($tabs[$x]);
				$tmp_str = $acfItem['value']; // grab the contents from ACF


				if(!empty($acfItem)){

					if ( ($tabs[$x] == 'speakers' && count($tmp_str) > 1 ) || ($tabs[$x] != 'speakers')  && strlen($tmp_str) > 1) // speaker array always have on row??
					{
						array_push($eventTabsNameArray, $acfItem['name']);
						array_push($eventTabsLabelArray, get_field_object($tabs[$x])['label']);
						array_push($eventTabsContentArray, $tmp_str);
					}
				}
			}
 			?>
 			<!-- Nav tabs -->
			<ul id="customTab" class="nav nav-tabs" role="tablist">
			  <li role="presentation" class="active"><a href="#description" aria-controls="description" role="tab" data-toggle="tab">Description</a></li>
			<?php 
				for($y = 0; $y < count($eventTabsNameArray); $y++) {
					echo '<li role="presentation"><a href="#'.$eventTabsNameArray[$y] .'" aria-controls="' . $eventTabsNameArray[$y] . '" role="tab" data-toggle="tab">' . $eventTabsLabelArray[$y] . '</a></li>';
				}
			?>
			</ul> 				

			<!-- Nav panes  -->
			  <div class="tab-content">
			    <div role="tabpanel" class="tab-pane active" id="description">

				    <!-- MOVED FROM TEC into description -->
					<div class="tribe-events-single-event-description tribe-events-content entry-content description">
						<?php the_content(); ?>
					</div>			    	

					<!-- .tribe-events-single-event-description -->
					<?php do_action( 'tribe_events_single_event_after_the_content' ) ?>

			    </div>
				<?php 
					for($y = 0; $y < count($eventTabsNameArray); $y++) {

						if( $eventTabsNameArray[$y] != 'speakers'){
						echo '<div role="tabpanel" class="tab-pane" id="' . $eventTabsNameArray[$y] . '">' . $eventTabsContentArray[$y] . '</div>';
						}	
						else
						{
							// SPEAKER ARRAY DETECTED! Loop through speaker array.  Show record if the speaker name exists.
							echo '<div role="tabpanel" class="tab-pane" id="' . $eventTabsNameArray[$y] . '">';
							?>
							<div class="row">
								<?php if( get_field('speakers') ): ?>
										<?php while( has_sub_field('speakers') ): ?>
											<?php if (the_sub_field('speaker_name') != ""){ ?>
											<div class="col-md-12 padding-bottom-30">
												<div class="col-md-3">
													<img src="<?php the_sub_field('photo'); ?>" class="img-responsive">
												</div>
												<div class="col-md-9">
													<h3><?php the_sub_field('speaker_name'); ?></h3>
													<p><?php the_sub_field('title'); ?>, <?php the_sub_field('organization'); ?></p>
													<p><?php the_sub_field('bio'); ?></p>
												</div>
											</div>
											<?php } ?>
										<?php endwhile; ?>
								<?php endif; ?>
							</div>
							<?php
							echo '</div>';
						}
					}
				?>
			  </div>			
			<!-- END: TABBING OF CUSTOM FIELDS HERE - dyoshida -->








			<!-- Event meta -->
			<?php do_action( 'tribe_events_single_event_before_the_meta' ) ?>
			<?php
			/**
			 * The tribe_events_single_event_meta() function has been deprecated and has been
			 * left in place only to help customers with existing meta factory customizations
			 * to transition: if you are one of those users, please review the new meta templates
			 * and make the switch!
			 */
			if ( ! apply_filters( 'tribe_events_single_event_meta_legacy_mode', false ) ) {
				tribe_get_template_part( 'modules/meta' );
			} else {
				echo tribe_events_single_event_meta();
			}
			?>
			<?php do_action( 'tribe_events_single_event_after_the_meta' ) ?>
		</div> <!-- #post-x -->
		<?php if ( get_post_type() == TribeEvents::POSTTYPE && tribe_get_option( 'showComments', false ) ) comments_template() ?>
	<?php endwhile; ?>

	<!-- Event footer -->
	<div id="tribe-events-footer">
		<!-- Navigation -->
		<!-- Navigation -->
		<h3 class="tribe-events-visuallyhidden"><?php _e( 'Event Navigation', 'tribe-events-calendar' ) ?></h3>
		<ul class="tribe-events-sub-nav">
			<li class="tribe-events-nav-previous"><?php tribe_the_prev_event_link( '<span>&laquo;</span> %title%' ) ?></li>
			<li class="tribe-events-nav-next"><?php tribe_the_next_event_link( '%title% <span>&raquo;</span>' ) ?></li>
		</ul>
		<!-- .tribe-events-sub-nav -->
	</div>
	<!-- #tribe-events-footer -->

</div><!-- #tribe-events-content -->
