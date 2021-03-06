<?php 



get_header();

while(have_posts()) {
	the_post();
  pageBanner();
echo '<p style="color: red" >From single-program.php</p>'; 
   ?>


<div class="container container--narrow page-section"> 
	<div class="metabox metabox--position-up metabox--with-home-link">
            <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program'); ?>"><i class="fa fa-home" 		aria-hidden="true"></i>All Programs</a> <span class="metabox__main"><?php the_title(); ?></span></p>
          </div>


<div class="generic-content"><?php the_field('main_body_content'); ?></div>

<?php
      $relatedProfessors = new WP_Query(array(
            'posts_per_page' => -1,
            'post_type' => 'professor',
            //'meta_key' => 'event_date',
            'orderby' => 'title',
            'order' => 'ASC',
            'meta_query' => array(
              
              array(
                'key' => 'related_programs', //this will filter events that belongs to the current program. ei. Math
                'compare' => 'LIKE',
                'value' => '"' . get_the_ID() . '"'
              )
            )
          ));

          //Heading for Upcoming Program ei Biology events
          //wrap this into if statement for events w/c dont have program/related events

      //This here will out the Title - Biology Professors
          if ($relatedProfessors->have_posts()) {
              echo '<hr class = "section-break">';
          echo '<h2 class = "headline headline--medium">' . get_the_title() . ' Professors</h2>';


     // This here will output each professor image and title
          echo '<ul class="professor-cards">';
            while($relatedProfessors->have_posts()) {
            $relatedProfessors->the_post(); ?>
   
              <li class="professor-card__list-item">
                <a class="professor-card" href="<?php the_permalink(); ?>">
                    <img class="professor-card__image" src="<?php the_post_thumbnail_url('professorLandscape') ?>">
                    <span class="professor-card__name"><?php the_title(); ?></span>

                </a>
              </li>

          <?php }
          echo '</ul>';

          }
          //when we run multiple queries on a single page we need to display both
          wp_reset_postdata(); //reset the global objects



      //pull in upcoming related events
        $today = date('Ymd');
          $homepageEvents = new WP_Query(array(
            'posts_per_page' => 2,
            'post_type' => 'event',
            'meta_key' => 'event_date',
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
            'meta_query' => array(
              array(
                'key' => 'event_date', //this serves as filter. it will only display events that are upcoming. not past events.
                'compare' => '>=',
                'value' => $today,
                'type' => 'numeric'
              ),
              array(
                'key' => 'related_programs', //this will filter events that belongs to the current program. ei. Math
                'compare' => 'LIKE',
                'value' => '"' . get_the_ID() . '"'
              )
            )
          ));

          //Heading for Upcoming Program ei Biology events
          //wrap this into if statement for events w/c dont have program/related events
          if ($homepageEvents->have_posts()) {
              echo '<hr class = "section-break">';
          echo '<h2 class = "headline headline--medium">Upcoming ' . get_the_title() . ' Events</h2>';

          while($homepageEvents->have_posts()) {
            $homepageEvents->the_post();
              get_template_part('template-parts/content', 'event');

          }

          }
          wp_reset_postdata();


          //THIS HERE WILL OUTPUT CAMPUS IF THERES ANY

          $relatedCampuses = get_field('related_campus');
          
            //if THERE IS CAMPUS BEING TAG, IT WILL POST THE TITLE AND THE LINK
          if ($relatedCampuses) {
            echo '<hr class = "section-break">';
            echo '<h2 class = "headline headline--medium">' .get_the_title() .  ' is Availble At These Campuses</h2>';

            //will OUTPUT HERE ONE LINK TO CAMPUS that lives in get_field('related_campus');

            echo '<ul class = "min-list link-list">';
            foreach($relatedCampuses as $campus) {
              ?> <li><a href="<?php echo get_the_permalink($campus); ?>"><?php echo get_the_title($campus) ?></a></li> <?php
            }
            echo '</ul>';

          }





         ?>

</div>


	
	
<?php	

}

get_footer();

?>