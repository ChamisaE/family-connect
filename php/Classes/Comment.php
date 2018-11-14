<?php
/**
 * Created by PhpStorm.
 * User: felizmunoz
 * Date: 11/5/18
 * Time: 10:47 AM
 */

namespace FamConn\FamilyConnect;
require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");
use Ramsey\Uuid\Uuid;

/**
 * This is the comment section of Family Connect
 * comments can come from all users in a group
 *
 * @author Feliz Munoz <fmunoz11@cnm.edu>
 * @version 3.0.0
 */

class Comment {
	use ValidateUuid;
	use ValidateDate;
	/**
	 * id for comment; this is the primary key
	 * @var Uuid $commentId
	 **/
	private $commentId;
	/**
	 * id of the event that the comment belongs to
	 * @var Uuid $commentEventId
	 **/
	private $commentEventId;
	/**
	 * id of the task that the comment belongs to
	 * @var Uuid $commentTaskId
	 **/
	private $commentTaskId;
	/**
	 * id of the user that the comment belongs to
	 * @var Uuid $commentUserId
	 **/
	private $commentUserId;
	/**
	 * actual textual content that the the Comment will contain and be posted with the group
	 * @var string $commentContent
	 **/
	private $commentContent;
	/**
	 * actual time that the comment was posted
	 * @var \DateTime $commentDate
	 **/
	private $commentDate;

	/**
	 * constructor for Comment
	 *
	 * @param string|null|Uuid $newCommentId id of the comment or null if new Comment
	 * @param string|null|Uuid $newCommentEventId of the event that the comment is associated with
	 * @param string|null|Uuid $newCommentTaskId of the task that the comment is assiciated with
	 * @param string|null|Uuid $newCommentUserId of the user that the comment s associated with
	 * @param string $newCommentContent string containing actual comment content posted
	 * @param string $newCommentDate string with actual date and time when comment is posted
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 */
	public function __construct($newCommentId, $newCommentEventId = null, $newCommentTaskId = null, $newCommentUserId, $newCommentContent, $newCommentDate = null) {
		try {
			$this->setCommentId($newCommentId);
			$this->setCommentEventId($newCommentEventId);
			$this->setCommentTaskId($newCommentTaskId);
			$this->setCommentUserId($newCommentUserId);
			$this->setCommentContent($newCommentContent);
			$this->setCommentDate($newCommentDate);
		} //determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \TypeError $exception){
		$exceptionType = get_class($exception);
		throw(new $exceptionType($exception->getMessage(), 0, $exception));
	}
}

/**
 * accessor method for comment id
 *
 * @return Uuid value of comment id
 */
public function getCommentId() : Uuid {
 return ($this->commentId);

	//this outside of class
	//$comment-getCommentId();
}

/**
 * mutator method for comment id
 *
 * @param Uuid|string $newCommentId new value of comment id
 * @throws \RangeException if #newCommentId is not positive
 * @throws \TypeError if $newCommentId is not a uuid or string
 **/
public function setCommentId( $newCommentId) : void {
	try {
		$uuid = self::ValidateUuid($newCommentId);
	} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
		$exceptionType = get_class($exception);
		throw(new $exceptionType($exception->getMessage(), 0, $exception));
	}
	$this->commentId = $uuid;

	// convert and store the comment id
	//$this->commentId = $newCommentId;
}

/**
 * accessor method for comment event id
 *
 * @return Uuid values of comment event id
 **/
public function getCommentEventId() : ?Uuid{
	return($this->commentEventId);
}

/**
 * mutator method for comment event id
 *
 * @param | Uuid $newCommentEventId new value of comment event id
 * @throws \RangeException if $newCommentEventId is not positive
 * @throws \ TypeError if $newCommentEventId is not an integer
 **/
