<?php
namespace sharonromero\FamilyConnect;

require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");
require_once("autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * This shows what a user sees when they go to the website.
 *
 * @author Sharon Romero <sromero130@cnm.edu>
 * @version 1.0.0
 **/
class Event {
	use ValidateUuid;
	/**id for the Event, this is the primary key.
	 * @var uuid $eventId
	 **/
	private $eventId;
	/**
	 * id of the event that's connected to and created by family; this is a foreign key.
	 * @var uuid $eventFamilyId ;
	 **/
	private $eventFamilyId;
	/**
	 * id of the event that's connected to and created by the user; this is a foreign key.
	 * @var uuid $eventUserId ;
	 **/
	private $eventUserId;
	/**
	 *content of the event.
	 * @var string $eventContent ;
	 **/
	private $eventContent;
	/**
	 * End date of the event.
	 * @var \DateTime $eventEndDate
	 **/
	private $eventEndDate;
	/**
	 * Name of the event
	 * @var string $eventName
	 **/
	private $eventName;
	/**
	 * Start date of the event.
	 * @var \DateTime $eventStartDate
	 **/
	private $eventStartDate;
	/**
	 * constructor for event class
	 * @param uuid $newEventId id of this event or null if new event
	 * @param uuid $newEventFamilyId id of the family channel the event is tied to
	 * @param uuid $newEventUserId id of the user who created the event
	 * @param string $newEventContent string containing the content of the event
	 * @param \DateTime $newEventEndDate string containing the end date of the event
	 * @param string $newEventName string containing the name of the event
	 * @param \DateTime $newEventStartDate string containing the start date of the event
	 **/
	public function __construct($newEventId, $newEventFamilyId, $newEventUserId, string $newEventContent, $newEventEndDate,
										 $newEventName, $newEventStartDate) {
		try {
			$this->setEventId($newEventId);
			$this->setEventFamilyId($newEventFamilyId);
			$this->setEventUserId($newEventUserId);
			$this->setEventContent($newEventContent);
			$this->setEventEndDate($newEventEndDate);
			$this->setEventName($newEventName);
			$this->setEventStartDate($newEventStartDate);
		} //determine what exception was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for event id
	 *
	 * @return Uuid value for eventId
	 **/
	public function getEventId(): Uuid {
		return ($this->eventId);

		//this outside of class
		//$event->get event id();
	}

	/**
	* mutator method for event id
	* @param uuid $newEventId new value of event id
	* @throws \RangeException if $newEventId is not positive
	* @throws \TypeError if $newEventId is not a uuid
	**/
	public function setEventId($newEventId): void {
		try {
			$uuid = self::validateUuid($newEventId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
		}

		//convert and store the event id
		$this->eventId = $uuid;
	}

	/**
	* accessor method for event family id
	*
	* @return uuid value for event family id
	**/
	public function getEventFamilyId(): uuid {
		return ($this->eventFamilyId);
	}

	/**
 * mutator method for event family id
 * @param string | Uuid $newEventFamilyId new value of event family id
 * @throws \RangeException if $newEventFamilyId is not positive
 * @throws \TypeError if $newEventFamilyId is not an integer
 	**/

	public function setEventFamilyId($newEventFamilyId): void {
		try {
			$uuid = self::validateUuid($newEventFamilyId);
		} catch
		(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the event family id
		$this->eventFamilyId = $uuid;
	}

	/**
	 * accessor method for event user id
	 *
	 * @return uuid value for event user id
	 **/
	public function getEventUserId(): uuid {
		return ($this->eventUserId);
	}

	/**
	 * mutator method for event user id
	 * @param string | Uuid $newEventUserId new value of event user id
	 * @throws \RangeException if $newEventUserId is not positive
	 * @throws \TypeError if $newEventUserId is not an integer
	 **/

	public function setEventUserId($newEventUserId): void {
		try {
			$uuid = self::validateUuid($newEventUserId);
		} catch
		(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the event user id
		$this->eventUserId = $uuid;
	}

	/**
	 * accessor method for event content
	 *
	 * @return string value of event content
	 **/
	public function getEventContent(): string {
		return ($this->EventContent);
	}
	/**
	 * mutator method for event content
	 *
	 * @param string $newEventContent new value of event content
	 * @throws \InvalidArgumentException if $newEventContent is not a string or insecure
	 * @throws \RangeException if $newEventContent is > 255 characters
	 * @throws \TypeError if $newEventContent is not a string
	 **/
	public function setEventContent(string $newEventContent): void {
		//verify the event content is secure
		$newEventContent = trim($newEventContent);
		$newEventContent = filter_var($newEventContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newEventContent) === true) {
			throw(new \InvalidArgumentException("event content is empty or insecure"));
		}

		//verify the event content will fit in the database
		if(strlen($newEventContent) >= 255) {
			throw(new \RangeException("event content too large"));
		}

		// store the event content
		$this->eventContent = $newEventContent;
	}

		/**
	 	* accessor method for event end date
	 	*
	 	* @return \dateTime value of event end date
	 	**/
	public function getEventEndDate(): \DateTime {
		return ($this->EventEndDate);
	}

	/**
	 * mutator method for event end date
	 *
	 * @param \DateTime $newEventEndDate new value of event end date
	 * @throws \InvalidArgumentException if $newEventEndDate is not a valid object or string
	 * @throws \RangeException if $newEventEndDate is a date that does not exist
	 * @throws \Exception
	 **/
	public function setEventEndDate($newEventEndDate = null) : void {
		if($newEventEndDate === null) {
			$this->EventEndDate = new \DateTime();
			return;
		}

		try {
			$newEventEndDate = self::validateDateTime($newEventEndDate);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->eventEndDate = $newEventEndDate;
	}

	/**
	 * accessor method for event name
	 *
	 * @return string value of event name
	 **/
	public function getEventName(): string {
		return ($this->EventName);
	}
	/**
	 * mutator method for event name
	 *
	 * @param string $newEventName new value of event name
	 * @throws \InvalidArgumentException if $newEventName is not a string or insecure
	 * @throws \RangeException if $newEventName is > 30 characters
	 * @throws \TypeError if $newEventName is not a string
	 **/
	public function setEventName(string $newEventName): void {
		//verify the event name is secure
		$newEventName = trim($newEventName);
		$newEventName = filter_var($newEventName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newEventName) === true) {
			throw(new \InvalidArgumentException("event name is empty or insecure"));
		}

		//verify the event name will fit in the database
		if(strlen($newEventName) >= 30) {
			throw(new \RangeException("event name too large"));
		}

		// store the event name
		$this->eventName = $newEventName;
	}

	/**
	 * accessor method for event start date
	 *
	 * @return \dateTime value of event start date
	 **/
	public function getEventStartDate(): \DateTime {
		return ($this->EventStartDate);
	}

	/**
	 * mutator method for event start date
	 *
	 * @param \DateTime $newEventStartDate new value of event start date
	 * @throws \InvalidArgumentException if $newEventStartDate is not a valid object or string
	 * @throws \RangeException if $newEventStartDate is a date that does not exist
	 * @throws \Exception
	 **/
	public function setEventStartDate($newEventStartDate = null) : void {
		if($newEventStartDate === null) {
			$this->EventStartDate = new \DateTime();
			return;
		}

		try {
			$newEventStartDate = self::validateDateTime($newEventStartDate);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->eventStartDate = $newEventStartDate;
	}

	/**
	 * inserts this event into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo): void {

		$query = "INSERT INTO event(eventId, eventFamilyId, eventUserId, eventContent, eventEndDate, eventName, eventStartDate) VALUES
(:eventId, :eventFamilyId, :eventUserId, :eventContent, :eventEndDate, :eventName, :eventStartDate)";

		$statement = $pdo->prepare($query);

		$statement->execute($query);
	}

	/**
	 * updates this event in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws	\PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo): void {

		// create query template
		$query = "UPDATE event SET eventFamilyId = :eventFamilyId:, eventUserId = :eventUserId, eventContent = :eventContent, 
eventEndDate = :eventEndDate, eventName = :eventName, eventStartDate = :eventStartDate WHERE eventId = :eventId";
		$statement = $pdo->prepare($query);

		$parameters = ["eventId" => $this->eventId->getBytes(), "eventFamilyId" => $this->eventFamilyId->getBytes(), "eventUserId" => $this->eventUserId, "eventContent" => $this->eventContent, "eventEndDate" => $this->eventEndDate, "eventName" => $this->eventName, "eventStartDate"=> $this->eventStartDate];
		$statement->execute($parameters);
	}

	/**
	 * deletes this event from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo): void {

		// create query template
		$query = "DELETE FROM event WHERE eventId = :eventId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["eventId" => $this->eventId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * gets the event by eventId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $eventId event id to search for
	 * @return event|null event found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable is not the correct data type
	 **/
	public static function getEventByEventId(\PDO $pdo, $eventId) : ?Event {
		// sanitize the eventId before searching
		try {
			$eventId = self::validateUuid($eventId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT eventId, eventFamilyId, eventUserId, eventContent, eventEndDate, eventName, eventStartDate FROM 
event WHERE eventId = :eventId";
		$statement = $pdo->prepare($query);

		// bind the event id to the place holder in the template
		$parameters = ["eventId" => $eventId->getBytes()];
		$statement->execute($parameters);

		// grab the article from mySQL
		try {
			$event = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$event = new Event($row["eventId"], $row["eventFamilyId"], $row["eventUserId"], $row["eventContent"],
					$row["eventEndDate"], $row["eventName"], $row["eventStartDate"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($event);
	}

	/**
	 * gets all Event
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of Events found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllEvents(\PDO $pdo) : \SPLFixedArray {
		// create query template
		$query = "SELECT eventId, eventFamilyId, eventUserId, eventContent, eventEndDate, eventName, eventStartDate FROM event";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of events
		$events = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$event = new Event($row["eventId"], $row["eventFamilyId"], $row["eventUserId"], $row["eventContent"],
					$row["eventEndDate"], $row["eventName"], $row["eventStartDate"]);
				$events[$events->key()] = $event;
				$events->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($events);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() : array {
		$fields = get_object_vars($this);

		$fields["eventId"] = $this->eventId->toString();
		$fields["eventFamilyId"] = $this->eventFamilyId->toString();

		return($fields);
	}
}
}

