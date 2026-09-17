<?php
/**
 * Fallback template (blog index, search, 404, etc.) — the catalog itself
 * lives in front-page.php; WooCommerce provides its own shop/product
 * archive & single templates automatically via add_theme_support('woocommerce').
 */

get_header();
?>
<div class="container" style="padding: 60px 0;">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<article <?php post_class(); ?>>
				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<div><?php the_excerpt(); ?></div>
			</article>
		<?php endwhile; ?>
	<?php else : ?>
		<p>Ничего не найдено.</p>
	<?php endif; ?>
</div>
<?php get_footer(); ?>
