<?php
class ucpActions extends sfActions {
    public function executeIndex() {
        $blog = $this->getUser()->getBlog();
        
        if (!$blog->getApproved()) {
            $this->blog = $blog;
            
            return 'NotApproved';
        }
        
        $c = new Criteria();
        $c->add(PostPeer::BLOG_ID, $this->getUser()->getId());
        $c->add(PostPeer::DELETED, false);
        $c->addDescendingOrderByColumn(PostPeer::CREATED_AT);
        $c->setLimit(10);
        
        $this->posts = PostPeer::doSelect($c);
    }
    
    public function executeEdit() {
        $user = $this->getUser();
        $blog = $user->getBlog();
        
        $this->forwardUnless($blog->getApproved(), 'ucp', 'index');
        
        if ($this->getRequest()->getMethod() == sfRequest::POST) {
            $blog->setName(htmlspecialchars($this->getRequestParameter('name'), ENT_NOQUOTES));
            $blog->setAuthor(htmlspecialchars($this->getRequestParameter('author'), ENT_NOQUOTES));
            $blog->setUrl($this->getRequestParameter('url'));
            $blog->setFeed($this->getRequestParameter('feed'));
            
            $blog->save();
            $user->setName($blog->getAuthor());
            $this->setFlash('updated', 'Dane zostały zapisane.');
            
            return $this->redirect('ucp/index');
        } else {
            $this->blog = $blog;
        }
    }
    
    public function handleErrorEdit() {
        $this->blog = $this->getUser()->getBlog();
         
        return sfView::SUCCESS;
    }
    
    public function validateTag() {
        if ($this->getRequest()->getMethod() == sfRequest::POST) {
            $tag = Tag::tagize($this->getRequestParameter('name'));
            
            if (strlen($tag) > 16) {
                $this->getRequest()->setError('name', 'Tag może mieć maksymalnie 16 znaków'); 
                return false;
            }
            
            $validator = new sfPropelUniqueValidator();
            $validator->initialize($this->getContext(), array(
                'unique_error'  => 'Tag o tej nazwie już istnieje!',
                'class'         => 'Tag',
                'column'        => 'name',
            ));
            
            if (!$validator->execute($tag, $error)) {
                $this->getRequest()->setError('name', $error);
                
                return false;
            }
        }
        
        return true;
    }
    
    public function executeTag() {
        $this->forwardUnless($this->getUser()->getBlog()->getApproved(), 'ucp', 'index');
        
        if ($this->getRequest()->getMethod() == sfRequest::POST) {
            $tag = new Tag();
            $tag->setName(Tag::tagize($this->getRequestParameter('name')));
            $tag->save();
            
            $this->setFlash('updated', 'Tag został zgłoszony do dodania.');
            
            return $this->redirect('ucp/index');
        }
    }
    
    public function handleErrorTag() {
        return sfView::SUCCESS;
    }
    
    public function executeLogin() {
        $this->redirectIf($this->getUser()->isAuthenticated(), 'ucp');
        
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
}
