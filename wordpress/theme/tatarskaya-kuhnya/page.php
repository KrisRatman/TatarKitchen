<?php
/**
 * Generic WordPress Page template — used for the WooCommerce
 * Cart/Checkout/My Account pages (each just holds a shortcode) as well
 * as any other plain page, hence the_content() rather than the_excerpt().
 */

get_header();
?>
<div class="container">
	<?php while ( have_posts() ) : the_post(); ?>
		<h1 class="section__title" style="margin-top:60px;"><?php the_title(); ?></h1>
		<?php the_content(); ?>
	<?php endwhile; ?>
</div>
<?php get_footer(); ?>
