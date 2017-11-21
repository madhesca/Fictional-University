<?php 

get_header();
pageBanner(array(
    'title' => 'Past Events',
    'subtitle' => 'A recap of our past events.'
  ));

?>
<p style="color: red" >From page-past-events.php</p>
 


  <div class="container container--narrow page-section">

  <!-- this will filter and capture all past events -->
	<?php 
		$today = date('Ymd');
          $pastEvents = new WP_Query(array(
            'post_type' => 'event',
            'meta_key' => 'event_date',
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
            'meta_query' => array(
              array(
                'key' => 'event_date',
                'compare' => '<',
                'value' => $today,
                'type' => 'numeric'
              )
            )
          ));


          //this will display past events that filtered by the above codes
      while($pastEvents->have_posts()) {
        $pastEvents->the_post();
        //this is a code generated from conntent-event.php to reduce our code
       get_template_part('template-parts/content', 'event');

      }
        echo paginate_links(array(
        	'total' => $pastEvents->max_num_pages
        ));

     ?> 

  </div>



<?php get_footer();



?>