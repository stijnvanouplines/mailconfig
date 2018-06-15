<?php

error_reporting(0);
ini_set('display_errors', 0);

require __DIR__ . '/../vendor/autoload.php';

// Don't cache this page
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Thu, 1 Jan 1970 00:00:00 GMT");

$config = require __DIR__ . '/../config.php';

$mail = new MailConfig($config);
$lang = new Localization($config['language_dir'], $config['fallback_locale']);

if ($mail->determineTemplate('mobileconfig') == 'mobileconfig') {
    if (! $mail->extractEmailFromUrl()
        && $_SERVER['REQUEST_METHOD'] !== 'POST'
        && ! isset($_POST['submit'])
    ) {
        die(require __DIR__ . '/../views/mobileconfig.php');
    } else {
        header ("Content-Type: application/x-apple-aspen-config; chatset=utf-8");
        header ("Content-Disposition: attachment; filename='{$mail->getMobileconfigFilename()}'");
    }
} else {
    header ("Content-Type: text/xml");
}

echo $mail->loadTemplate();
