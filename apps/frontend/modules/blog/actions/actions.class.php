<?php
class blogActions extends sfActions {
    /*
     * Formularz dodawania bloga
     */
    
    private function displayAddForm() {
        return 'Form';
    }
    
    public function executeAdd() {
        $this->redirectIf($this->getUser()->isAuthenticated(), 'ucp/index');
        
        if ($this->getRequest()->getMethod() == sfRequest::POST) {
            $blog = new Blog();
            $blog->setMid($this->getRequestParameter('mid'));
            $blog->setEmail($this->getRequestParameter('email'));
            $blog->setName($this->getRequestParameter('name'));
            $blog->setAuthor($this->getRequestParameter('author'));
            $blog->setUrl($this->getRequestParameter('url'));
            $blog->setFeed($this->getRequestParameter('feed'));
            $blog->setFile(substr(md5(rand()), 0, 16));
            $blog->save();

            $this->blog = $blog;
            
            return 'Done';
        }
        
        return $this->displayAddForm();
    }

    public function handleErrorAdd() {
        return $this->displayAddForm();
    }
    
    /*
     * Formularz weryfikacyjny 
     */
    
    private function displayVerificationForm() {
        $c = new Criteria();
        $c->add(BlogPeer::VERIFIED, false);
        $c->addAscendingOrderByColumn(BlogPeer::NAME); 
        
        $this->blogs = BlogPeer::doSelect($c);
        
        return 'Form';
    }
    
    public function executeVerification() {
        $this->redirectIf($this->getUser()->isAuthenticated(), 'ucp/index');
        
        if ($this->getRequest()->getMethod() == sfRequest::POST) {
            $blogId = $this->getRequestParameter('blog_id');
            
            $blog = BlogPeer::retrieveByPK($blogId);
            
            if (!$blog->getVerified()) {
                $blog->setMid($this->getRequestParameter('mid'));
                $blog->setEmail($this->getRequestParameter('email'));
                
                if ($blog->getFile() == '') {
                    $blog->setFile(substr(md5(rand()), 0, 16));
                }
                
                $blog->save();
                
                $this->blog = $blog;
                
                return 'Done';
            } else {
                $this->redirect('@homepage');
            }
        } else {
            return $this->displayVerificationForm();
        }
    }
    
    public function handleErrorVerification() {
        return $this->displayVerificationForm();
    }
    
    /*
     * Weryfikacja
     */
    
    public function executeVerify() {
        $this->redirectIf($this->getUser()->isAuthenticated(), 'ucp/index');
        
        $file = $this->getRequestParameter('file');
        
        $c = new Criteria();
        $c->add(BlogPeer::FILE, $file);
        
        $blog = BlogPeer::doSelectOne($c);
        
        if ($blog && !$blog->getVerified()) {
            $blog_url = $blog->getUrl();
            
            if ($blog_url[strlen($blog_url) - 1] != '/') {
                $blog_url .= '/';
            }
            
            $url = $blog_url . $file . '.html';
            
            $test1 = @fopen($url, 'r') !== false;
            $test2 = false;
            
            if (!$test1) {
                $contents = file_get_contents($blog_url);
                $test2 = preg_match('/<meta name="verify-phppl" content="' . $file . '" \/>/im', $contents);
            }
            
            if ($test1 || $test2) {
                $blog->setVerified(true);
                $blog->save();
                
                $this->setFlash('verified', true);
                $this->redirect('ucp/index');
            } else {
                $this->url = $url;
                $this->file = $file;
                
                return sfView::ERROR;
            }
        } else {
            $this->redirect('@homepage');
        }
    }   
    
    protected function sendVerificationEmail($blog) {
        $this->getRequest()->setParameter('email', $blog->getEmail());
        $this->getRequest()->setParameter('blog_name', $blog->getName());
        $this->getRequest()->setParameter('blog_url', $blog->getUrl());
        $this->getRequest()->setParameter('file_name', $blog->getFile());
        
        $this->sendEmail('mail', 'sendVerification');
    }
}
