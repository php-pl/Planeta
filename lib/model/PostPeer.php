<?php

/**
 * Subclass for performing query and update operations on the 'post' table.
 *
 * 
 *
 * @package lib.model
 */ 
class PostPeer extends BasePostPeer {
    public static function getNewestTimestamp(Blog $blog) {
        $c = new Criteria();
        $c->addDescendingOrderByColumn(PostPeer::CREATED_AT);
        $c->add(PostPeer::BLOG_ID, $blog->getId());
        
        $post = PostPeer::doSelectOne($c);
        
        return $post ? $post->getCreatedAt(null) : 0;
    }
    
    public static function getArchivesRS() {
        $connection = Propel::getConnection(self::DATABASE_NAME);
        $query = 'SELECT DISTINCT MONTH(%1$s) AS m, YEAR(%1$s) AS y FROM `%2$s` WHERE %3$s=0 ORDER BY %1$s DESC';
        $query = sprintf($query, PostPeer::CREATED_AT, PostPeer::TABLE_NAME, PostPeer::DELETED);
        $statement = $connection->prepareStatement($query);
        
        return $statement->executeQuery();
    }
}