public function setCommentEventId( $newCommentEventId =null) : void {
	if($newCommentEventId === null) {
		$this->commentEventId=null;
	}
	try {
		$uuid = self::validateUuid($newCommentEventId);
	}	catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
		$exceptionType = get_class($exception);
		throw(new $exceptionType($exception->getMessage(), 0, $exception));
	}
	// convert and store the comment event id
	$this->commentEventId = $uuid;
}
//TODO make accessor/mutator for commentTaskId nullable commentEventId can be used for reference(done)
	/**
	 * accessor method for comment task id
	 *
	 * @return Uuid values of comment task id
	 **/
	public function getCommenTaskId() : ?Uuid{
		return($this->commentTaskId);
	}

	/**
	 * mutator method for comment task id
	 *
	 * @param | Uuid $newCommentTaskId new value of comment task id
	 * @throws \RangeException if $newCommentTaskId is not positive
	 * @throws \ TypeError if $newCommentTaskId is not an integer
	 **/
	public function setCommentTaskId( $newCommentTaskId =null) : void {
		if($newCommentTaskId === null) {
			$this->commentTaskId=null;
		}
		try {
			$uuid = self::validateUuid($newCommentTaskId);
		}	catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the comment task id
		$this->commentTaskId = $uuid;
	}

/**
 * accessor method for comment user id
 *
 * @return Uuid value of comment user id
 **/
public function getCommentUserId() : Uuid {
	return($this->commentUserId);
}

/**
 * mutator method for comment user id
 *
 * @param | Uuid $newCommentUserId new value of comment user id
 * @throws \RangeException if $newCommentUserId is not positive
 * @throws \TypeError if $newCommentUserId is not an integer
 **/
public function setCommentUserId( $newCommentUserId) : void {
	try{
		$uuid = self::validateUuid($newCommentUserId);
	} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
		$exceptionType = get_class($exception);
		throw(new $exceptionType($exception->getMessage(), 0, $exception));
	}
	// convert and store the comment user id
	$this->commentUserId = $uuid;
}

/**
 * accessor method for comment content
 *
 * @return string value of comment content
 **/
public function getCommentContent() : string {
	return($this->commentContent);
}

/**
 * mutator method for comment content
 *
 * @param string $newCommentContent new value of comment content
 * @throws \InvalidArgumentException if $newCommentContent is not a string or insecure
 * @throws \RangeException if $newComentContent is >855 characters
 * @throws \TypeError if $newcommentContent is not a string
 **/
