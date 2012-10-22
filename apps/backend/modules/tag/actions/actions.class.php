<?php
class tagActions extends autotagActions {
    public function executeToggleApproved() {
        $tag = TagPeer::retrieveByPK($this->getRequestParameter('id'));

        $this->forward404Unless($tag);
        
        $tag->setApproved(!$tag->getApproved());
        $tag->save();
        
        $this->redirect('tag/index');
    }
}
