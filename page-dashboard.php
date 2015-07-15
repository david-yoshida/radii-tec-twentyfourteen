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


		// Function copied from TEC /plugins/events-calendar-pro/src/resources/js/widget-calendar.js?ver=3.10
		function fix_widget_height() {

			var wrapper = $( '.tribe-mini-calendar-wrapper' );
			if ( $( '.tribe-mini-calendar-wrapper.layout-wide' ).length && $( '.tribe-mini-calendar-right' ).length ) {
				var right_bar = $( '.tribe-mini-calendar-right' );
				var w_height = wrapper.height();
				var rb_height = right_bar.outerHeight();
				rb_height = rb_height + 20;

				if ( rb_height > w_height ) {
					wrapper.css( 'height', rb_height + 'px' );
				}
				else {
					wrapper.css( 'height', 'auto' );
				}
			}
			else if ( $( '.tribe-mini-calendar-wrapper.layout-wide' ).length ) {
				wrapper.css( 'height', 'auto' );
			}

		}
		
		// Checkbox Logic
	   	$('.TEC-Widget-filter').change(function() {


	   		// Get the Event Type checkbox values
	   		var myTECIDs = [];  // init the new filter

			$(".TEC-Widget-filter").each(function(){

				if ($(this).is(':checked')){  					
				    	myTECIDs.push($(this).val());
				    }
			});



			var myRegionIDs = [];
			extraText = '';
			// Get the Event Region dropdown values
			myRegionIDs = $('#TEC-Widget-filter-Region').val();

			if(myRegionIDs != ''){
				extraText = ',{"taxonomy":"tribe_events_cat","field":"id","operator":"IN","terms":["' + myRegionIDs + '"]}';
			}

			

			// Override intial data-tax-query  attribute
			overRideTaxonomy = '[{"taxonomy":"tribe_events_cat","field":"id","operator":"IN","terms":[' + myTECIDs.toString() + ']} ' + extraText + ']';
			$(".tribe-mini-calendar").attr("data-tax-query",overRideTaxonomy);

   			// Function copied from TEC /plugins/events-calendar-pro/src/resources/js/widget-calendar.js?ver=3.10
			var date = new Date(),
				day = date.getDate().toString(),
				month = (date.getMonth() + 1).toString(),
				year = date.getFullYear().toString(),
				current = year + '-' + (month[1] ? month : '0' + month[0]) + '-' + (day[1] ? day : '0' + day[0]),
				current_ym = current.slice( 0, 7 );

			var $this = $( this );

			//var $current_calendar = $this.closest( '.tribe-mini-calendar' );
			var $current_calendar = $( '.tribe-mini-calendar' );  // works
			//var $current_calendar_wrapper = $this.closest( '.tribe-mini-calendar-wrapper' );
			var $current_calendar_wrapper = $( '.tribe-mini-calendar-wrapper' ); // works
			

			//tempDateString = $('.tribe-mini-calendar-nav-link').attr("data-month");
			tempCurrentDateString = $('.tribe-mini-calendar').attr("data-eventdate");
			tempCurrentDateString = tempCurrentDateString.slice(0,10);  // only grab 2015-09-18

			//alert(tempCurrentDateString);  // Debug

			var month_target = tempCurrentDateString,
				target_ym = month_target.slice( 0, 7 );

			if ( current_ym == target_ym ) {
				month_target = current;
			}

			var params = {
				action   : 'tribe-mini-cal',
				eventDate: month_target,
				count    : $current_calendar.data( 'count' ),
				tax_query: $current_calendar.data( 'tax-query' ),
				nonce    : $current_calendar.data( 'nonce' )
			};
			$current_calendar.find( '.tribe-mini-calendar-nav div > span' ).addClass( 'active' ).siblings( '#ajax-loading-mini' ).show();

			$.post(
				TribeMiniCalendar.ajaxurl,
				params,
				function( response ) {
					$current_calendar.find( '.tribe-mini-calendar-list-wrapper' ).remove();
					if ( response.success ) {
						var $the_content = $.parseHTML( response.html );
						$current_calendar.find( '.tribe-mini-calendar-nav div > span' ).removeClass( 'active' ).siblings( '#ajax-loading-mini' ).hide();
						$current_calendar_wrapper.replaceWith( $the_content );
						fix_widget_height();
					}
				}
			);




      
	    });



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

				if(isset($_SESSION["radii-tec-filter"])){

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

						Event Type:
						<ul>
						<li><input class="TEC-Widget-filter" type="checkbox" value="20" checked>GP Summit</li>
						<li><input class="TEC-Widget-filter" type="checkbox" value="4" checked>Industry Events</li>
						<li><input class="TEC-Widget-filter" type="checkbox" value="22" checked>Institute</li>
						<li><input class="TEC-Widget-filter" type="checkbox" value="5" checked>Members' Only</li>
						<li><input class="TEC-Widget-filter" type="checkbox" value="3" checked>Webcast Series</li>
						<li><input class="TEC-Widget-filter" type="checkbox" value="21" checked>Workshop</li>
						</ul>
						

						Region:
						<select id="TEC-Widget-filter-Region" class="TEC-Widget-filter">
							<option value="">Region</option>
							<option value="11">Africa</option>
							<option value="12">Asia</option>
							<option value="13">Europe</option>
							<option value="14">Middle East</option>
							<option value="15">North America</option>
							<option value="16">Oceania</option>
							<option value="17">South America</option>
						</select>

						<p>&nbsp;</p>
						<!---
						<ul>
						<li><input class="TEC-Widget-filter-region" type="checkbox" value="11" checked>Africa</li>
						<li><input class="TEC-Widget-filter-region" type="checkbox" value="12" checked>Asia</li>
						<li><input class="TEC-Widget-filter-region" type="checkbox" value="13" checked>Europe</li>
						<li><input class="TEC-Widget-filter-region" type="checkbox" value="14" checked>Middle East</li>
						<li><input class="TEC-Widget-filter-region" type="checkbox" value="15" checked>North America</li>
						<li><input class="TEC-Widget-filter-region" type="checkbox" value="16" checked>Oceania</li>
						<li><input class="TEC-Widget-filter-region" type="checkbox" value="21" checked>South America</li>
						</ul>
						--->


						<?php
							//$str = '[tribe_mini_calendar category="industry-events,webcast-series"]';

							if (strlen($RAD_CAT_SLUG) > 0 )
								$str = '[tribe_mini_calendar category="'. $RAD_CAT_SLUG .'"]';
							else
								$str = '[tribe_mini_calendar category="industry-events"]';

							//$str = '[tribe_mini_calendar category="workshop,industry-events"]';
							//$str = '[tribe_mini_calendar category="gp-summit,workshop"]';
							$str = '[tribe_mini_calendar category="gp-summit,industry-events,institute,members-only-conferences,webcast-series,workshop,africa,asia,europe,middle-east,north-america,oceania,south-america"]';



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

