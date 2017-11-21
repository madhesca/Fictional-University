<?php 



get_header();

while(have_posts()) {
	the_post();
  pageBanner();
echo '<p style="color: red" >From single-campus.php</p>'; 
   ?>


<div class="container container--narrow page-section"> 
	<div class="metabox metabox--position-up metabox--with-home-link">
            <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('campus'); ?>"><i class="fa fa-home" 		aria-hidden="true"></i>All Campuses</a> <span class="metabox__main"><?php the_title(); ?></span></p>
          </div>

<!-- THIS IS THE CONTENT -->
<div class="generic-content"><?php the_content(); ?></div>


<!-- THIS WILL SHOW THE MAP BELOW THE CONTENT -->
 
<?php 
$mapLocation = get_field('map_location');
?>

 <div class="acf-map">
      <div class="marker" data-lat="<?php echo $mapLocation['lat'] ?>" data-lng="<?php echo $mapLocation['lng']; ?>">
         <h3><?php the_title(); ?></h3>
         <?php echo $mapLocation['address']; ?>
       </div>
   </div>
<!-- MAP LOCATION ENDS HERE -->


<!-- THIS IS A QUERY // GIVES ANY PROGRAM POSTS WERE RELATED CAMPUS CONTAINS ID OF THE CURRENT CAMPUS THAT WE ARE VIEWING -->
<?php
      $relatedPrograms = new WP_Query(array(
            'posts_per_page' => -1,
            'post_type' => 'program',
            'orderby' => 'title',
            'order' => 'ASC',
            'meta_query' => array(
              
              array(
                'key' => 'related_campus',
                'compare' => 'LIKE',
                'value' => '"' . get_the_ID() . '"'
              )
            )
          ));


          //Heading for Upcoming Program ei Biology events
          //wrap this into if statement for events w/c dont have program/related events

      //This here will out the Title - Biology Professors
          if ($relatedPrograms->have_posts()) {
              echo '<hr class = "section-break">';
          echo '<h2 class = "headline headline--medium">Programs Available At This Campus</h2>';


     // This here will output each professor image and title
          echo '<ul class="min-list link-list">';
            while($relatedPrograms->have_posts()) {
            $relatedPrograms->the_post(); ?>
   			 <li>
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
              </li>
			<?php }
          echo '</ul>';

          } 
          //when we run multiple queries on a single page we need to display both
          wp_reset_postdata(); //reset the global objects


        

         ?>

</div>


	
	
<?php	

}

get_footer();

?>