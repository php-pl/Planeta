<?php
class mailActions extends sfActions {
    public function executeRejected() {
        $this->blog = BlogPeer::retrieveByPK($this->getRequestParameter('id'));
        $this->data = $this->getRequestParameter('data');
        
        $this->mail = new sfMail();
        $this->mail->addAddress($this->blog->getEmail());
        $this->mail->setFrom('Planeta PHP.pl <planeta@poczta.php.pl>');
        $this->mail->setSubject('Odrzucenie bloga');
        $this->mail->setPriority(1);
    }
    
    public function executeApproved() {
        $this->blog = BlogPeer::retrieveByPK($this->getRequestParameter('id'));
        
        $this->mail = new sfMail();
        $this->mail->addAddress($this->blog->getEmail());
        $this->mail->setFrom('Planeta PHP.pl <planeta@poczta.php.pl>');
        $this->mail->setSubject('Zatwierdzenie bloga');
        $this->mail->setPriority(1);
    }
}
