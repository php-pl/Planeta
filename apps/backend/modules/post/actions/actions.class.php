<?php
class postActions extends autopostActions {
    public function executeDelete() {
        $post = PostPeer::retrieveByPk($this->getRequestParameter('id'));
        $this->forward404Unless($post);
        
        $post->setDeleted(true);
        $post->save();
        
        $this->redirect('post/list');
    }
    
    public function addFiltersCriteria($c) {
        $c->add(PostPeer::DELETED, false);
    }
}
