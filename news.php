
	<div class="newslist">
	<h1 class="xl">News</h1>

	<?php
$args = array(
   'posts_per_page' => 3,
   'post_type' => array( 'post', 'feature' )
);
?>

  <ul>
<?php
$query = new WP_Query($args);
while ( $query->have_posts() ) : $query->the_post();

?>

<li>
	<h2 class="l"><span><a href="<?php the_permalink() ?>">

          <?php the_title(); ?>
        </a>
      </span>
    </h2>
    <?php takelage_posted_on(); ?>
    <?php the_excerpt(); ?>
</li>


<?php
endwhile;
wp_reset_postdata(); ?>
  </ul>

</div>