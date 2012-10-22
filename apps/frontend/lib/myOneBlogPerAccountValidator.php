<?php
class myOneBlogPerAccountValidator extends sfValidator {
    public function initialize($context, $parameters = null) {
        parent::initialize($context);
        
        $this->setParameter('msg', 'You\'ve already registered your blog.');
        $this->getParameterHolder()->add($parameters);

        return true;
    }

    public function execute(&$value, &$error) {
        $mid = $this->getContext()->getRequest()->getParameter('mid');
        
        $c = new Criteria();
        $c->add(BlogPeer::MID, $mid);
        
        $blog = BlogPeer::doSelectOne($c);
        
        if ($blog) {
            $error = $this->getParameter('msg');
            
            return false;
        }
        
        return true;
    }    
}