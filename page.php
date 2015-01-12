
<?php
get_header(); ?>


<?php
	   if ( have_posts() ) while ( have_posts() ) : the_post();
		$custom_fields = get_post_custom();

			if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() && ! has_post_format('image') && ! has_post_format('gallery')) { ?>
				<div class="post-image">
					<?php the_post_thumbnail(); ?>
				</div>
			<?php }

	    the_content();

	    wp_link_pages( array( 'before' => '' . __( 'Pages:', 'luna' ), 'after' => '' ) );
	    edit_post_link( __( 'Edit', 'luna' ), '', '' );
        endwhile;
	?>

<?php get_footer(); ?>