public function setCommentContent(string $newCommentContent) : void {
	// verify the comment content is secure
	$newCommentContent = trim($newCommentContent);
	$newCommentContent = filter_var($newCommentContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	if(empty($newCommentContent) === true) {
		throw(new \InvalidArgumentException("comment content is empty or insecure"));
	}
	//verify the comment content will fit in the database
	if(strlen($newCommentContent) >=855) {
		throw(new \RangeException("comment content too large"));
	}

	//store the comment content
	$this->commentContent = $newCommentContent;
}

/**
 * accessor method for comment date
 *
 * @return \DateTime value of comment date
 */
public function getCommentDate(): \DateTime {
	return($this->commentDate);
    }
/**
 * mutator method for comment date
 *
 * @param \DateTime|string|null $newCommentDate comment Date as a DateTime object or string (or null to load current time)
 * @throws \InvalidArgumentException if $newCommentDate is not a valid object or string
 * @throws \RangeException if $newCommentDate is a date that does not exist
 * @throws \Exception
 **/
public function setCommentDate($newCommentDate = null) : void {
	if($newCommentDate === null) {
		$this->commentDate = new \DateTime();
		return;
	}

	try {
		$newCommentDate = self::validateDate($newCommentDate);
	} catch(\InvalidArgumentException | \RangeException $exception) {
		$exceptionType = get_class($exception);
		throw(new $exceptionType($exception->getMessage(), 0, $exception));
	}
	$this->commentDate = $newCommentDate;
	}

public function insert(\PDO $pdo) : void {

	//TODO format commentDate to mySql specifications
	// create query template
	$query = "INSERT INTO comment(commentId, commentEventId, commentTaskId, commentUserId, commentContent, commentDate) VALUES(:commentId, :commentEventId, :commentTaskId, :commentUserId, :commentContent, :commentDate)";
	$statement = $pdo->prepare($query);

	$formattedDate = $this->commentDate->format("Y-m-d H:i:s.u");
	$parameters = ["commentId" =>$this->commentId->getBytes(), "commentEventId" => $this->commentEventId->getBytes(), "commentTaskId" => $this->commentTaskId->getBytes(), "commentUserId" => $this->commentUserId->getBytes(), "commentContent" => $this->commentContent, "commentDate" => $formattedDate];
	$statement->execute($parameters);
}

/**
 * deletes this Comment from mySQL
 *
 * @param \PDO $pdo PDO connection object
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError if $pdo is not a PDO connection object
 **/
public function delete(\PDO $pdo) : void {
	// create query template
	$query = "DELETE FROM comment WHERE commentId = :commentId";
	$statement = $pdo->prepare($query);

	// bind the member variables to the place holder in the template
	$parameters = ["commentId" => $this->commentId->getBytes()];
	$statement->execute($parameters);
}

/**
 * updates this Comment in mySQL
 *
 * @param \PDO $pdo PDO connection object
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError if $pdo is not a PDO connection object
 **/
public function update(\PDO $pdo) : void {
	// create query template
	$query = "UPDATE comment SET commentId = :commentId, commentEventId = :commentEventId, commentTaskId = :commentTaskId, commentUserId = :commentUserId, commentContent = :commentContent, commentDate = :commentDate WHERE commentId = :commentId";
	//TODO create parameters for date and format date to mysql specifications
	$statement = $pdo->prepare($query);

	$formattedDate = $this->commentDate->format("Y-m-d H:i:s.u");
	$parameters = ["commentId" =>$this->commentId, "commentEventId" => $this->commentEventId, "commentTaskId" => $this->commentTaskId, "commentUserId" => $this->commentUserId, "commentContent" => $this->commentContent, "commentDate" => $formattedDate];
	$statement->execute($parameters);
}

/**
* gets the comment by commentId
*
* @param \PDO $pdo PDO connection object
* @param Uuid|string $commentId comment id to search for
* @return Comment|null Comment found or null if not found
* @throws \PDOException when mySQL related errors occur
* @throws \TypeError when a variable are not the correct data type
**/
public static function getCommentByCommentId(\PDO $pdo, $commentId) : ?Comment {
	// sanitize the commentId before searching
	try {
		$commentId = self::validateUuid($commentId);
	} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
		throw(new \PDOException($exception->getMessage(), 0, $exception));
	}
	// create query template
	$query = "SELECT commentId, commentEventId, commentTaskId, commentUserId, commentContent, commentDate FROM comment WHERE commentId = :commentId";
	$statement = $pdo->prepare($query);

	// bind the comment id to the place holder in the template
	$parameters = ["commentId" => $commentId->getBytes()];
	$statement->execute($parameters);

	// grab the comment from mySQL
	try {
		$comment = null;
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		$row = $statement->fetch();
		if($row !== false) {
			$comment = new Comment($row["commentId"], $row["commentEventId"], $row["commentTaskId"], $row["commentUserId"], $row["commentContent"], $row["commentDate"]);
		}
	} catch(\Exception $exception) {
		// if the row couldn't be converted, rethrow it
		throw(new \PDOException($exception->getMessage(), 0, $exception));
	}
	return($comment);
}

/**
 * gets the comment by commentEventId
 *
 * @param \PDO $pdo PDO connection object
 * @param Uuid|string $commentEventId comment event id to search for
 * @return \SplFixedArray SplFixedArray of Comments found
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError when a variable are not the correct data type
 **/
