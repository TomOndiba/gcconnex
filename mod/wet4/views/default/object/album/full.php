<?php
/**
 * Full view of an album
 *
 * @uses $vars['entity'] TidypicsAlbum
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

$album = elgg_extract('entity', $vars);
$owner = $album->getOwnerEntity();

$owner_icon = elgg_view_entity_icon($owner, 'medium');

$metadata = elgg_view_menu('entity', array(
	'entity' => $album,
	'handler' => 'photos',
	'sort_by' => 'priority',
	'class' => 'list-inline',
));

$owner_link = elgg_view('output/url', array(
	'href' => "photos/owner/$owner->username",
	'text' => $owner->name,
	'is_trusted' => true,
));
$author_text = elgg_echo('byline', array($owner_link));
$date = elgg_view_friendly_time($album->time_created);
$categories = elgg_view('output/categories', $vars);

$subtitle = "$author_text $date $categories";

$params = array(
	'entity' => $album,
	'title' => false,
	'metadata' => $metadata,
	'subtitle' => $subtitle,
	'tags' => elgg_view('output/tags', array('tags' => $album->tags)),
);
$params = $params + $vars;
$summary = elgg_view('object/elements/summary', $params);

$body = '';
if ($album->description) {
	$body = elgg_view('output/longtext', array(
		'value' => $album->description,
		'class' => 'mbm mrgn-bttm-lg',
	));
}

$body .= $album->viewImages();

if (elgg_get_plugin_setting('album_comments', 'tidypics')) {
	//$body .= elgg_view_comments($album);
}

echo elgg_view('object/elements/full', array(
	'entity' => $album,
	'icon' => $owner_icon,
	'summary' => $summary,
	'body' => $body,
));
