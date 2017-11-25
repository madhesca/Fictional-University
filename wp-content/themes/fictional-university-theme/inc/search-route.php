<?php
//creating a new REST API URL
// purpose on these codes is to power our live search overlay
add_action('rest_api_init', 'universityRegisterSearch');

function universityRegisterSearch() {
	//namespace(wp) //route(professor) //what would happen if someone visits the url
	register_rest_route('university/v1', 'search', array(
		'methods' => WP_REST_SERVER::READABLE,
		'callback' => 'universitySearchResults'

	));
}
//giving us a post that post type is professor
function universitySearchResults($data) {
	$professors = new WP_Query(array(
		'post_type' => 'professor',
		's' => sanitize_text_field($data['term'])
	));

	$professorResults = array();

	while($professors->have_posts()) {
		$professors->the_post();
		//the array you want to add on to
		//what you want to add on to the array
		array_push($professorResults, array(
			'title' => get_the_title(),
			'permalink' => get_the_permalink()
		));
	}

	return $professorResults;
}