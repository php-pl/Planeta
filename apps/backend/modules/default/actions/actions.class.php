<?php
class defaultActions extends sfActions {
    public function executeIndex() {
        $this->forward('blog', 'list');
    }
    
    public function executeLogin() {

        if ($this->getRequest()->getMethod() != sfRequest::POST) {
            $r = sfRouting::getInstance();
            
            if ($r->getCurrentRouteName() == 'login') {
                $this->getRequest()->setAttribute('referer', $this->getRequest()->getReferer());
            } else {
                $this->getRequest()->setAttribute('referer', $r->getCurrentInternalUri());
            }
        } else {
            $this->redirect($this->getRequestParameter('referer', '@homepage'));
        }
    }
    
    public function handleErrorLogin() {
        return sfView::SUCCESS;
    }

    public function executeLogout() {
        $this->getUser()->logout();
        $this->redirect('@homepage');
    }
    
    public function executeError404() {}
}
