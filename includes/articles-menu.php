<style>

#articlestopnav {
	position:relative;
	height:auto;	
	margin-bottom:40px;
	margin-top: -20px;
	background: #0099cc; /* Old browsers */
	background: -moz-linear-gradient(top, #0099cc 0%, #006699 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#0099cc), color-stop(100%,#006699)); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top, #0099cc 0%,#006699 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top, #0099cc 0%,#006699 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top, #0099cc 0%,#006699 100%); /* IE10+ */
	background: linear-gradient(to bottom, #0099cc 0%,#006699 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#0099cc', endColorstr='#006699',GradientType=0 ); /* IE6-9 */	
}

#articlestopnav ul{
	margin: 0 auto;
	padding: 9px 0px 9px;
	text-align: center;
}

#articlestopnav ul li{
	display: inline;	
	list-style-type:none;
	border-left: #FFF 1px solid;
}

#articlestopnav ul li:first-child {
	border-left: none;
}

#articlestopnav ul li:first-child  a{
	padding-left: 15px;
}

#articlestopnav ul li a{
	text-decoration:none;
	color:#fff;	
	
	font-size:1.6rem;
	font-weight:normal;
	margin:0;
	font-family:Arial, Helvetica, sans-serif;
	padding: 0px 20px 0px 20px;
	text-transform:uppercase;
	line-height:20px;
}


@media only screen and (max-width: 900px) {

  #articlestopnav {
	margin-top: -40px;
  }
  
	#articlestopnav ul {
		padding: 5px 0;
		margin: 0 auto;
	
	}
	
	#articlestopnav ul li{
		display: block;	
		padding: 0;
		margin: 0 auto;
		list-style-type:none;
		border-left: none;
	}

		#articlestopnav ul li a{
			padding: 20px 20px 15px 20px;
			display: block;
		}
		
			#articlestopnav ul li a:hover{
				color: #FFFFFF;
				background: #006699;
			}
	
}

#articlestopnav span a{
	position:relative;
	bottom:4px;
	left:5px;
}

#articlestopnav a:hover {
	color:#000;
}

#articleheaderform {
	margin: 0 20px 40px;
	padding: 30px 20px 10px;
	background-color: #1a4362;
}

	#articleheaderform input {
		border: none !important;
	}
	#articleheaderform input[type="text"],
	#articleheaderform input[type="email"]{
		border: #CCC 1px solid;
	}
	
	#articleheaderform input#articleSubmit {
		background: transparent url('<?php echo get_stylesheet_directory_uri(); ?>/images/btn-download-s.png') center center no-repeat;
		height: 55px;
		font-size: 0;
		text-color: transparent;
		width: 200px;
	}

</style>    

	<div id="articlestopnav">
		<ul>							
			<li><a href="<?php echo bloginfo('url') ?>/meeting-women-online/">Meeting Women</a></li>
			<li><a href="<?php echo bloginfo('url') ?>/attraction">Attraction</a></li>
			<li><a href="<?php echo bloginfo('url') ?>/data-driven-tips/">Data-Driven Tips</a></li>
			<li><a href="<?php echo bloginfo('url') ?>/becoming-a-click-magnet/">Becoming A Click Magnet</a></li>
			<li><a href="<?php echo bloginfo('url') ?>/taking-it-offline/">Taking It Offline</a></li>
		</ul>
    </div>				
    <div style="clear: both"></div>	