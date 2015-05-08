<?php

function tpp_posts_widget()
{
	$tpp_posts_query = new WP_Query('&posts_per_page=10&orderby=comment_count&order=DESC');
	
	?>
	<h3><?php _e('Top Posts:') ?></h3>
	<?php if ( $tpp_posts_query->have_posts()) : 
			while ( $tpp_posts_query->have_posts()) : 
				$tpp_posts_query->the_post();
	?>
	<div class="tpp_posts">
		<a href="<?php echo the_permalink(); ?>"
		id="<?php echo the_id()?>"
		title="<?php echo the_title(); ?>"
		class="comment_link"><?php echo the_title(); ?></a>
		(<?php echo comments_number(); ?>)
	</div>
	<?php 	endwhile; 
		  endif; 
	?>
	<?php 
}

function tpp_posts_comments_return()
{
	$post_id = isset($_POST['post_id'])?$_POST['post_id']:0;
	
	if ( $post_id > 0 )
	{
			$post = get_post($post_id);
		?>
		<div id='post'><?php echo $post->post_content; ?></div>
		<?php 
	}
	die();
}
add_action('wp_ajax_nopriv_tpp_comments','tpp_posts_comments_return');

function tpp_posts_get_scripts ( ) {
  wp_enqueue_script( "tpp-posts", path_join(WP_PLUGIN_URL, basename( dirname( __FILE__ ) )."/top_posts.js"), array( 'jquery' ) );
}
add_action('wp_print_scripts', 'tpp_posts_get_scripts');


function tpp_posts_widget_init() {
	register_sidebar_widget('Top Posts', 'tpp_posts_widget');
}
add_action('widgets_init','tpp_posts_widget_init');