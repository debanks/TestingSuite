<?php

$url = 'http://www.reddit.com/r/all.xml?limit=50';
$xml = simplexml_load_file($url);
if ($xml) {
    $status[0] = 2;
    $title = (string) $xml->channel->title;
    $description = (string) $xml->channel->description;
    foreach ($xml->channel->item as $item) {
        $vars['name'] = (string) $item->title;
        $vars['link'] = (string) $item->link;
        $vars['description'] = (string) $item->description;
        $vars['thread'] = $thread->id;
        $threads[] = $vars;
    }
    if (count($threads) == 50) {
        $status[1] = 2;
    } elseif (count($threads) > 0) {
        $status[1] = 1;
    } else {
        $status[1] = 0;
    }
    if ($title == 'all subreddits') {
        $status[2] = 2;
    } elseif ($title && $title != '') {
        $status[2] = 1;
    } else {
        $status[2] = 0;
    }
    if (!$description || $description == '') {
        $status[3] = 2;
    } else {
        $status[3] = 1;
    }
} else {
    $status[0] = 0;
}

$return = '<?xml version="1.0" encoding="UTF-8"?>';
$return .= '<result>';
$overall = 3;
foreach ($status as $num) {
    if ($num < $overall) {
        $overall = $num;
    }
}
$return .= '<status>' . $overall . '</status>';
$return .= '<tests>';
$return .= '<test status="'.$overall.'">';
$return .= '<title>Test All Reddits XML</title>';
$return .= '<description>Checks the reddit API on the All Subreddit and makes sure it matches what I expect.</description>';
$return .= '<url>' . $url . '</url>';
if ($status[0] == 0) {
    $return .= '<error>XML did not return</error>';
} else {
    $return .= '<table>';
    $return .= '<row>';

    if ($status[1] == 2)
        $return .= '<cell status="2">Had 50 Threads</cell>';
    elseif ($status[1] == 1)
        $return .= '<cell status="1">Did not have expected number of Threads</cell>';
    else
        $return .= '<cell status="0">Did not have Threads</cell>';

    if ($status[1] == 2)
        $return .= '<cell status="2">Title was as Expected</cell>';
    elseif ($status[1] == 1)
        $return .= '<cell status="1">Not the Expected Title</cell>';
    else
        $return .= '<cell status="0">No Title</cell>';

    if ($status[1] == 2)
        $return .= '<cell status="2">Had Expected Description</cell>';
    elseif ($status[1] == 1)
        $return .= '<cell status="1">Did not have expected Description</cell>';

    $return .= '</row>';
    $return .= '</table>';
}
$return .= '</test>';
$return .= '</tests>';
$return .= '</result>';

$file = fopen('redditTest.xml','w');
fwrite($file, $return);
fclose($file);
?>
