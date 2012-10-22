<?php
class myVerificationValidator extends sfValidator {
    public function initialize($context, $parameters = null) {
        parent::initialize($context);

        $this->setParameter('password', 'password');
        
        $this->setParameter('login_error', 'Invalid input');
        $this->setParameter('password_error', 'Invalid input');
        $this->setParameter('inactive_error', 'Your forum account is inactive.');
        $this->setParameter('unknown_error', 'Unknown  error');
        
        $this->getParameterHolder()->add($parameters);

        return true;
    }

    public function execute(&$value, &$error) {
        $login = $value;
        $password = $this->getContext()->getRequest()->getParameter($this->getParameter('password'));
        
        $api = new LoginAPI(sfConfig::get('app_loginapi_login'), sfConfig::get('app_loginapi_key'), $login, $password);
        
        switch ($api->getCode()) {
            case LoginAPI::OK:
                $this->getContext()->getRequest()->setParameter('mid', $api->getId());
                $this->getContext()->getRequest()->setParameter('email', $api->getEmail());
                return true;
            case LoginAPI::NON_EXISTENT:
                $error = $this->getParameter('login_error');
                break;
            case LoginAPI::INACTIVE: 
                $error = $this->getParameter('inactive_error');
                break;
            case LoginAPI::INCORRECT_PASSWORD:
                $error = $this->getParameter('password_error');
                break;
            default:
                $error = $this->getParameter('unknown_error');        
        }

        return false;
    }
}