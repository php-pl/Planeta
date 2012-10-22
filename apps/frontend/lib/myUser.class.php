<?php
class myUser extends sfBasicSecurityUser {
	public function getId() {
		return $this->getAttribute('id', '', 'user');
	}
	
	public function getMid() {
	    return $this->getAttribute('mid', '', 'user');
	}
	
	public function getName() {
	    return $this->getAttribute('name', '', 'user');
	}
	
	public function setName($name) {
	    $this->setAttribute('name', $name, 'user');
	}
	
	public function getBlog() {
		return BlogPeer::retrieveByPk($this->getId());
	}

	public function login(Blog $blog) {
		$this->setAuthenticated(true);
		
		$this->setAttribute('id', $blog->getId(), 'user');
		$this->setAttribute('mid', $blog->getMid(), 'user');
		$this->setAttribute('name', $blog->getAuthor(), 'user');
	}
	
	public function logout() {
		$this->getAttributeHolder()->removeNamespace('user');
		
		$this->setAuthenticated(false);
	}
}
