<?php
class myPasswordValidator extends sfValidator {
    public function initialize($context, $parameters = null) {
        parent::initialize($context);
        
        $this->setParameter('password_error', 'Incorrect password');
        $this->getParameterHolder()->add($parameters);

        return true;
    }

    public function execute(&$value, &$error) {
        $user = $this->getContext()->getUser()->getUser();
        $password = $value;

        if (md5($password) == $user->getPassword()) {	
            return true;
        } else {
            $error = $this->getParameter('password_error');
            return false;
        }
    }
}