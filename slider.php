

<?php
$args = array(
   'posts_per_page' => 5,
   'post_type' => 'feature',
);
?>
<div class="flexslider">
  <ul class="slides">
<?php
$the_query = new WP_Query($args);
while ( $the_query->have_posts() ) : $the_query->the_post();
  echo '<li class="slide"><figure>';
  if ( has_post_thumbnail() ) { the_post_thumbnail(); }
  ?>
  <figcaption>
    <h2 class="l">
      <span>
        <a href="<?php the_permalink() ?>">
          <?php the_title(); ?>
        </a>
      </span>
    </h2>
  </figcaption>
  <?php
  echo '</figure></li>';
endwhile;
wp_reset_postdata(); ?>
  </ul>
</div>



