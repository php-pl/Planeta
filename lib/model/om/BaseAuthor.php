<?php


abstract class BaseAuthor extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $blog_id;


	
	protected $login;


	
	protected $password;


	
	protected $name;


	
	protected $email;


	
	protected $verified = false;


	
	protected $file;

	
	protected $aBlog;

	
	protected $collPosts;

	
	protected $lastPostCriteria = null;

	
	protected $collBlogs;

	
	protected $lastBlogCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getBlogId()
	{

		return $this->blog_id;
	}

	
	public function getLogin()
	{

		return $this->login;
	}

	
	public function getPassword()
	{

		return $this->password;
	}

	
	public function getName()
	{

		return $this->name;
	}

	
	public function getEmail()
	{

		return $this->email;
	}

	
	public function getVerified()
	{

		return $this->verified;
	}

	
	public function getFile()
	{

		return $this->file;
	}

	
	public function setId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = AuthorPeer::ID;
		}

	} 
	
	public function setBlogId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->blog_id !== $v) {
			$this->blog_id = $v;
			$this->modifiedColumns[] = AuthorPeer::BLOG_ID;
		}

		if ($this->aBlog !== null && $this->aBlog->getId() !== $v) {
			$this->aBlog = null;
		}

	} 
	
	public function setLogin($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->login !== $v) {
			$this->login = $v;
			$this->modifiedColumns[] = AuthorPeer::LOGIN;
		}

	} 
	
	public function setPassword($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->password !== $v) {
			$this->password = $v;
			$this->modifiedColumns[] = AuthorPeer::PASSWORD;
		}

	} 
	
	public function setName($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = AuthorPeer::NAME;
		}

	} 
	
	public function setEmail($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->email !== $v) {
			$this->email = $v;
			$this->modifiedColumns[] = AuthorPeer::EMAIL;
		}

	} 
	
	public function setVerified($v)
	{

		if ($this->verified !== $v || $v === false) {
			$this->verified = $v;
			$this->modifiedColumns[] = AuthorPeer::VERIFIED;
		}

	} 
	
	public function setFile($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->file !== $v) {
			$this->file = $v;
			$this->modifiedColumns[] = AuthorPeer::FILE;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->blog_id = $rs->getInt($startcol + 1);

			$this->login = $rs->getString($startcol + 2);

			$this->password = $rs->getString($startcol + 3);

			$this->name = $rs->getString($startcol + 4);

			$this->email = $rs->getString($startcol + 5);

			$this->verified = $rs->getBoolean($startcol + 6);

			$this->file = $rs->getString($startcol + 7);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 8; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Author object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(AuthorPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			AuthorPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(AuthorPeer::DATABASE_NAME);
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

	
	protected function doSave($con)
	{
		$affectedRows = 0; 		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;


												
			if ($this->aBlog !== null) {
				if ($this->aBlog->isModified()) {
					$affectedRows += $this->aBlog->save($con);
				}
				$this->setBlog($this->aBlog);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = AuthorPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += AuthorPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collPosts !== null) {
				foreach($this->collPosts as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collBlogs !== null) {
				foreach($this->collBlogs as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			$this->alreadyInSave = false;
		}
		return $affectedRows;
	} 
	
	protected $validationFailures = array();

	
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	
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

	
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


												
			if ($this->aBlog !== null) {
				if (!$this->aBlog->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aBlog->getValidationFailures());
				}
			}


			if (($retval = AuthorPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collPosts !== null) {
					foreach($this->collPosts as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collBlogs !== null) {
					foreach($this->collBlogs as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}


			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = AuthorPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
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
				return $this->getLogin();
				break;
			case 3:
				return $this->getPassword();
				break;
			case 4:
				return $this->getName();
				break;
			case 5:
				return $this->getEmail();
				break;
			case 6:
				return $this->getVerified();
				break;
			case 7:
				return $this->getFile();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = AuthorPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getBlogId(),
			$keys[2] => $this->getLogin(),
			$keys[3] => $this->getPassword(),
			$keys[4] => $this->getName(),
			$keys[5] => $this->getEmail(),
			$keys[6] => $this->getVerified(),
			$keys[7] => $this->getFile(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = AuthorPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
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
				$this->setLogin($value);
				break;
			case 3:
				$this->setPassword($value);
				break;
			case 4:
				$this->setName($value);
				break;
			case 5:
				$this->setEmail($value);
				break;
			case 6:
				$this->setVerified($value);
				break;
			case 7:
				$this->setFile($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = AuthorPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setBlogId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setLogin($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setPassword($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setName($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setEmail($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setVerified($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setFile($arr[$keys[7]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(AuthorPeer::DATABASE_NAME);

		if ($this->isColumnModified(AuthorPeer::ID)) $criteria->add(AuthorPeer::ID, $this->id);
		if ($this->isColumnModified(AuthorPeer::BLOG_ID)) $criteria->add(AuthorPeer::BLOG_ID, $this->blog_id);
		if ($this->isColumnModified(AuthorPeer::LOGIN)) $criteria->add(AuthorPeer::LOGIN, $this->login);
		if ($this->isColumnModified(AuthorPeer::PASSWORD)) $criteria->add(AuthorPeer::PASSWORD, $this->password);
		if ($this->isColumnModified(AuthorPeer::NAME)) $criteria->add(AuthorPeer::NAME, $this->name);
		if ($this->isColumnModified(AuthorPeer::EMAIL)) $criteria->add(AuthorPeer::EMAIL, $this->email);
		if ($this->isColumnModified(AuthorPeer::VERIFIED)) $criteria->add(AuthorPeer::VERIFIED, $this->verified);
		if ($this->isColumnModified(AuthorPeer::FILE)) $criteria->add(AuthorPeer::FILE, $this->file);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(AuthorPeer::DATABASE_NAME);

		$criteria->add(AuthorPeer::ID, $this->id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		return $this->getId();
	}

	
	public function setPrimaryKey($key)
	{
		$this->setId($key);
	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setBlogId($this->blog_id);

		$copyObj->setLogin($this->login);

		$copyObj->setPassword($this->password);

		$copyObj->setName($this->name);

		$copyObj->setEmail($this->email);

		$copyObj->setVerified($this->verified);

		$copyObj->setFile($this->file);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getPosts() as $relObj) {
				$copyObj->addPost($relObj->copy($deepCopy));
			}

			foreach($this->getBlogs() as $relObj) {
				$copyObj->addBlog($relObj->copy($deepCopy));
			}

		} 

		$copyObj->setNew(true);

		$copyObj->setId(NULL); 
	}

	
	public function copy($deepCopy = false)
	{
				$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new AuthorPeer();
		}
		return self::$peer;
	}

	
	public function setBlog($v)
	{


		if ($v === null) {
			$this->setBlogId(NULL);
		} else {
			$this->setBlogId($v->getId());
		}


		$this->aBlog = $v;
	}


	
	public function getBlog($con = null)
	{
				include_once 'lib/model/om/BaseBlogPeer.php';

		if ($this->aBlog === null && ($this->blog_id !== null)) {

			$this->aBlog = BlogPeer::retrieveByPK($this->blog_id, $con);

			
		}
		return $this->aBlog;
	}

	
	public function initPosts()
	{
		if ($this->collPosts === null) {
			$this->collPosts = array();
		}
	}

	
	public function getPosts($criteria = null, $con = null)
	{
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

				$criteria->add(PostPeer::AUTHOR_ID, $this->getId());

				PostPeer::addSelectColumns($criteria);
				$this->collPosts = PostPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(PostPeer::AUTHOR_ID, $this->getId());

				PostPeer::addSelectColumns($criteria);
				if (!isset($this->lastPostCriteria) || !$this->lastPostCriteria->equals($criteria)) {
					$this->collPosts = PostPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPostCriteria = $criteria;
		return $this->collPosts;
	}

	
	public function countPosts($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BasePostPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(PostPeer::AUTHOR_ID, $this->getId());

		return PostPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addPost(Post $l)
	{
		$this->collPosts[] = $l;
		$l->setAuthor($this);
	}


	
	public function getPostsJoinBlog($criteria = null, $con = null)
	{
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

				$criteria->add(PostPeer::AUTHOR_ID, $this->getId());

				$this->collPosts = PostPeer::doSelectJoinBlog($criteria, $con);
			}
		} else {
									
			$criteria->add(PostPeer::AUTHOR_ID, $this->getId());

			if (!isset($this->lastPostCriteria) || !$this->lastPostCriteria->equals($criteria)) {
				$this->collPosts = PostPeer::doSelectJoinBlog($criteria, $con);
			}
		}
		$this->lastPostCriteria = $criteria;

		return $this->collPosts;
	}

	
	public function initBlogs()
	{
		if ($this->collBlogs === null) {
			$this->collBlogs = array();
		}
	}

	
	public function getBlogs($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseBlogPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collBlogs === null) {
			if ($this->isNew()) {
			   $this->collBlogs = array();
			} else {

				$criteria->add(BlogPeer::AUTHOR_ID, $this->getId());

				BlogPeer::addSelectColumns($criteria);
				$this->collBlogs = BlogPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(BlogPeer::AUTHOR_ID, $this->getId());

				BlogPeer::addSelectColumns($criteria);
				if (!isset($this->lastBlogCriteria) || !$this->lastBlogCriteria->equals($criteria)) {
					$this->collBlogs = BlogPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastBlogCriteria = $criteria;
		return $this->collBlogs;
	}

	
	public function countBlogs($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseBlogPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(BlogPeer::AUTHOR_ID, $this->getId());

		return BlogPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addBlog(Blog $l)
	{
		$this->collBlogs[] = $l;
		$l->setAuthor($this);
	}

} 