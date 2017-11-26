<?php
/**
 * The sidebar containing the articles sidebar.
 *
 * @package Moesia
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area" role="complementary">

	<aside id="youtube-widget" class="widget sidebar-nopadding ">				
		
		<div class="textwidget">
			
			<img class="aligncenter img-responsive " src="<?php echo get_stylesheet_directory_uri() ?>/images/click-magnet-logo.png" />
		
		</div>
		
	</aside>
		
	

	<aside id="youtube-widget" class="widget sidebar-nopadding youtube clip">				
		
		<div class="textwidget">
			<iframe title="YouTube video player" width="215" height="154" src="http://www.youtube.com/embed/UsGNJnoibNo?rel=0" frameborder="0" allowfullscreen></iframe>
		</div>
		
	</aside>
	
	<aside id="popular_entries" class="widget popular widget_popular_entries">

<style>

.widget-area .widget.popular li:before {
	content: none;
}

.popular .widget-title {
	font-family: 'Merriweather', Georgia, serif !important;
}

.popular ul {
	margin: 0;
	font: normal 16px/1.57142857 Arial,"Helvetica Neue",Helvetica,sans-serif;
}

.popular  li  {
	min-height: 60px;
	margin: 10px 0;
	line-height: 16px;
}

.popular  li:after {
	clear: both;
}

.popular  li a{
	font-size: 14px;
	line-height: 1.5;
	color: #034462 !important;
}
	.popular  li a:hover{
		color: #0090ed !important;
	}
.popular  li .img_wrap {
	display: block;
	float: left;
	width: 60px !important;
	height: 60px !important;
	margin-right: 10px !important;
	overflow: hidden;
	/* border: #CCC 2px solid; */
}

.popular  li .img_wrap img.wp-post-image {
	max-width: 100px !important;
	max-height: 100px !important;
}

</style>
	
		<h3 class="widget-title">Most Popular Articles</h3>
		<ul>
			<li id="dd_page_widget-18" class=""><div class="img_wrap"><img width="58" height="60" src="http://www.virtualdatingassistants.com/wp-content/uploads/2011/03/Article3150.jpg" class="attachment-page_thumb_sizedd_page_widget-17 wp-post-image" alt="Article3150" /></div><a href="http://www.virtualdatingassistants.com/becoming-a-click-magnet/get-her-to-respond-to-your-message-online/">Get Her Addicted To You  </a></li>
			<li id="dd_page_widget-18" class=""><div class="img_wrap"><img width="55" height="60" src="http://www.virtualdatingassistants.com/wp-content/uploads/2011/03/Article3-e1299966805632.jpg" class=		"attachment-page_thumb_sizedd_page_widget-18 wp-post-image" alt="Article3" /></div><a href="http://www.virtualdatingassistants.com/data-driven-tips/how-to-internet-date-for-nice-guys/">Do Nice Guys Finish Last Online?</a></li>
			<li id="dd_page_widget-19" class=""><div class="img_wrap"><img width="60" height="40" src="http://www.virtualdatingassistants.com/wp-content/uploads/2011/03/Article2.jpg" class="attachment-page_thumb_sizedd_page_widget-19 wp-post-image" alt="Article2" /></div><a href="http://www.virtualdatingassistants.com/data-driven-tips/cocky-and-funny-approach-online/">Does Cocky & Funny REALLY Work Online?</a></li>
			<li id="dd_page_widget-20" class=""><div class="img_wrap"><img width="60" height="48" src="http://www.virtualdatingassistants.com/wp-content/uploads/2011/03/Article21.jpg" class="attachment-page_thumb_sizedd_page_widget-20 wp-post-image" alt="Article2" /></div><a href="http://www.virtualdatingassistants.com/becoming-a-click-magnet/be-magnetically-attractive-to-women-online/">How To Be The Guy Women Chase Online</a></li>
		</ul>
	</aside>
	
</div><!-- #secondary -->
