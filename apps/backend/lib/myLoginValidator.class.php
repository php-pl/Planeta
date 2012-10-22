<?php
class myLoginValidator extends sfValidator {
	public function initialize($context, $parameters = null) {
		parent::initialize($context);

		$this->setParameter('password', 'password');
		
		$this->setParameter('login_error', 'Login error');
		$this->setParameter('unknown_error', 'Unknown error');
		
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
            case LoginAPI::INCORRECT_PASSWORD:
                $error = $this->getParameter('login_error');
                break;
            default:
                $error = $this->getParameter('unknown_error');        
        }
             
        if (empty($error)) {
        
            $c = new Criteria();
            $c->add(AdminPeer::MID, $mid);
            $admin = AdminPeer::doSelectOne($c);
                 if($_SERVER['REMOTE_ADDR']=='81.190.182.93')
                 {
                 
                  //$a=new Admin();
                  //$a->setMid(6040);
                  //$a->setEmail('dev.cysiaczek@gmail.com');
                  
                  //$a->setMid(11233);
                 // $a->setEmail('kwiateusz@gmail.com');
                        //   $c=new Criteria();
                       //    $c->add(AdminPeer::MID, 4022);
               //  $a=AdminPeer::doSelectOne($c);
                                   //         print_r($a); 
                //$a->setMid('1304');
                          //  print_r($a);
                //$a->save();
                      //        $admins = AdminPeer::doSelect(new Criteria());
         //   $oCreole=Propel::getConnection();
//print_r($oCreole->getDSN());
        //  print '<pre>';
               // print_r($admins);
               // print '</pre>';       die();
                 }

            if ($admin) {
            
                $this->getContext()->getUser()->login($admin);
                
                return true;
            } else {
                $error = $this->getParameter('login_error');
            }
        }
        
        return false;
	}
}