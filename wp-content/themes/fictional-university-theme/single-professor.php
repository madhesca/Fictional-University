<?php 

get_header();

while(have_posts()) {
	the_post(); 
  //this is powered bt functions.php to have a resuable function for banner
  pageBanner();
  echo '<p style="color: red" >From single-professor.php</p>'; 
  ?>



<div class="container container--narrow page-section"> 
	

<div class="generic-content">
  <div class="row group">

    <div class="one-third"><?php the_post_thumbnail('professorPortrait'); ?></div>
    <div class="two-third"><?php the_content(); ?></div>



  </div>

</div>

<!--creating a link to the events page link to program -->

<?php 
  
  $relatedPrograms = get_field('related_programs'); //have access to custom fields @backend
  if ($relatedPrograms) {
    echo '<hr class = "section-break">';
    echo '<h2 class = "headline headline--medium">Subject(s) Taught</h2>';
    echo '<ul class="link-list min-list">';
    foreach($relatedPrograms as $program) { ?>
    <li><a href="<?php echo get_the_permalink($program); ?>"><?php echo get_the_title($program); ?></a></li>
 <?php }

echo '</ul>';
  }
  

?>


</div>

<?php	

}

get_footer();

?>