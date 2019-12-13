<?php
/**
 * The template for displaying singular post-types: posts, pages and user-defined custom post types.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<?php
while ( have_posts() ) : the_post();
?>

<main <?php post_class( 'site-main' ); ?> role="main">

	<?php
	if (get_post_type() == 'post'):
	?>
	<!--         add            -->
	<div>
		<a href="?p=<?php echo($_GET['p']);?>" type='button' class="button">Padrão</a>
		<a href="?p=<?php echo($_GET['p']);?>&access=cego" type='button' class="button">Cego</a>
		<a href="?p=<?php echo($_GET['p']);?>&access=surdo" type='button' class="button">Surdo</a>
	</div>
	<!--         ------         -->
	<?php
	endif;
	?>
	
	<?php if(isset($_GET['access']) == false){ //add ?>

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

	<?php } elseif($_GET['access'] == 'cego'){ //add ?>

		<header class="page-header">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header>
		<!--    EXIBIR PLAINTEXT     -->
		<?php print(wp_strip_all_tags(get_the_content())); ?>

	<?php } elseif($_GET['access'] == 'surdo'){ //add ?>

		<!--  EXIBIR APENAS O VIDEO  -->
		<?php 
			echo '<figure class="wp-block-video">';
			print_r(get_media_embedded_in_content(get_the_content())[0]); 
			echo '</figure>'; 
		?>
		
	<?php } ?>
</main>

	<?php
endwhile;
