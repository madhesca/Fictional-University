<?php
//creating a new REST API URL
// purpose on these codes is to power our live search overlay
add_action('rest_api_init', 'universityRegisterSearch');

function universityRegisterSearch() {
	//namespace(wp) //route(professor) //what would happen if someone visits the url
	register_rest_route('university/v1', 'search', array(
		//replacement for 'GET' -this is the CRUD part. specifically READ
		//the return of this data is the JSON
		'methods' => WP_REST_SERVER::READABLE,
		'callback' => 'universitySearchResults'

	));
}
//giving us all the JSON data ei, post, pages, prof, events, etc
// the $data please see lecture 64		 
function universitySearchResults($data) {
	$mainQuery = new WP_Query(array(
		'post_type' => array('post', 'page', 'professor', 'program', 'campus', 'event'),

		's' => sanitize_text_field($data['term'])
	));

	$results = array(
		'generalInfo' => array(),
		'professors' => array(),
		'programs' => array(),
		'events' => array(),
		'campuses' => array()
	);

	while($mainQuery->have_posts()) {
		 $mainQuery->the_post();
		//the array you want to add on to
		//what you want to add on to the array

		if(get_post_type() == 'post' OR get_post_type() == 'page') {
			array_push($results['generalInfo'], array(
			'title' => get_the_title(),
			'permalink' => wp_make_link_relative(get_the_permalink()),
			'postType' => get_post_type(),
			'authorName' => get_the_author()
		));
		}

		if(get_post_type() == 'professor') {
			array_push($results['professors'], array(
			'title' => get_the_title(),
			'permalink' => wp_make_link_relative(get_the_permalink()),
			//w/c post you want to get the thimbnail image for (0 means current post)
			//w/c size we want
			'image' => get_the_post_thumbnail_url(0, 'professorLandscape')
		));
		}
		//*****STARTS HERE****//
		//THIS CREATES A REALTIONSHIP  BETWEEN PROGRAMS AND CAMPUSES//
		if(get_post_type() == 'program') {
			$relationCampuses = get_field('related_campus');

			if($relationCampuses) {
				foreach($relationCampuses as $campus) {
					array_push($results['campuses'], array(
						'title' => get_the_title($campus),
						'permalink' => get_the_permalink($campus)
					));
				}
			}
			
		array_push($results['programs'], array(
			'title' => get_the_title(),
			'permalink' => wp_make_link_relative(get_the_permalink()),
			'id' => get_the_id()
		));
		}
		//*****ENDS HERE****//



		if(get_post_type() == 'campus') {
			array_push($results['campuses'], array(
				'title' => get_the_title(),
				'permalink' => wp_make_link_relative(get_the_permalink())
			));
		}
	
	if(get_post_type() == 'event') {
		$eventDate = new DateTime(get_field('event_date'));
		$description = null;
		if(has_excerpt()) {
           $description = get_the_excerpt();
            } else {
              $description = wp_trim_words(get_the_content(), 18);
            }
			array_push($results['events'], array(
			'title' => get_the_title(),										
			'permalink' => wp_make_link_relative(get_the_permalink()),
			'month' => $eventDate->format('M'),
			'day' => $eventDate->format('d'),
			'description' => $description
		));

	 }

	}

//****THIS PART IS FOR THE RELATIONSHIP OF PROFESSORS AND PROGRAMS/INCLUDING PROGRAMS - EVENTS****//

//only if programs exist we want to loop to programs to display its related professors
if($results['programs']) {
	//this will make the "programs'][0]['id']" dynamic because there are times when we dont know how related programs we have to our PROFESSOR
	//see leacture no 69
	$programsMetaQuery = array('relation' => 'OR');
	//looping the programs
	foreach($results['programs'] as $item) {
		array_push($programsMetaQuery, array(
				'key' => 'related_programs',
				'compare' => 'LIKE',
				'value' => '"' . $item['id'] . '"'
			));
	}
//showing related professor
	//giving us any professors where one of the ralated program is biology(the hardcoded 'value' => '"57"' or the biology program post)
	$programRelationshipQuery = new WP_Query(array(
		'post_type' => array('professor', 'event'),
		'meta_query' => $programsMetaQuery
	));

	while($programRelationshipQuery->have_posts()) {
		$programRelationshipQuery->the_post();
//THIS IS FOR RELATIONSHIP OF PROGRAM AND EVENTS
		if(get_post_type() == 'event') {
		$eventDate = new DateTime(get_field('event_date'));
		$description = null;
		if(has_excerpt()) {
           $description = get_the_excerpt();
            } else {
              $description = wp_trim_words(get_the_content(), 18);
            }
			array_push($results['events'], array(
			'title' => get_the_title(),										
			'permalink' => wp_make_link_relative(get_the_permalink()),
			'month' => $eventDate->format('M'),
			'day' => $eventDate->format('d'),
			'description' => $description
		));

	 }


//THIS IS FOR RELATIONSHIP OF PROGRAM AND PROFESSORS

		if(get_post_type() == 'professor') {
			array_push($results['professors'], array(
			'title' => get_the_title(),
			'permalink' => wp_make_link_relative(get_the_permalink()),
			'image' => get_the_post_thumbnail_url(0, 'professorLandscape')
		));
		}
	}

	//this will remove any duplicate crated by 2 WP queries
	//1st. array the we want to work with
	//2nd. checking if there is double
	//wrapping array_unique to array_values to remove the number created by array values
	$results['professors'] = array_values(array_unique($results['professors'],  SORT_REGULAR));
	$results['events'] = array_values(array_unique($results['events'],  SORT_REGULAR));

}

	return $results;
}