<?php
class myUser extends sfBasicSecurityUser {
	
	public function getMid() {
	    return $this->getAttribute('mid', '', 'admin');
	}
	
	public function getEmail() {
	    return $this->getAttribute('email', '', 'admin');
	}
	
	/*
	 * @return Admin Rekord reprezentujący zalogowanego administratora
	 */
	public function getAdmin() {
		return AdminPeer::retrieveByPk($this->getMid());
	}

	public function login(Admin $admin) {
		$this->setAuthenticated(true);
		
		$this->setAttribute('mid', $admin->getMid(), 'admin');
		$this->setAttribute('email', $admin->getEmail(), 'admin');
	}
	
	public function logout() {
		$this->getAttributeHolder()->removeNamespace('admin');
		
		$this->setAuthenticated(false);
	}
	
    public function isAuthenticated() {
        return (bool)$this->getAdmin();
    }
}
