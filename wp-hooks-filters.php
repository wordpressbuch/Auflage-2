<?php
/**
 * copy in root of your wordpres-install
 */
 
if ( file_exists('./wp-load.php') ) {
	require('./wp-load.php');
} else die('File <code>wp-blog-header.php</code> not found. This script you are trying to run must sit either in your blog root or in <code>wp-admin</code> directory');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  dir="ltr" lang="de-DE">
<head>
	<title>Simple WordPress Hooks &amp; Filters Insight</title>
	<link rel="stylesheet" href="<?php echo get_option('siteurl') ?>/wp-admin/wp-admin.css?version=<?php bloginfo('version'); ?>" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo get_option('siteurl') ?>/wp-admin/css/colors-fresh.css?version=<?php bloginfo('version'); ?>" type="text/css" media="screen" />
	<style type="text/css" media="screen">
		#footer {margin-top: 50px;}
		.menu {width:250px; height:450px; position:fixed; top:15px; right:15px; overflow:auto; border:1px solid #333; padding:0 10px 10px 10px; background:#fff;}
		.menu h4 {position:fixed; top:0; right:45px;}
		.menu ol {margin-left:-10px;}
		il li, ul li {margin-bottom:3px;}
		textarea {padding:5px; margin:3px;}
	</style>

	<!--[if lt IE 7]><style>
	* html .menu {
		position: absolute;
		margin-top: expression("1em");
		padding-left: 50px;
		top: expression(eval(document.compatMode && document.compatMode=='CSS1Compat') ? documentElement.scrollTop : document.body.scrollTop);
		}
		
	* html body { /* speed fix */
		background: url(irgendein.png) fixed;
		}
	</style><![endif]-->
	
</head>
<body>
	<?php $dump = 0; $sort = 1; ?>
	<div id="wpwrap">
		<div id="wphead">
			<h1><a href="#">WordPress Hooks &amp; Filters Insight</a></h1>
		</div>
		
		<div id="wpbody">
			
			<p>WordPress Hooks in alphabetischer Reihenfolge und die jeweils angesprochene Funktionen.</p>
			
			<?php
			if ($sort)
				ksort($wp_filter);
			
			if ($dump) {
				echo '<pre>';
					var_dump($wp_filter);
				echo '</pre>';
			}
			
			
			//menu
			$wp_hook = 0;
			echo '<div class="menu">';
			echo '<ol>';
			foreach($wp_filter as $hook => $arrays) {
				if ($sort)
					ksort($arrays);
				$wp_hook ++;
				
				echo '<li title="zu Hook: ' . $hook . '"><a href="#hook_' . $wp_hook . '">' . $hook . '</a></li>'."\n";
			}
			echo '</ol>';
			echo '<h4>miniMenu <small>(' . $wp_hook . ')</small></h4>';
			echo '</div>';
			
			
			echo "\n\n" . '<ol>'."\n";
			$wp_hook = 0;
			$wp_func = 0;
			
			foreach($wp_filter as $hook => $arrays) {
				if ($sort)
					ksort($arrays);
				$wp_hook ++;
				
				echo '<li><h2 id="hook_' . $wp_hook . '" title="Hook: ' . $hook . '">' . $hook . '</h2>'."\n";
				echo '<ul id="li' . $wp_hook . '">'."\n";
				
				foreach($arrays as $priority => $subarray) {
					echo '<li>Priorit&auml;t <strong>' . $priority . '</strong> : '."\n";
					echo '<ol>'."\n";
					foreach($subarray as $sub) {
						$wp_func ++;
						
						echo '<li>';
						$func = $sub['function'];
						if ( is_array($func) ) {
							echo '<code><em>'.get_class($func[0]) . '-></em>' . $func[1] . '()</code>';
							echo "\n" . '<ul>'."\n";
							$x = 0;
							foreach ($func[0] as $k=>$v) {
								$x ++;
								if ( !is_string($v) ) {
									$v  = htmlentities( serialize($v) );
									$v  = '<a href="javascript:toggle(\'serialize_' . $wp_func.$x . '\');">Daten anzeigen</a><textarea style="display:none;" class="large-text code" id="serialize_' . $wp_func.$x . '"name="v" cols="50" rows="10">' . $v . '</textarea>';
								}
								echo '<li>' . $k . ' : ' . $v . '</li>'."\n";
							}
							echo '</ul>'."\n";
							
						} else {
							echo '<code>' . $func . '()</code>';
						}
						echo '</li>'."\n";
						
					}
					echo '</ol>'."\n";
					echo '</li>'."\n";
				}
				
				echo '</ul>'."\n";
				echo '</li>';
			}
			?>
			</ol>
		</div>
	</div>
	
	<div id="footer">
		<p>Hooks gesamt : <?php echo $wp_hook; ?><br />Registrierte filter/actions gesamt : <?php echo $wp_func; ?></p>
	</div>
	<?php if ( file_exists('./wp-includes/js/jquery/jquery123.js') )
	echo '<script type="text/javascript" src="'.get_bloginfo('siteurl') . '/wp-includes/js/jquery/jquery.js"></script>';
	?>
	<script type="text/javascript">
		function toggle(obj) {
			var el = document.getElementById(obj);
			if ( el.style.display != 'block' ) {
				el.style.display = 'block';
			}	else {
				el.style.display = 'none';
			}
		}
	</script>
</body>
</html>
