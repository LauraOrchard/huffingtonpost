<?php
/** slave code from the date utility file
 * special php constant _ _ DIR _ _ gives exact path of where the directory of where the file lives on the disk
 **/
require_once(dirname(__DIR__) . "/lib/date-utils.php");
/**
 * Example of Articles entity for the Huffington Post
 *
 * This Articles entity is an example of data collected and stored about an article written to
 * post on the Huffington Post website for reader access.
 *
 * @author Laura Orchard <lorchard@cnm.edu>
 **/

class Article {

	/**
	 * id for this Article; this is the primary key
	 **/
	public $articleId;
	/**
	 * title for this article
	 **/
	public $articleTitle;
	/**
	 * content for this article
	 **/
	public $articleContent;
	/**
	 * date for this article
	 **/
	public $articleDate;


	/**
	 * constructor for this Article class
	 *
	 * @param int $newArticleId new article ID
	 * @param string $newArticleTitle
	 * @param string $newArticleContent
	 * @param int $newArticleDate
	 * @throws InvalidArgumentException if data types are not valid
	 * @throws RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 **/

	public function __construct($newArticleId, $newArticleTitle, $newArticleContent, $newArticleDate = null) {
		try {
			$this->setArticleId($newArticleId);
			$this->setArticleTitle($newArticleTitle);
			$this->setArticleContent($newArticleContent);
			$this->setArticleDate($newArticleDate);
		} catch(InvalidArgumentException $invalidArgument) {
			// rethrow the exception to the caller
			throw(new InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(RangeException $range) {
			// rethrow the exception to the caller
			throw(new RangeException($range->getMessage(), 0, $range));
		}
	}


	/**
	 * (A) accessor method for article id state variable
	 *
	 * @return int value of article id
	 **/
	public function getArticleId() {
		return ($this->articleId);
	}

	/**
	 * (B) mutator method for article id state variable
	 *
	 * @param int $newArticleId new value of article id
	 * @throws InvalidArgumentException if $newArticleId is not an integer
	 * @throws RangeException if $newArticleId is not positive
	 **/

	public function setArticleId($newArticleId) {
		// if the article id is null, this a new article without a mySQL assigned id (gets temp placeholder ID)
		if($newArticleId === null) {
			$this->articleId = null;
			return;
		}
		// verify that the Article ID is valid
		$newArticleId = filter_var($newArticleId, FILTER_VALIDATE_INT);
		if($newArticleId === false) {
			throw(new InvalidArgumentException("Article ID is not a valid integer!"));
		}
		// verify the article id is positive
		if($newArticleId <= 0) {
			throw(new RangeException("Article ID is not positive!"));
		}
		// (#6) convert and store the article id
		$this->articleId = intval($newArticleId);
	}

	/**
	 * rinse and repeat A, B, C for the remaining 3 state variables
	 **/

	/**
	 * (A)accessor method for article title
	 *
	 * @return string value of article title
	 **/
	public function getArticleTitle() {
		return ($this->articleTitle);
	}

	/** (B) mutator method for article title state variable
	 *
	 * @param string $newArticleTitle new value of article title
	 * @throws InvalidArgumentException if $newArticleTitle is not a valid string or insecure
	 * @throws InvalidRangeException if $newArticleTitle is > 150 characters
	 **/

	public function setArticleTitle($newArticleTitle) {
		// verify the article title is secure
		$newArticleTitle = trim($newArticleTitle);
		$newArticleTitle = filter_var($newArticleTitle, FILTER_SANITIZE_STRING);
		if(empty($newArticleTitle) === true) {
			throw(new InvalidArgumentException("Article Title is empty or insecure"));
		}

		// verify the article title will fit in the database
		if(strlen($newArticleTitle) > 150) {
			throw(new RangeException("Article Title too large!"));
		}
		// (C) store the article title in the database
		$this->articleTitle = $newArticleTitle;
	}

	/**
	 * (A) accessor method for article content state variable
	 *
	 * @return string value of article content
	 **/
	public function getArticleContent() {
		return ($this->articleContent);
	}

	/**
	 * (B) mutator method for article content state variable
	 *
	 * @param string $newArticleContent new value of article content
	 * @throws InvalidArgumentException if $newArticleContent is not a valid string or insecure
	 * @throws InvalidRangeException if $newArticleContent is > MEDIUMBLOB restrictions
	 **/

	public function setArticleContent($newArticleContent) {
		//verify the article content is secure
		$newArticleContent = trim($newArticleContent);
		$newArticleContent = filter_var($newArticleContent, FILTER_SANITIZE_STRING);
		if(empty($newArticleContent) === true) {
			throw(new InvalidArgumentException("Article content is empty or insecure"));
		}

		//verify the article content will fit in the database
		if(strlen($newArticleContent) > 16777215) {
			throw(new RangeException("Article content is too large!"));
		}
		//(C) store the article content in the database
		$this->articleContent = $newArticleContent;
	}

	/**
	 * (A) accessor method for article date state variable
	 *
	 * @return int value of submission date
	 **/
	public function getArticleDate() {
		return ($this->articleDate);
	}

	/**
	 * (B) mutator method for article date state variable
	 *
	 * @param mixed $newArticleDate new value of article date as a DateTime object (or null to load the current date/time)
	 * @throws InvalidArgumentException if $newArticleDate is not a valid object
	 * @throws RangeException if $newArticleDate is a date that does not exist
	 **/
	public function setArticleDate($newArticleDate) {
		// if the date is null, use the current date and time
		if($newArticleDate === null) {
			$this->articleDate = new DateTime();
			return;
		}

		// (C) convert and store the article date
		try {
			$newArticleDate = validateDate($newArticleDate);
		} catch(InvalidArgumentException $invalidArgument) {
			throw(new InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		}
		$this->articleDate = $newArticleDate;
	}

	/**
	 * toString() magic method
	 *
	 * @return string HTML formatted article
	 **/

	public function __toString() {
// create an HTML formatted article
		$html = "<p>Article ID: " . $this->articleId . "<br />"
			. "Article Title: " . $this->articleTitle . "<br />"
			. "Article Content: " . $this->articleContent . "<br />"
			. "Article Date: " . $this->articleDate . "<br />"
			. "</p>";
		return ($html);
	}


	/**
	 * inserts this Article into mySQL
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @throws PDOException when mySQL related errors occur
	 **/
	public function insert(PDO &$pdo) {
// enforce the articleId is null (i.e., don't insert an article that already exists)
		if($this->articleId !== null) {
			throw(new PDOException("not a new article"));
		}

// create query template
		$query = "INSERT INTO article(articleId, articleTitle, articleContent, articleDate) VALUES(:articleId, :articleTitle, :articleContent, :articleDate)";
		$statement = $pdo->prepare($query);

// bind the member variables to the place holders in the template
		$formattedDate = $this->articleDate->format("Y-m-d H:i:s");
		$parameters = array("articleId" => $this->articleId, "articleTitle" => $this->articleTitle, "articleContent" => $this->articleContent, "articleDate" => $formattedDate);
		$statement->execute($parameters);

// update the null articleId with what mySQL just gave us
		$this->articleId = intval($pdo->lastInsertId());
	}


	/**
	 * deletes this Article from mySQL
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @throws PDOException when mySQL related errors occur
	 **/
	public function delete(PDO &$pdo) {
		// enforce the articleId is not null (i.e., don't delete an article that hasn't been inserted)
		if($this->articleId === null) {
			throw(new PDOException("unable to delete an article that does not exist"));
		}

		// create query template
		$query = "DELETE FROM article WHERE articleId = :articleId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = array("articleId" => $this->articleId);
		$statement->execute($parameters);
	}

	/**
	 * updates this Article in mySQL
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @throws PDOException when mySQL related errors occur
	 **/
	public function update(PDO &$pdo) {
		// enforce the articleId is not null (i.e., don't update an article that hasn't been inserted)
		if($this->articleId === null) {
			throw(new PDOException("unable to update an article that does not exist"));
		}

		// create query template
		$query = "UPDATE article SET articleId = :articleId, articleTitle = :articleTitle, articleContent = :articleContent, articleDate = :articleDate WHERE articleId = :articleId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$formattedDate = $this->articleDate->format("Y-m-d H:i:s");
		$parameters = array("articleId" => $this->articleId, "articleTitle" => $this->articleTitle, "articleContent" => $this->articleContent, "articleDate" => $formattedDate);
		$statement->execute($parameters);
	}

	/**
	 * gets the Article by ArticleId
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param int $articleId article id to search for
	 * @return mixed Article found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getArticleByArticleId(PDO &$pdo, $articleId) {
		// sanitize the articleId before searching
		$articleId = filter_var($articleId, FILTER_VALIDATE_INT);
		if($articleId === false) {
			throw(new PDOException("article id is not an integer"));
		}
		if($articleId <= 0) {
			throw(new PDOException("article id is not positive"));
		}

		// create query template
		$query = "SELECT articleId, articleTitle, articleContent, articleDate FROM article WHERE articleId = :articleId";
		$statement = $pdo->prepare($query);

		// bind the article id to the place holder in the template
		$parameters = array("articleId" => $articleId);
		$statement->execute($parameters);

		// grab the article from mySQL
		try {
			$article = null;
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$article = new Article($row["articleId"], $row["articleTitle"], $row["articleContent"], $row["articleDate"]);
			}
		} catch(Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}
		return ($article);
	}


	/**
	 * gets the Article by content
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param string $articleContent article content to search for
	 * @return mixed SplFixedArray of Articles found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getArticleByArticleContent(PDO &$pdo, $articleContent) {
		// sanitize the description before searching
		$articleContent = trim($articleContent);
		$articleContent = filter_var($articleContent, FILTER_SANITIZE_STRING);
		if(empty($articleContent) === true) {
			throw(new PDOException("article content is invalid"));
		}

		// create query template
		$query = "SELECT articleId, articleTitle, articleContent, articleDate FROM article WHERE articleContent LIKE :articleContent";
		$statement = $pdo->prepare($query);

		// bind the article content to the place holder in the template
		$articleContent = "%$articleContent%";
		$parameters = array("articleContent" => $articleContent);
		$statement->execute($parameters);

		// build an array of article
		$articles = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$article = new Article($row["articleId"], $row["articleTitle"], $row["articleContent"], $row["articleDate"]);
				$articles[$articles->key()] = $article;
				$articles->next();
			} catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}
		}

		// count the results in the array and return:
		// 1) null if 0 results
		// 2) the entire array if >= 1 result
		$numberOfArticles = count($articles);
		if($numberOfArticles === 0) {
			return (null);
		} else {
			return ($articles);
		}
	}
}

