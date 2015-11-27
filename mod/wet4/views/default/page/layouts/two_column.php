<?php
/**
 * Elgg one-column layout
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['content'] Content string
 * @uses $vars['class']   Additional class to apply to layout
 * @uses $vars['nav']     Optional override of the page nav (default: breadcrumbs)
 * @uses $vars['title']   Optional title for main content area
 * @uses $vars['header']  Optional override for the header
 * @uses $vars['footer']  Optional footer
 */

$class = 'elgg-layout elgg-layout-one-column clearfix';
if (isset($vars['class'])) {
	$class = "$class {$vars['class']}";
}

?>
<div class="<?php echo $class; ?>">
	<div class="elgg-main">
	<?php

		//echo elgg_extract('nav', $vars, elgg_view('navigation/breadcrumbs'));
echo $vars['title'];
		//echo elgg_view('page/layouts/elements/header', $vars);
echo '<div class="col-md-6">';
		echo $vars['content'];
echo '</div>';
echo '<div class="col-md-6">';
        echo $vars['sidebar'];
echo '</div>';
		
		// @deprecated 1.8
		if (isset($vars['area1'])) {
			echo $vars['area1'];
		}

		echo elgg_view('page/layouts/elements/footer', $vars);
	?>
	</div>
</div>