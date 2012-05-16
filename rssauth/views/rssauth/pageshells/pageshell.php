<?php
/**
 * Elgg RSS output pageshell
 *
 * @package Elgg
 * @subpackage Core
 *
 */

header("Content-Type: text/xml");

// allow caching as required by stupid MS products for https feeds.
header('Pragma: public', TRUE);

echo "<?xml version='1.0'?>\n";

// Set title
if (empty($vars['title'])) {
	$title = $vars['config']->sitename;
} else if (empty($vars['config']->sitename)) {
	$title = $vars['title'];
} else {
	$title = $vars['config']->sitename . ": " . $vars['title'];
}

// Remove RSS from URL
$url = str_replace('?view=rssauth','', full_url());
$url = str_replace('&view=rssauth','', $url);
$url = str_replace('?username=' . $_GET['username'],'', $url);
$url = str_replace('&username=' . $_GET['username'],'', $url);
$url = str_replace('?password=' . $_GET['password'],'', $url);
$url = str_replace('&password=' . $_GET['password'],'', $url);

?>

<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:georss="http://www.georss.org/georss" <?php echo elgg_view('extensions/xmlns'); ?> >
<channel>
	<title><![CDATA[<?php echo $title; ?>]]></title>
	<link><?php echo htmlentities($url); ?></link>
	<?php
		// where is this view?  adds <description /> in regular rss
		$extensions = elgg_view('extensions/channel');
		if(!empty($extensions)){
			echo $extensions;
		}
		else{
			echo '<description />';
		}
	?>

	<?php
		echo $vars['body'];

	?>
</channel>
</rss>
