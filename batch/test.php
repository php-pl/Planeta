<?php
// laczymy sie ze stara baza...
mysql_connect('localhost', '', '');
mysql_select_db('planeta_old');
mysql_query('SET NAMES latin2');


// posty
$result = mysql_query('SELECT * FROM entries ORDER BY id DESC LIMIT 1');

$entry = mysql_fetch_array($result, MYSQL_ASSOC);
$entry['content'] = mysql_real_escape_string($entry['content']);

file_put_contents('test.txt', "\n" . $entry['content']);
