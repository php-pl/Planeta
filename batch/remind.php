<?php
set_time_limit(0);

define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'backend');
define('SF_ENVIRONMENT', 'prod');
define('SF_DEBUG',       false);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();

$c = new Criteria();
$c->add(BlogPeer::VERIFIED, true);
$c->add(BlogPeer::APPROVED, false);

$blogs = BlogPeer::doSelect($c);

if (empty($blogs)) return;

$mail = new sfMail();
$mail->initialize();
$mail->setMailer('sendmail');
$mail->setCharset('utf-8');
$mail->setSubject('Lista blogów do zatwierdzenia');
$mail->setSender('poczta@planeta.php.pl', 'Planeta PHP.pl');
$mail->setFrom('poczta@planeta.php.pl', 'Planeta PHP.pl');

$admins = AdminPeer::doSelect(new Criteria());

foreach ($admins as $admin) {
    $mail->addAddress($admin->getEmail());
}

$body = "Oto lista blogów, które pozostały do zawierdzenia:\n";

foreach ($blogs as $blog) {
    $body .= " - {$blog->getName()} ({$blog->getUrl()})\n";
}

$body .= "\nPanel administracyjny: http://planeta.php.pl/backend.php";

$mail->setBody($body);
$mail->send();
