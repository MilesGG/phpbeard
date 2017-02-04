<?php
/**
 * Setup part
 *
 */
$DOMAIN_NAME = 'https://urduru.com/phpbeard/';
$FEED_URL = $DOMAIN_NAME . 'rss/full.php';
$SITE_TITLE = 'PHPbeard';
$SITE_DESRIPTION = 'Combined rss!';
$SITE_AUTHOR = 'theatomickiwi';

$RSS_CACHE = "/tmp/rsscache";
$RSS_CACHE_EXP = 7200;

$FEED_LIST = array(
	'http://rss.slashdot.org/Slashdot/slashdotMain',
	'http://motherboard.vice.com/rss?trk_source=motherboard',
  'http://feeds.feedburner.com/TechCrunch?fmt=xml',
  'http://feeds.arstechnica.com/arstechnica/technology-lab',
  'https://hackaday.com/blog/feed/',
);


/**
 * Do not modify below this point
 *
 */
define('MAGPIE_CACHE_ON', true);
define('MAGPIE_CACHE_DIR', $RSS_CACHE);
define('MAGPIE_CACHE_AGE', $RSS_CACHE_EXP);
define('MAGPIE_OUTPUT_ENCODING', 'utf-8');


// include required files
require_once ('magpierss-0.72/rss_fetch.inc');
include ('feedcreator-1.7.2-ppt/include/feedcreator.class.php');

/* Set RSS properties */
$rss = new UniversalFeedCreator();
$rss->useCached();
$rss->title = $SITE_TITLE;
$rss->description = $SITE_DESRIPTION;
$rss->link = $DOMAIN_NAME;
$rss->syndicationURL = $FEED_URL;
$rss->encoding = 'utf8';

/* Set Image properties
$image = new FeedImage();
$image->title = $SITE_TITLE . " Logo";
$image->url = $SITE_LOG_URL;
$image->link = $DOMAIN_NAME;
$image->description = "Feed provided by " . $SITE_TITLE . ". Click to visit.";
$rss->image = $image;
*/

function showSummary($url, $num = 10, $showfullfeed = false) {
	global $rss, $DOMAIN_NAME, $SITE_AUTHOR, $SITE_TITLE;
	$num_items = $num;
	@ $rss1 = fetch_rss($url);
	if ($rss1) {
		$items = array_slice($rss1->items, 0, $num_items);
		foreach ($items as $item) {
			$href = $item['link'];
			$title = $item['title'];
			if (!$showfullfeed) {
				$desc = $item['description'];
			} else {
				$desc = $item['content']['encoded'];
			}
			//                $desc .=  '
			//Copyright &copy; <a href="'.$DOMAIN_NAME.'">'.$SITE_TITLE.'</a>.  All Rights Reserved.
			//';
			$pdate = $item['pubdate'];
			$rss_item = new FeedItem();
			$rss_item->title = $item['title'];
			$rss_item->link = $item['link'];
			$rss_item->date = $item['pubdate'];
			$rss_item->source = $DOMAIN_NAME;
			$rss_item->author = $SITE_AUTHOR;
			$rss->addItem($rss_item);
		}

	} else {
		echo "Error: Cannot fetch feed url - " . $url;
	}
}

// Fetch all feeds
foreach($FEED_LIST as $v) showSummary($v);

// Sort items by date
function __usort($ad, $bd) {return strtotime($bd->date) - strtotime($ad->date);}
usort($rss->items, '__usort');

// Display items
$rss->saveFeed("RSS1.0", $RSS_CACHE . "/feed.xml");
