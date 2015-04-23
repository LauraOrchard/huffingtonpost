<?php
// encryption
require_once("/etc/apache2/data-design/encrypted-config.php");


// use the constructor to create a new Article
require_once("article.php");
$article = new Article(1, "Everything", "Four score and seven years ago...", "12-23-2014");
$config=readConfig("/etc/apache2/data-design/lorchard.ini");
?>