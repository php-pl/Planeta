<?php
// laczymy sie ze stara baza...
mysql_connect('localhost', '', '');
mysql_select_db('planeta_old');
mysql_query('SET NAMES latin2');

// blogi
$result = mysql_query('SELECT * FROM feeds');

$contents = "TRUNCATE TABLE blog;\n";

while ($feed = mysql_fetch_array($result, MYSQL_ASSOC)) {
    $feed['name'] = mysql_real_escape_string(html_entity_decode($feed['name'], ENT_QUOTES));
    $feed['author'] = mysql_real_escape_string(html_entity_decode($feed['author'], ENT_QUOTES));

    $contents .= "INSERT INTO blog VALUES({$feed['id']}, null, '{$feed['name']}', '{$feed['blog_url']}', '{$feed['feed_url']}', '{$feed['author']}', null, null, 0, {$feed['approved']});\n";
}

// tagi
$result = mysql_query('SELECT * FROM tags');

$contents .= "\nTRUNCATE TABLE tag;\n";

while ($tag = mysql_fetch_array($result, MYSQL_ASSOC)) {
    $contents .= "INSERT INTO tag VALUES({$tag['id']}, '{$tag['name']}', 1);\n";
}

// posty
$result = mysql_query('SELECT * FROM entries ORDER BY id ASC');

$contents .= "\nTRUNCATE TABLE post;\n";

while ($entry = mysql_fetch_array($result, MYSQL_ASSOC)) {
    $entry['title'] = mysql_real_escape_string(html_entity_decode($entry['title'], ENT_QUOTES));
    
    echo strlen($entry['content']);
    
    $entry['content'] = mysql_real_escape_string(html_entity_decode($entry['content'], ENT_QUOTES));
    $entry['content_rest'] = mysql_real_escape_string(html_entity_decode($entry['content_rest'], ENT_QUOTES));
    
    echo ' - ' .strlen($entry['content']) . "\n";
    
    $y = date('Y', strtotime($entry['pubdate']));
    $m = date('n', strtotime($entry['pubdate']));
    
    $contents .= "INSERT INTO post VALUES({$entry['id']}, {$entry['feed_id']}, '{$entry['pubdate']}', '$y', '$m', '{$entry['title']}', '{$entry['link']}', '{$entry['content']}', '{$entry['content_rest']}', {$entry['shortened']}, {$entry['deleted']});\n";
}

// relacja post - tag
$result = mysql_query('SELECT * FROM entry2tag');

$contents .= "\nTRUNCATE TABLE post_tag;\n";

while ($e2t = mysql_fetch_array($result, MYSQL_ASSOC)) {
    $contents .= "INSERT INTO post_tag VALUES(null, {$e2t['entry_id']}, {$e2t['tag_id']});\n";
}

// i do pliku z tym...
file_put_contents('import.sql', $contents);
