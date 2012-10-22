<?php

/**
 * Base class that represents a row from the 'post' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BasePost extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        PostPeer
	 */
	protected static $peer;


	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;


	/**
	 * The value for the blog_id field.
	 * @var        int
	 */
	protected $blog_id;


	/**
	 * The value for the created_at field.
	 * @var        int
	 */
	protected $created_at;


	/**
	 * The value for the year field.
	 * @var        int
	 */
	protected $year;


	/**
	 * The value for the month field.
	 * @var        int
	 */
	protected $month;


	/**
	 * The value for the title field.
	 * @var        string
	 */
	protected $title;


	/**
	 * The value for the link field.
	 * @var        string
	 */
	protected $link;


	/**
	 * The value for the content field.
	 * @var        string
	 */
	protected $content;


	/**
	 * The value for the content_more field.
	 * @var        string
	 */
	protected $content_more;


	/**
	 * The value for the shortened field.
	 * @var        boolean
	 */
	protected $shortened;


	/**
	 * The value for the deleted field.
	 * @var        boolean
	 */
	protected $deleted = false;

	/**
	 * @var        Blog
	 */
	protected $aBlog;

	/**
	 * Collection to store aggregation of collPostTags.
	 * @var        array
	 */
	protected $collPostTags;

	/**
	 * The criteria used to select the current contents of collPostTags.
	 * @var        Criteria
	 */
	protected $lastPostTagCriteria = null;

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
	 * Get the [blog_id] column value.
	 * 
	 * @return     int
	 */
	public function getBlogId()
	{

		return $this->blog_id;
	}

	/**
	 * Get the [optionally formatted] [created_at] column value.
	 * 
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the integer unix timestamp will be returned.
	 * @return     mixed Formatted date/time value as string or integer unix timestamp (if format is NULL).
	 * @throws     PropelException - if unable to convert the date/time to timestamp.
	 */
	public function getCreatedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->created_at === null || $this->created_at === '') {
			return null;
		} elseif (!is_int($this->created_at)) {
			// a non-timestamp value was set externally, so we convert it
			$ts = strtotime($this->created_at);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse value of [created_at] as date/time value: " . var_export($this->created_at, true));
			}
		} else {
			$ts = $this->created_at;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	/**
	 * Get the [year] column value.
	 * 
	 * @return     int
	 */
	public function getYear()
	{

		return $this->year;
	}

	/**
	 * Get the [month] column value.
	 * 
	 * @return     int
	 */
	public function getMonth()
	{

		return $this->month;
	}

	/**
	 * Get the [title] column value.
	 * 
	 * @return     string
	 */
	public function getTitle()
	{

		return $this->title;
	}

	/**
	 * Get the [link] column value.
	 * 
	 * @return     string
	 */
	public function getLink()
	{

		return $this->link;
	}

	/**
	 * Get the [content] column value.
	 * 
	 * @return     string
	 */
	public function getContent()
	{

		return $this->content;
	}

	/**
	 * Get the [content_more] column value.
	 * 
	 * @return     string
	 */
	public function getContentMore()
	{

		return $this->content_more;
	}

	/**
	 * Get the [shortened] column value.
	 * 
	 * @return     boolean
	 */
	public function getShortened()
	{

		return $this->shortened;
	}

	/**
	 * Get the [deleted] column value.
	 * 
	 * @return     boolean
	 */
	public function getDeleted()
	{

		return $this->deleted;
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
			$this->modifiedColumns[] = PostPeer::ID;
		}

	} // setId()

	/**
	 * Set the value of [blog_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setBlogId($v)
	{

		// Since the native PHP type for this column is integer,
		// we will cast the input value to an int (if it is not).
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->blog_id !== $v) {
			$this->blog_id = $v;
			$this->modifiedColumns[] = PostPeer::BLOG_ID;
		}

		if ($this->aBlog !== null && $this->aBlog->getId() !== $v) {
			$this->aBlog = null;
		}

	} // setBlogId()

	/**
	 * Set the value of [created_at] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setCreatedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse date/time value for [created_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->created_at !== $ts) {
			$this->created_at = $ts;
			$this->modifiedColumns[] = PostPeer::CREATED_AT;
		}

	} // setCreatedAt()

	/**
	 * Set the value of [year] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setYear($v)
	{

		// Since the native PHP type for this column is integer,
		// we will cast the input value to an int (if it is not).
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->year !== $v) {
			$this->year = $v;
			$this->modifiedColumns[] = PostPeer::YEAR;
		}

	} // setYear()

	/**
	 * Set the value of [month] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setMonth($v)
	{

		// Since the native PHP type for this column is integer,
		// we will cast the input value to an int (if it is not).
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->month !== $v) {
			$this->month = $v;
			$this->modifiedColumns[] = PostPeer::MONTH;
		}

	} // setMonth()

	/**
	 * Set the value of [title] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setTitle($v)
	{

		// Since the native PHP type for this column is string,
		// we will cast the input to a string (if it is not).
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->title !== $v) {
			$this->title = $v;
			$this->modifiedColumns[] = PostPeer::TITLE;
		}

	} // setTitle()

	/**
	 * Set the value of [link] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setLink($v)
	{

		// Since the native PHP type for this column is string,
		// we will cast the input to a string (if it is not).
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->link !== $v) {
			$this->link = $v;
			$this->modifiedColumns[] = PostPeer::LINK;
		}

	} // setLink()

	/**
	 * Set the value of [content] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setContent($v)
	{

		// Since the native PHP type for this column is string,
		// we will cast the input to a string (if it is not).
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->content !== $v) {
			$this->content = $v;
			$this->modifiedColumns[] = PostPeer::CONTENT;
		}

	} // setContent()

	/**
	 * Set the value of [content_more] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setContentMore($v)
	{

		// Since the native PHP type for this column is string,
		// we will cast the input to a string (if it is not).
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->content_more !== $v) {
			$this->content_more = $v;
			$this->modifiedColumns[] = PostPeer::CONTENT_MORE;
		}

	} // setContentMore()

	/**
	 * Set the value of [shortened] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setShortened($v)
	{

		if ($this->shortened !== $v) {
			$this->shortened = $v;
			$this->modifiedColumns[] = PostPeer::SHORTENED;
		}

	} // setShortened()

	/**
	 * Set the value of [deleted] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setDeleted($v)
	{

		if ($this->deleted !== $v || $v === false) {
			$this->deleted = $v;
			$this->modifiedColumns[] = PostPeer::DELETED;
		}

	} // setDeleted()

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

			$this->blog_id = $rs->getInt($startcol + 1);

			$this->created_at = $rs->getTimestamp($startcol + 2, null);

			$this->year = $rs->getInt($startcol + 3);

			$this->month = $rs->getInt($startcol + 4);

			$this->title = $rs->getString($startcol + 5);

			$this->link = $rs->getString($startcol + 6);

			$this->content = $rs->getString($startcol + 7);

			$this->content_more = $rs->getString($startcol + 8);

			$this->shortened = $rs->getBoolean($startcol + 9);

			$this->deleted = $rs->getBoolean($startcol + 10);

			$this->resetModified();

			$this->setNew(false);

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 11; // 11 = PostPeer::NUM_COLUMNS - PostPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating Post object", $e);
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
			$con = Propel::getConnection(PostPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			PostPeer::doDelete($this, $con);
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
    if ($this->isNew() && !$this->isColumnModified(PostPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(PostPeer::DATABASE_NAME);
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


			// We call the save method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aBlog !== null) {
				if ($this->aBlog->isModified()) {
					$affectedRows += $this->aBlog->save($con);
				}
				$this->setBlog($this->aBlog);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = PostPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += PostPeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collPostTags !== null) {
				foreach($this->collPostTags as $referrerFK) {
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


			// We call the validate method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aBlog !== null) {
				if (!$this->aBlog->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aBlog->getValidationFailures());
				}
			}


			if (($retval = PostPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collPostTags !== null) {
					foreach($this->collPostTags as $referrerFK) {
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
		$pos = PostPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getBlogId();
				break;
			case 2:
				return $this->getCreatedAt();
				break;
			case 3:
				return $this->getYear();
				break;
			case 4:
				return $this->getMonth();
				break;
			case 5:
				return $this->getTitle();
				break;
			case 6:
				return $this->getLink();
				break;
			case 7:
				return $this->getContent();
				break;
			case 8:
				return $this->getContentMore();
				break;
			case 9:
				return $this->getShortened();
				break;
			case 10:
				return $this->getDeleted();
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
		$keys = PostPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getBlogId(),
			$keys[2] => $this->getCreatedAt(),
			$keys[3] => $this->getYear(),
			$keys[4] => $this->getMonth(),
			$keys[5] => $this->getTitle(),
			$keys[6] => $this->getLink(),
			$keys[7] => $this->getContent(),
			$keys[8] => $this->getContentMore(),
			$keys[9] => $this->getShortened(),
			$keys[10] => $this->getDeleted(),
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
		$pos = PostPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setBlogId($value);
				break;
			case 2:
				$this->setCreatedAt($value);
				break;
			case 3:
				$this->setYear($value);
				break;
			case 4:
				$this->setMonth($value);
				break;
			case 5:
				$this->setTitle($value);
				break;
			case 6:
				$this->setLink($value);
				break;
			case 7:
				$this->setContent($value);
				break;
			case 8:
				$this->setContentMore($value);
				break;
			case 9:
				$this->setShortened($value);
				break;
			case 10:
				$this->setDeleted($value);
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
		$keys = PostPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setBlogId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setCreatedAt($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setYear($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setMonth($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setTitle($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setLink($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setContent($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setContentMore($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setShortened($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setDeleted($arr[$keys[10]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(PostPeer::DATABASE_NAME);

		if ($this->isColumnModified(PostPeer::ID)) $criteria->add(PostPeer::ID, $this->id);
		if ($this->isColumnModified(PostPeer::BLOG_ID)) $criteria->add(PostPeer::BLOG_ID, $this->blog_id);
		if ($this->isColumnModified(PostPeer::CREATED_AT)) $criteria->add(PostPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(PostPeer::YEAR)) $criteria->add(PostPeer::YEAR, $this->year);
		if ($this->isColumnModified(PostPeer::MONTH)) $criteria->add(PostPeer::MONTH, $this->month);
		if ($this->isColumnModified(PostPeer::TITLE)) $criteria->add(PostPeer::TITLE, $this->title);
		if ($this->isColumnModified(PostPeer::LINK)) $criteria->add(PostPeer::LINK, $this->link);
		if ($this->isColumnModified(PostPeer::CONTENT)) $criteria->add(PostPeer::CONTENT, $this->content);
		if ($this->isColumnModified(PostPeer::CONTENT_MORE)) $criteria->add(PostPeer::CONTENT_MORE, $this->content_more);
		if ($this->isColumnModified(PostPeer::SHORTENED)) $criteria->add(PostPeer::SHORTENED, $this->shortened);
		if ($this->isColumnModified(PostPeer::DELETED)) $criteria->add(PostPeer::DELETED, $this->deleted);

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
		$criteria = new Criteria(PostPeer::DATABASE_NAME);

		$criteria->add(PostPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of Post (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setBlogId($this->blog_id);

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setYear($this->year);

		$copyObj->setMonth($this->month);

		$copyObj->setTitle($this->title);

		$copyObj->setLink($this->link);

		$copyObj->setContent($this->content);

		$copyObj->setContentMore($this->content_more);

		$copyObj->setShortened($this->shortened);

		$copyObj->setDeleted($this->deleted);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getPostTags() as $relObj) {
				$copyObj->addPostTag($relObj->copy($deepCopy));
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
	 * @return     Post Clone of current object.
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
	 * @return     PostPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new PostPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a Blog object.
	 *
	 * @param      Blog $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setBlog($v)
	{


		if ($v === null) {
			$this->setBlogId(NULL);
		} else {
			$this->setBlogId($v->getId());
		}


		$this->aBlog = $v;
	}


	/**
	 * Get the associated Blog object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     Blog The associated Blog object.
	 * @throws     PropelException
	 */
	public function getBlog($con = null)
	{
		// include the related Peer class
		include_once 'lib/model/om/BaseBlogPeer.php';

		if ($this->aBlog === null && ($this->blog_id !== null)) {

			$this->aBlog = BlogPeer::retrieveByPK($this->blog_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = BlogPeer::retrieveByPK($this->blog_id, $con);
			   $obj->addBlogs($this);
			 */
		}
		return $this->aBlog;
	}

	/**
	 * Temporary storage of collPostTags to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initPostTags()
	{
		if ($this->collPostTags === null) {
			$this->collPostTags = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Post has previously
	 * been saved, it will retrieve related PostTags from storage.
	 * If this Post is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getPostTags($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'lib/model/om/BasePostTagPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPostTags === null) {
			if ($this->isNew()) {
			   $this->collPostTags = array();
			} else {

				$criteria->add(PostTagPeer::POST_ID, $this->getId());

				PostTagPeer::addSelectColumns($criteria);
				$this->collPostTags = PostTagPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PostTagPeer::POST_ID, $this->getId());

				PostTagPeer::addSelectColumns($criteria);
				if (!isset($this->lastPostTagCriteria) || !$this->lastPostTagCriteria->equals($criteria)) {
					$this->collPostTags = PostTagPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPostTagCriteria = $criteria;
		return $this->collPostTags;
	}

	/**
	 * Returns the number of related PostTags.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countPostTags($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		include_once 'lib/model/om/BasePostTagPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(PostTagPeer::POST_ID, $this->getId());

		return PostTagPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a PostTag object to this object
	 * through the PostTag foreign key attribute
	 *
	 * @param      PostTag $l PostTag
	 * @return     void
	 * @throws     PropelException
	 */
	public function addPostTag(PostTag $l)
	{
		$this->collPostTags[] = $l;
		$l->setPost($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Post is new, it will return
	 * an empty collection; or if this Post has previously
	 * been saved, it will retrieve related PostTags from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Post.
	 */
	public function getPostTagsJoinTag($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'lib/model/om/BasePostTagPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPostTags === null) {
			if ($this->isNew()) {
				$this->collPostTags = array();
			} else {

				$criteria->add(PostTagPeer::POST_ID, $this->getId());

				$this->collPostTags = PostTagPeer::doSelectJoinTag($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(PostTagPeer::POST_ID, $this->getId());

			if (!isset($this->lastPostTagCriteria) || !$this->lastPostTagCriteria->equals($criteria)) {
				$this->collPostTags = PostTagPeer::doSelectJoinTag($criteria, $con);
			}
		}
		$this->lastPostTagCriteria = $criteria;

		return $this->collPostTags;
	}

} // BasePost
