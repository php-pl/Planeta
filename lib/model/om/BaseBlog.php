<?php

/**
 * Base class that represents a row from the 'blog' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BaseBlog extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        BlogPeer
	 */
	protected static $peer;


	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;


	/**
	 * The value for the mid field.
	 * @var        int
	 */
	protected $mid;


	/**
	 * The value for the name field.
	 * @var        string
	 */
	protected $name;


	/**
	 * The value for the url field.
	 * @var        string
	 */
	protected $url;


	/**
	 * The value for the feed field.
	 * @var        string
	 */
	protected $feed;


	/**
	 * The value for the author field.
	 * @var        string
	 */
	protected $author;


	/**
	 * The value for the email field.
	 * @var        string
	 */
	protected $email;


	/**
	 * The value for the file field.
	 * @var        string
	 */
	protected $file;


	/**
	 * The value for the verified field.
	 * @var        boolean
	 */
	protected $verified = false;


	/**
	 * The value for the approved field.
	 * @var        boolean
	 */
	protected $approved = false;

	/**
	 * Collection to store aggregation of collPosts.
	 * @var        array
	 */
	protected $collPosts;

	/**
	 * The criteria used to select the current contents of collPosts.
	 * @var        Criteria
	 */
	protected $lastPostCriteria = null;

	/**
	 * Flag to prevent endless save loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInSave = false;

	/**
	 * Flag to prevent endless validation loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInValidation = false;

	/**
	 * Get the [id] column value.
	 * 
	 * @return     int
	 */
	public function getId()
	{

		return $this->id;
	}

	/**
	 * Get the [mid] column value.
	 * 
	 * @return     int
	 */
	public function getMid()
	{

		return $this->mid;
	}

	/**
	 * Get the [name] column value.
	 * 
	 * @return     string
	 */
	public function getName()
	{

		return $this->name;
	}

	/**
	 * Get the [url] column value.
	 * 
	 * @return     string
	 */
	public function getUrl()
	{

		return $this->url;
	}

	/**
	 * Get the [feed] column value.
	 * 
	 * @return     string
	 */
	public function getFeed()
	{

		return $this->feed;
	}

	/**
	 * Get the [author] column value.
	 * 
	 * @return     string
	 */
	public function getAuthor()
	{

		return $this->author;
	}

	/**
	 * Get the [email] column value.
	 * 
	 * @return     string
	 */
	public function getEmail()
	{

		return $this->email;
	}

	/**
	 * Get the [file] column value.
	 * 
	 * @return     string
	 */
	public function getFile()
	{

		return $this->file;
	}

	/**
	 * Get the [verified] column value.
	 * 
	 * @return     boolean
	 */
	public function getVerified()
	{

		return $this->verified;
	}

	/**
	 * Get the [approved] column value.
	 * 
	 * @return     boolean
	 */
	public function getApproved()
	{

		return $this->approved;
	}

	/**
	 * Set the value of [id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setId($v)
	{

		// Since the native PHP type for this column is integer,
		// we will cast the input value to an int (if it is not).
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = BlogPeer::ID;
		}

	} // setId()

	/**
	 * Set the value of [mid] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setMid($v)
	{

		// Since the native PHP type for this column is integer,
		// we will cast the input value to an int (if it is not).
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->mid !== $v) {
			$this->mid = $v;
			$this->modifiedColumns[] = BlogPeer::MID;
		}

	} // setMid()

	/**
	 * Set the value of [name] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setName($v)
	{

		// Since the native PHP type for this column is string,
		// we will cast the input to a string (if it is not).
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = BlogPeer::NAME;
		}

	} // setName()

	/**
	 * Set the value of [url] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setUrl($v)
	{

		// Since the native PHP type for this column is string,
		// we will cast the input to a string (if it is not).
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->url !== $v) {
			$this->url = $v;
			$this->modifiedColumns[] = BlogPeer::URL;
		}

	} // setUrl()

	/**
	 * Set the value of [feed] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setFeed($v)
	{

		// Since the native PHP type for this column is string,
		// we will cast the input to a string (if it is not).
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->feed !== $v) {
			$this->feed = $v;
			$this->modifiedColumns[] = BlogPeer::FEED;
		}

	} // setFeed()

	/**
	 * Set the value of [author] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setAuthor($v)
	{

		// Since the native PHP type for this column is string,
		// we will cast the input to a string (if it is not).
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->author !== $v) {
			$this->author = $v;
			$this->modifiedColumns[] = BlogPeer::AUTHOR;
		}

	} // setAuthor()

	/**
	 * Set the value of [email] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setEmail($v)
	{

		// Since the native PHP type for this column is string,
		// we will cast the input to a string (if it is not).
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->email !== $v) {
			$this->email = $v;
			$this->modifiedColumns[] = BlogPeer::EMAIL;
		}

	} // setEmail()

	/**
	 * Set the value of [file] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setFile($v)
	{

		// Since the native PHP type for this column is string,
		// we will cast the input to a string (if it is not).
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->file !== $v) {
			$this->file = $v;
			$this->modifiedColumns[] = BlogPeer::FILE;
		}

	} // setFile()

	/**
	 * Set the value of [verified] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setVerified($v)
	{

		if ($this->verified !== $v || $v === false) {
			$this->verified = $v;
			$this->modifiedColumns[] = BlogPeer::VERIFIED;
		}

	} // setVerified()

	/**
	 * Set the value of [approved] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setApproved($v)
	{

		if ($this->approved !== $v || $v === false) {
			$this->approved = $v;
			$this->modifiedColumns[] = BlogPeer::APPROVED;
		}

	} // setApproved()

	/**
	 * Hydrates (populates) the object variables with values from the database resultset.
	 *
	 * An offset (1-based "start column") is specified so that objects can be hydrated
	 * with a subset of the columns in the resultset rows.  This is needed, for example,
	 * for results of JOIN queries where the resultset row includes columns from two or
	 * more tables.
	 *
	 * @param      ResultSet $rs The ResultSet class with cursor advanced to desired record pos.
	 * @param      int $startcol 1-based offset column which indicates which restultset column to start with.
	 * @return     int next starting column
	 * @throws     PropelException  - Any caught Exception will be rewrapped as a PropelException.
	 */
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->mid = $rs->getInt($startcol + 1);

			$this->name = $rs->getString($startcol + 2);

			$this->url = $rs->getString($startcol + 3);

			$this->feed = $rs->getString($startcol + 4);

			$this->author = $rs->getString($startcol + 5);

			$this->email = $rs->getString($startcol + 6);

			$this->file = $rs->getString($startcol + 7);

			$this->verified = $rs->getBoolean($startcol + 8);

			$this->approved = $rs->getBoolean($startcol + 9);

			$this->resetModified();

			$this->setNew(false);

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 10; // 10 = BlogPeer::NUM_COLUMNS - BlogPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating Blog object", $e);
		}
	}

	/**
	 * Removes this object from datastore and sets delete attribute.
	 *
	 * @param      Connection $con
	 * @return     void
	 * @throws     PropelException
	 * @see        BaseObject::setDeleted()
	 * @see        BaseObject::isDeleted()
	 */
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(BlogPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			BlogPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Stores the object in the database.  If the object is new,
	 * it inserts it; otherwise an update is performed.  This method
	 * wraps the doSave() worker method in a transaction.
	 *
	 * @param      Connection $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        doSave()
	 */
	public function save($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(BlogPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Stores the object in the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All related objects are also updated in this method.
	 *
	 * @param      Connection $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        save()
	 */
	protected function doSave($con)
	{
		$affectedRows = 0; // initialize var to track total num of affected rows
		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = BlogPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += BlogPeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collPosts !== null) {
				foreach($this->collPosts as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			$this->alreadyInSave = false;
		}
		return $affectedRows;
	} // doSave()

	/**
	 * Array of ValidationFailed objects.
	 * @var        array ValidationFailed[]
	 */
	protected $validationFailures = array();

	/**
	 * Gets any ValidationFailed objects that resulted from last call to validate().
	 *
	 *
	 * @return     array ValidationFailed[]
	 * @see        validate()
	 */
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	/**
	 * Validates the objects modified field values and all objects related to this table.
	 *
	 * If $columns is either a column name or an array of column names
	 * only those columns are validated.
	 *
	 * @param      mixed $columns Column name or an array of column names.
	 * @return     boolean Whether all columns pass validation.
	 * @see        doValidate()
	 * @see        getValidationFailures()
	 */
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	/**
	 * This function performs the validation work for complex object models.
	 *
	 * In addition to checking the current object, all related objects will
	 * also be validated.  If all pass then <code>true</code> is returned; otherwise
	 * an aggreagated array of ValidationFailed objects will be returned.
	 *
	 * @param      array $columns Array of column names to validate.
	 * @return     mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
	 */
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


			if (($retval = BlogPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collPosts !== null) {
					foreach($this->collPosts as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}


			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	/**
	 * Retrieves a field from the object by name passed in as a string.
	 *
	 * @param      string $name name
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants TYPE_PHPNAME,
	 *                     TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM
	 * @return     mixed Value of field.
	 */
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = BlogPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	/**
	 * Retrieves a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @return     mixed Value of field at $pos
	 */
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getMid();
				break;
			case 2:
				return $this->getName();
				break;
			case 3:
				return $this->getUrl();
				break;
			case 4:
				return $this->getFeed();
				break;
			case 5:
				return $this->getAuthor();
				break;
			case 6:
				return $this->getEmail();
				break;
			case 7:
				return $this->getFile();
				break;
			case 8:
				return $this->getVerified();
				break;
			case 9:
				return $this->getApproved();
				break;
			default:
				return null;
				break;
		} // switch()
	}

	/**
	 * Exports the object as an array.
	 *
	 * You can specify the key type of the array by passing one of the class
	 * type constants.
	 *
	 * @param      string $keyType One of the class type constants TYPE_PHPNAME,
	 *                        TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM
	 * @return     an associative array containing the field names (as keys) and field values
	 */
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = BlogPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getMid(),
			$keys[2] => $this->getName(),
			$keys[3] => $this->getUrl(),
			$keys[4] => $this->getFeed(),
			$keys[5] => $this->getAuthor(),
			$keys[6] => $this->getEmail(),
			$keys[7] => $this->getFile(),
			$keys[8] => $this->getVerified(),
			$keys[9] => $this->getApproved(),
		);
		return $result;
	}

	/**
	 * Sets a field from the object by name passed in as a string.
	 *
	 * @param      string $name peer name
	 * @param      mixed $value field value
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants TYPE_PHPNAME,
	 *                     TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM
	 * @return     void
	 */
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = BlogPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	/**
	 * Sets a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @param      mixed $value field value
	 * @return     void
	 */
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setMid($value);
				break;
			case 2:
				$this->setName($value);
				break;
			case 3:
				$this->setUrl($value);
				break;
			case 4:
				$this->setFeed($value);
				break;
			case 5:
				$this->setAuthor($value);
				break;
			case 6:
				$this->setEmail($value);
				break;
			case 7:
				$this->setFile($value);
				break;
			case 8:
				$this->setVerified($value);
				break;
			case 9:
				$this->setApproved($value);
				break;
		} // switch()
	}

	/**
	 * Populates the object using an array.
	 *
	 * This is particularly useful when populating an object from one of the
	 * request arrays (e.g. $_POST).  This method goes through the column
	 * names, checking to see whether a matching key exists in populated
	 * array. If so the setByName() method is called for that column.
	 *
	 * You can specify the key type of the array by additionally passing one
	 * of the class type constants TYPE_PHPNAME, TYPE_COLNAME, TYPE_FIELDNAME,
	 * TYPE_NUM. The default key type is the column's phpname (e.g. 'authorId')
	 *
	 * @param      array  $arr     An array to populate the object from.
	 * @param      string $keyType The type of keys the array uses.
	 * @return     void
	 */
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = BlogPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setMid($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setName($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setUrl($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setFeed($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setAuthor($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setEmail($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setFile($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setVerified($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setApproved($arr[$keys[9]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(BlogPeer::DATABASE_NAME);

		if ($this->isColumnModified(BlogPeer::ID)) $criteria->add(BlogPeer::ID, $this->id);
		if ($this->isColumnModified(BlogPeer::MID)) $criteria->add(BlogPeer::MID, $this->mid);
		if ($this->isColumnModified(BlogPeer::NAME)) $criteria->add(BlogPeer::NAME, $this->name);
		if ($this->isColumnModified(BlogPeer::URL)) $criteria->add(BlogPeer::URL, $this->url);
		if ($this->isColumnModified(BlogPeer::FEED)) $criteria->add(BlogPeer::FEED, $this->feed);
		if ($this->isColumnModified(BlogPeer::AUTHOR)) $criteria->add(BlogPeer::AUTHOR, $this->author);
		if ($this->isColumnModified(BlogPeer::EMAIL)) $criteria->add(BlogPeer::EMAIL, $this->email);
		if ($this->isColumnModified(BlogPeer::FILE)) $criteria->add(BlogPeer::FILE, $this->file);
		if ($this->isColumnModified(BlogPeer::VERIFIED)) $criteria->add(BlogPeer::VERIFIED, $this->verified);
		if ($this->isColumnModified(BlogPeer::APPROVED)) $criteria->add(BlogPeer::APPROVED, $this->approved);

		return $criteria;
	}

	/**
	 * Builds a Criteria object containing the primary key for this object.
	 *
	 * Unlike buildCriteria() this method includes the primary key values regardless
	 * of whether or not they have been modified.
	 *
	 * @return     Criteria The Criteria object containing value(s) for primary key(s).
	 */
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(BlogPeer::DATABASE_NAME);

		$criteria->add(BlogPeer::ID, $this->id);

		return $criteria;
	}

	/**
	 * Returns the primary key for this object (row).
	 * @return     int
	 */
	public function getPrimaryKey()
	{
		return $this->getId();
	}

	/**
	 * Generic method to set the primary key (id column).
	 *
	 * @param      int $key Primary key.
	 * @return     void
	 */
	public function setPrimaryKey($key)
	{
		$this->setId($key);
	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of Blog (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setMid($this->mid);

		$copyObj->setName($this->name);

		$copyObj->setUrl($this->url);

		$copyObj->setFeed($this->feed);

		$copyObj->setAuthor($this->author);

		$copyObj->setEmail($this->email);

		$copyObj->setFile($this->file);

		$copyObj->setVerified($this->verified);

		$copyObj->setApproved($this->approved);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getPosts() as $relObj) {
				$copyObj->addPost($relObj->copy($deepCopy));
			}

		} // if ($deepCopy)


		$copyObj->setNew(true);

		$copyObj->setId(NULL); // this is a pkey column, so set to default value

	}

	/**
	 * Makes a copy of this object that will be inserted as a new row in table when saved.
	 * It creates a new object filling in the simple attributes, but skipping any primary
	 * keys that are defined for the table.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @return     Blog Clone of current object.
	 * @throws     PropelException
	 */
	public function copy($deepCopy = false)
	{
		// we use get_class(), because this might be a subclass
		$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	/**
	 * Returns a peer instance associated with this om.
	 *
	 * Since Peer classes are not to have any instance attributes, this method returns the
	 * same instance for all member of this class. The method could therefore
	 * be static, but this would prevent one from overriding the behavior.
	 *
	 * @return     BlogPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new BlogPeer();
		}
		return self::$peer;
	}

	/**
	 * Temporary storage of collPosts to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initPosts()
	{
		if ($this->collPosts === null) {
			$this->collPosts = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Blog has previously
	 * been saved, it will retrieve related Posts from storage.
	 * If this Blog is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getPosts($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'lib/model/om/BasePostPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPosts === null) {
			if ($this->isNew()) {
			   $this->collPosts = array();
			} else {

				$criteria->add(PostPeer::BLOG_ID, $this->getId());

				PostPeer::addSelectColumns($criteria);
				$this->collPosts = PostPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PostPeer::BLOG_ID, $this->getId());

				PostPeer::addSelectColumns($criteria);
				if (!isset($this->lastPostCriteria) || !$this->lastPostCriteria->equals($criteria)) {
					$this->collPosts = PostPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPostCriteria = $criteria;
		return $this->collPosts;
	}

	/**
	 * Returns the number of related Posts.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countPosts($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		include_once 'lib/model/om/BasePostPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(PostPeer::BLOG_ID, $this->getId());

		return PostPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Post object to this object
	 * through the Post foreign key attribute
	 *
	 * @param      Post $l Post
	 * @return     void
	 * @throws     PropelException
	 */
	public function addPost(Post $l)
	{
		$this->collPosts[] = $l;
		$l->setBlog($this);
	}

} // BaseBlog
