<?php
class blogActions extends autoblogActions {
    public function executeApprove() {
        $blog = BlogPeer::retrieveByPK($this->getRequestParameter('id'));

        $this->forward404Unless($blog);
        
        if ($blog->getApproved()) {
            $this->setFlash('error', 'Blog jest już zatwierdzony.');
            $this->redirect('blog/index');
        }
        
        if (!$blog->getVerified()) {
            $this->setFlash('error', 'Blog nie został jeszcze zweryfikowany.');
            $this->redirect('blog/index');
        }

        
        $blog->setApproved(true);
        $blog->save();
        
        $mail = $this->sendEmail('mail', 'approved');
        $this->logMessage($mail, 'debug');
        
        $this->setFlash('notice', 'Blog został zatwierdzony');
        
        $this->redirect('blog/index');
    }
    
    public function executeReject() {
        $this->blog = BlogPeer::retrieveByPK($this->getRequestParameter('id'));

        $this->forward404Unless($this->blog);
        
        if (!$this->blog->getVerified()) {
            $this->setFlash('error', 'Blog nie został jeszcze zweryfikowany.');
            $this->redirect('blog/index');
        }
        
        if ($this->getRequest()->getMethod() == sfRequest::POST) {
            $data = $this->getRequestParameter('data');
            
            if (isset($data['delete'])) {
                $this->blog->delete();
            } else {
                $this->blog->setApproved(false);
                $this->blog->save();
            }

            $mail = $this->sendEmail('mail', 'rejected');
            $this->logMessage($mail, 'debug');
            
            $this->setFlash('notice', 'Blog został odrzucony');
            
            $this->redirect('blog/index');
        }
    }
    
    public function handleErrorReject() {
        $this->blog = BlogPeer::retrieveByPK($this->getRequestParameter('id'));

        $this->forward404Unless($this->blog);
        
        return sfView::SUCCESS;
    }
}