//TODO rewrite method to return spl fixed array(done)
	public static function getCommentByCommentEventId(\PDO $pdo, $commentEventId) : \SplFixedArray {

		try {
			$commentEventId = self::validateUuid($commentEventId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT commentId, commentEventId,commentTaskId, commentUserId, commentContent, commentDate FROM comment WHERE commentEventId = :commentEventId";
		$statement = $pdo->prepare($query);

		// bind the comment event id to the place holder in the template
		$parameters = ["commentEventId" => $commentEventId->getBytes()];
		$statement->execute($parameters);

		// build an array of comments
		$comments = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$comment = new Comment($row["commentId"], $row["commentEventId"], $row["commentTaskId"], $row["commentUserId"], $row["commentContent"], $row["commentDate"]);
				$comments[$comments->key()] = $comment;
				$comments->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($comments);
	}

/**
 * gets the Comment by commentTaskId
 *
 * @param \PDO $pdo PDO connection object
 * @param Uuid|string $commentTaskId comment task id to search for
 * @return \SplFixedArray SplFixedArray of Comments found
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError when a variable are not the correct data type
 **/
//TODO rewrite method to return spl fixed array (done)
	public static function getCommentByCommentTaskId(\PDO $pdo, $commentTaskId) : \SplFixedArray {

		try {
			$commentTaskId = self::validateUuid($commentTaskId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT commentId, commentEventId,commentTaskId, commentUserId, commentContent, commentDate FROM comment WHERE commentTaskId = :commentTaskId";
		$statement = $pdo->prepare($query);

		// bind the comment task id to the place holder in the template
		$parameters = ["commentTaskId" => $commentTaskId->getBytes()];
		$statement->execute($parameters);

		// build an array of comments
		$comments = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$comment = new Comment($row["commentId"], $row["commentEventId"], $row["commentTaskId"], $row["commentUserId"], $row["commentContent"], $row["commentDate"]);
				$comments [$comments->key()] = $comment;
				$comments->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($comments);
	}

/**
 * gets the comment by commentUserId
 *
 * @param \PDO $pdo PDO connection object
 * @param Uuid|string $commentUserId comment user id to search for
 * @return \SplFixedArray SplFixedArray of Comments found
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError when a variable are not the correct data type
 **/
//TODO rewrite method to return spl fixed array(done)
	public static function getCommentByCommentUserId(\PDO $pdo, $commentUserId) : \SplFixedArray {

		try {
			$commentUserId = self::validateUuid($commentUserId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
//TODO inner join name, use userdisplayname (done)
		// create query template
		$query = "SELECT comment.commentId, comment.commentEventId,comment.commentTaskId, comment.commentUserId, comment.commentContent, comment.commentDate, `user`.userDisplayName FROM comment INNER JOIN `user` WHERE commentUserId = :commentUserId";
		$statement = $pdo->prepare($query);

		// bind the comment user id to the place holder in the template
		$parameters = ["commentUserId" => $commentUserId->getBytes()];
		$statement->execute($parameters);

		// build an array of comments
		$comments = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$comment = new Comment($row["commentId"], $row["commentEventId"], $row["commentTaskId"], $row["commentUserId"], $row["commentContent"], $row["commentDate"]);
				$comments [$comments->key()] = (object) ["comment"=>$comment, "userDisplayName"=>$row["userDisplayName"]];
				$comments->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($comments);
	}

/**
 * gets the Comment by comment content
 *
 * @param \PDO $pdo PDO connection object
 * @param Uuid|string $commentContent comment content to search by
 * @return \SplFixedArray SplFixedArray of Comments found
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError when variables are not the correct data type
 **/
public static function getCommentByCommentContent(\PDO $pdo, $commentContent) : \SplFixedArray {

	try {
		$commentContent = self::validateUuid($commentContent);
	} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
		throw(new \PDOException($exception->getMessage(), 0, $exception));
	}

	// create query template
	$query = "SELECT commentId, commentEventId, commentTaskId, commentUserId, commentContent, commentDate FROM comment WHERE commentContent = :commentContent";
	$statement = $pdo->prepare($query);

	// bind the comment content to the place holder in the template
	$parameters = ["commentContent" => $commentContent->getBytes()];
	$statement->execute($parameters);

	// build an array of comments
	$comments = new \SplFixedArray($statement->rowCount());
	$statement->setFetchMode(\PDO::FETCH_ASSOC);
	while(($row = $statement->fetch()) !== false) {
		try {
			$comment = new Comment($row["commentId"], $row["commentEventId"], $row["commentTaskId"], $row["commentUserId"], $row["commentContent"], $row["commentDate"]);
			$comments[$comments->key()] = $comment;
			$comments->next();
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
	}
	return($comments);
}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() : array {
		$fields = get_object_vars($this);

		$fields["commentId"] = $this->commentId->toString();
		$fields["commentEventId"] = $this->commentEventId->toString();
		$fields["commentTaskId"] = $this->commentTaskId->toString();
		$fields["commentUserId"] = $this->commentUserId->toString();

		$fields["commentDate"] = round(floatval($this->commentDate->format("U.u")) * 1000);
		return($fields);
	}
}