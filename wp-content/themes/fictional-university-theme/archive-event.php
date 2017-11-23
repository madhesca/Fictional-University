<?php 

get_header(); 
//This  code below here will fix the issue of first post's banner that will retro-act to the 'All events'
while(have_posts()) : the_post(); endwhile; rewind_posts(); //until here
pageBanner(array(
  'title' => 'All Events',
  'subtitle' => 'See what is going on in our world.'
));

?>

 <p style="color: red;" >From archive-event!</p>

  <div class="container container--narrow page-section">

    <!--this will diplay all upcoming events but pls check how it fill the past events -->
    <?php 
      while(have_posts()) {
        the_post(); 
//this is a code generated from conntent-event.php to reduce our code
     get_template_part('template-parts/content', 'event');

     }
        echo paginate_links();

     ?> 
     <hr class="section-break">
<p>Looking for a recap of past events? <a href="<?php echo site_url('/past-events') ?>">Check out our past events archive</a>.</p>


  </div>



<?php get_footer();



?>