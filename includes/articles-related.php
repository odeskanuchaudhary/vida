<div id="related-articulos">				
<?php				
$child_pages = $wpdb->get_results("SELECT *    FROM $wpdb->posts WHERE post_parent = ".$post->ID."    AND post_type = 'page' ORDER BY menu_order", 'OBJECT');    ?>				
<?php if ( $child_pages ) : foreach ( $child_pages as $pageChild ) : setup_postdata( $pageChild ); ?>
	<hr />
	<div class="entry-summary rtext ">
		<div class="articlethumb">
			<?php echo get_the_post_thumbnail($pageChild->ID, 'thumbnail'); ?>
		</div>
		<h2><a href="<?php echo  get_permalink($pageChild->ID); ?>" rel="bookmark" title="<?php echo $pageChild->post_title; ?>"><?php echo $pageChild->post_title; ?></a></h2>		
		<p><?php echo $pageChild->post_excerpt; ?></p>							
		<p><a class="read-more" href="<?php echo  get_permalink($pageChild->ID); ?>" rel="bookmark" title="<?php echo $pageChild->post_title; ?>">Continue reading <span class="meta-nav">&rarr;</span></a></p>
		
		<div class="clear"></div>				
	</div>			
<?php endforeach; endif; ?>				
</div><!--END related-articulos-->