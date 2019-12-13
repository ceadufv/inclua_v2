<?php
/**
 * The template for displaying singular post-types: posts, pages and user-defined custom post types.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if (get_post_type() == 'post'):
?>

<!--AJUSTES PARA CEGO E SURDO-->
<div>
	<a href="?p=<?php echo($_GET['p']);?>&cego=true" type="button">aaaa</a>
	<a href="?p=<?php echo($_GET['p']);?>&surdo=true" type="button">Surdo</a>
</div>
<!--         ------         -->
<?php
endif;
while ( have_posts() ) : the_post();
	?>

<main <?php post_class( 'site-main' ); ?> role="main">
	<?php if ( apply_filters( 'hello_elementor_page_title', true ) ) : ?>
		<header class="page-header">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header>
	<?php endif; ?>
	<div class="page-content">
		<?php the_content(); ?>
		<div class="post-tags">
			<?php the_tags( '<span class="tag-links">' . __( 'Tagged ', 'hello-elementor' ), null, '</span>' ); ?>
		</div>
		<?php wp_link_pages(); ?>
	</div>
	<?php comments_template(); ?>
</main>

	<?php
endwhile;
