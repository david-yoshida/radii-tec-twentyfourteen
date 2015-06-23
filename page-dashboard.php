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


<script type='text/javascript'>
	
	jQuery(document).ready (function($) {	

		//  Check if user is on the dashboard page.  If so, then handle the hiding of views.
		if($('#RAD_VIEW').length != 0) {


			var myView = $("#RAD_VIEW").attr( "view");

			if(myView == 'list'){
				$('#panel-tec-calendar-view').hide();
			}else
			{
				$('#panel-tec-list-view').hide();
			}


			// Assign buttons acctions
			$( '#btn-tec-list-view' ).on( 'click.twentyfourteen', function( event ) {

				$('#panel-tec-calendar-view').hide();
				$('#panel-tec-list-view').show();

			} );

			$( '#btn-tec-calendar-view' ).on( 'click.twentyfourteen', function( event ) {

				$('#panel-tec-calendar-view').show();
				$('#panel-tec-list-view').hide();

			} );



		}

	});

</script>

<div id="main-content" class="main-content">



<?php
	if ( is_front_page() && twentyfourteen_has_featured_posts() ) {
		// Include the featured content template.
		get_template_part( 'featured-content' );
	}
?>
	<div id="primary" class="content-area">



		<div id="content" class="site-content" role="main">


				<button id="btn-tec-list-view" class="btn btn-default" type="submit"><span class="glyphicon glyphicon-list"></span>List View</button>
				<button id="btn-tec-calendar-view" class="btn btn-default" type="submit"><span class="glyphicon glyphicon-calendar"></span>Calendar View</button>
				

				<?php
					// Session Code here

				$RAD_CAT_SLUG ='';

				if (isset($_GET['RAD_CAT_SLUG'])) { 

					$RAD_CAT_SLUG = $_GET['RAD_CAT_SLUG'];
				}


				$RAD_VIEW ='list';

				if (isset($_GET['RAD_VIEW'])) { 

					$RAD_VIEW = $_GET['RAD_VIEW'];
				}


				//if (isset($_GET['saved']))

				if(!$_SESSION["radii-tec-filter"]){

					 $_SESSION["radii-tec-filter"]= $RAD_CAT_SLUG;
				}


				// KEEP FOR TROUBLE SHOOTING				
				//echo $RAD_CAT_SLUG;
				//echo '  View ' . $RAD_VIEW;


				// TODO:  keep passing calendar date via URL to preserve date


				?>	

			<div id="RAD_VIEW" view="<?php echo $RAD_VIEW ?>"></div>

			<table>
				<tr>
					<td width="300">

						<div id="panel-tec-list-view">
						<h2>List View</h2>


						<div class="dropdown">
						  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
						    Dropdown
						    <span class="caret"></span>
						  </button>
						  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
						    <li><a href="/dashboard/?RAD_VIEW=list&RAD_CAT_SLUG=gp-summit">GP Summit</a></li>
						    <li><a href="/dashboard/?RAD_VIEW=list&RAD_CAT_SLUG=industry-events">Industry Events</a></li>
						    <li><a href="/dashboard/?RAD_VIEW=list&RAD_CAT_SLUG=institute">Institute</a></li>
						    <li><a href="/dashboard/?RAD_VIEW=list&RAD_CAT_SLUG=members-only-conferences">Members' Only</a></li>
						    <li><a href="/dashboard/?RAD_VIEW=list&RAD_CAT_SLUG=webcast-series">Webcast Series</a></li>
						    <li><a href="/dashboard/?RAD_VIEW=list&RAD_CAT_SLUG=workshop">Workshop</a></li>
						  </ul>
						</div>


						<?php


							//$str = '[tribe_events_list  from="2014-10-01" category="industry-events"]';
							//$str = '[event_rocket_list category="webcast-series"]';
							//$str = '[event_rocket_list category="industry-events"]';

						if (strlen($RAD_CAT_SLUG) > 0 )
							$str = '[event_rocket_list from="2015-08-01" category="'. $RAD_CAT_SLUG .'"]';
						else
							$str = '[event_rocket_list from="2015-08-01"]';

						
							echo do_shortcode($str); 
						?>	
						</div>


						<div id="panel-tec-calendar-view" >
						<h2>Calendar View</h2>


						<div class="dropdown">
						  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
						    Dropdown
						    <span class="caret"></span>
						  </button>
						  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
						    <li><a href="/dashboard/?RAD_VIEW=calendar&RAD_CAT_SLUG=gp-summit">GP Summit</a></li>
						    <li><a href="/dashboard/?RAD_VIEW=calendar&RAD_CAT_SLUG=industry-events">Industry Events</a></li>
						    <li><a href="/dashboard/?RAD_VIEW=calendar&RAD_CAT_SLUG=institute">Institute</a></li>
						    <li><a href="/dashboard/?RAD_VIEW=calendar&RAD_CAT_SLUG=members-only-conferences">Members' Only</a></li>
						    <li><a href="/dashboard/?RAD_VIEW=calendar&RAD_CAT_SLUG=webcast-series">Webcast Series</a></li>
						    <li><a href="/dashboard/?RAD_VIEW=calendar&RAD_CAT_SLUG=workshop">Workshop</a></li>
						  </ul>
						</div>


						<?php
							//$str = '[tribe_mini_calendar category="industry-events,webcast-series"]';

							if (strlen($RAD_CAT_SLUG) > 0 )
								$str = '[tribe_mini_calendar category="'. $RAD_CAT_SLUG .'"]';
							else
								$str = '[tribe_mini_calendar category="industry-events"]';



							echo do_shortcode($str);

						?>							
							

						<?php

							//$str = '[tribe_mini_calendar category="webcast-series"]';

							//echo do_shortcode($str);

						?>

						</div>


					</td>
					<td width="400">

							Something else here


					</td>
				</tr>	
			</table>




		</div><!-- #content -->
	</div><!-- #primary -->
	<?php get_sidebar( 'content' ); ?>
</div><!-- #main-content -->

<?php
// get_sidebar();
get_footer();

