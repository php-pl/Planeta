<?php

/**
 * Subclass for performing query and update operations on the 'blog' table.
 *
 * 
 *
 * @package lib.model
 */ 
class BlogPeer extends BaseBlogPeer {
    public static function getApproved() {
        $c = new Criteria();
        $c->add(BlogPeer::APPROVED, true);
        
        return parent::doSelect($c);
    }
}
