<?php
class myLoginValidator extends sfValidator {
	public function initialize($context, $parameters = null) {
		parent::initialize($context);

		$this->setParameter('password', 'password');
		
		$this->setParameter('login_error', 'Invalid input');
		$this->setParameter('password_error', 'Invalid input');
		$this->setParameter('no_blog_error', 'Your blog was not added.');
		$this->setParameter('not_verified_error', 'Your ownership of the blog was not vertified');
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
                $mid = $api->getId();
                break;
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
        
        if (empty($error)) {
            $c = new Criteria();
            $c->add(BlogPeer::MID, $mid);
            $blog = BlogPeer::doSelectOne($c);
            
            if ($blog) {
                if ($blog->getVerified()) {
                    $this->getContext()->getUser()->login($blog);
                    
                    return true;
                } else {
                    $error = $this->getParameter('not_verified_error');
                }
            } else {
                $error = $this->getParameter('no_blog_error');
            }
        }
        
        return false;
	}
}