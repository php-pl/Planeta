<?php
class TagPeer extends BaseTagPeer {
    public static function getForCloud() {
        $connection = Propel::getConnection(self::DATABASE_NAME);
        
        $query = 'SELECT %5$s as name, COUNT(%3$s) AS count FROM `%1$s` ';
        $query .= 'LEFT JOIN `%2$s` ON %3$s = %4$s GROUP BY %4$s ORDER BY %5$s ASC';
        $query = sprintf($query, self::TABLE_NAME, PostTagPeer::TABLE_NAME, PostTagPeer::TAG_ID, self::ID, self::NAME);
        
		$statement = $connection->prepareStatement($query);
		$rs = $statement->executeQuery();
        
		$tags = array();
		
        while ($rs->next()) {
            $tag = new Tag();
            
            $tag->setName($rs->getString('name'));
            $tag->setCount($rs->getInt('count'));
            
            $tags[] = $tag;
        }
        
        return $tags;
    }
    
    public static function getApproved(Criteria $c = null) {
        if ($c == null) {
            $c = new Criteria();
        }
        
        $c->add(TagPeer::APPROVED, true);
        
        $tags = parent::doSelect($c);
        $ret = array();
        
        foreach ($tags as $tag) {
            $ret[] = $tag->getName();
        }
        
        return $ret;
    }
    
    public static function retriveByName($name, $approved = null, Criteria $c = null) {
        if ($c == null) {
            $c = new Criteria();
        }
        
        $c->add(TagPeer::NAME, $name);
        
        if (isset($approved)) {
            $c->add(TagPeer::APPROVED, $approved);
        }
        
        return parent::doSelectOne($c);
    }
}
