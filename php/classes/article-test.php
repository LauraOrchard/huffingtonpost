<?

// First: require the AES 256 function - programmatically includes the readConfig file
require_once("/etc/apache2/data-design/encrypted-config.php");

// Second, require the class being tested - Article in this case
require_once("article.php");

// Do not reconfig up here, but in the try block)

try {
	// read and decrypt the configuration array
	$config = readConfig("/etc/apache2/data-design/lorchard.ini");

	// create a data connection string (DSN & specify the username and password
	$dsn = "mysql:host=" . $config["hostname"] . ";dbname=" . $config["database"];

	// enable UT-8 (Unicode) text handling
	$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");

	// connect to mySQL via PDO - this is the user input from the user
	$pdo = new PDO($dsn, $config["username"], $config["password"], $options);

	//have PDO throw exceptions whenever possible
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	// = = = = = above is all the boiler plate system configuration code to encrypt a file - below  = = = =

	// insert a new Article into mySQL
	$article = new Article(1, "Everything", "Four score and seven years ago...", "2015-12-23 12:22:24");
	$article->insert($pdo);

	// change an Article and update it in mySQL
	$article->setArticleContent("Four score and 200 years ago...");
	$article->update($pdo);

	//select an Article from my mySQL
	$pdoArticle = Article::getArticleByArticleId($pdo, $article->getArticleId());

	// delete the Article from mySQL and show that it is gone
	$article->delete($pdo);
	$pdoArticle = Article::getArticleByArticleId($pdo, $article->getArticleId());

} catch (PDOException $pdoException) {
	echo "Exception: " . $pdoException->getMessage();
}
?>