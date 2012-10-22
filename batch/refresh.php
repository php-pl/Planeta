<?php
set_time_limit(0);

define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'backend');
define('SF_ENVIRONMENT', 'prod');
define('SF_DEBUG',       false);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();

$blogs = BlogPeer::getApproved();

logmsg('Skrypt odswiezajacy');
logmsg('Feedow do sprawdzenia: %d', count($blogs));
logmsg(str_repeat('-', 80));

foreach ($blogs as $blog) {
    logmsg('Parsowanie feedu %s', $blog->getFeed());

    try {
        $items = FeedParser::parse($blog->getFeed());
        $ts = PostPeer::getNewestTimestamp($blog);

        logmsg('Najnowszy wpis (timestamp): %d', $ts);

        foreach ($items as $item) {
            if (!parseItem($blog, $item, $ts)) break;
        }
    } catch (Exception $e) {
        logmsg('Blad: %s', $e->getMessage());
    }
    
    logmsg(str_repeat('-', 80)."\n");
}

logmsg('Odswiezanie zakonczone.');

function parseItem($blog, $item, $ts) {
    if ($ts != 0 && $item->pubdate <= $ts) {
        logmsg('Zatrzymanie na wpisie: %s', StringUtils::removeAccents($item->title));
         
        return false;
    }
     
    logmsg('  - Parsowanie wpisu: %s', StringUtils::removeAccents($item->title));
     
    $post = new Post();
    $post->setBlog($blog);

    foreach ($item->tags as $name) {
        $tag = TagPeer::retriveByName($name, true);

        if ($post->addTag($tag)) {
            logmsg('    - Znaleziono tag: %s', $name);
        }
    }

    if ($post->hasTags()) {
        $shortened = $post->setFullContent($item->content);
         
        $post->setLink(htmlspecialchars($item->link));
        $post->setTitle($item->title);
        $post->setCreatedAt($item->pubdate);
        $post->setShortened($shortened);
        $post->save();
    } else {
        logmsg('    - Nie znaleziono tagow');
    }
     
    return true;
}

function logmsg($message) {
    if (is_array($message)) {
        print_r($message);
    } else {
        $args = func_get_args();
        $message = call_user_func_array('sprintf', $args);

        echo date('[d.m.Y H:i:s] ') . $message . "\n";
        flush();
    }
}

