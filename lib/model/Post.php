<?php
class Post extends BasePost {
	public function setCreatedAt($v) {
	    parent::setCreatedAt($v);
	    
	    $this->setYear(date('Y', $this->getCreatedAt(null)));
	    $this->setMonth(date('n', $this->getCreatedAt(null)));
	}
    
	public function removeTags() {
	    $c = new Criteria();
	    $c->add(PostTagPeer::POST_ID, $this->getId());
	    
	    PostTagPeer::doDelete($c);
	}
	
    public function getTags() {
        $tags = array();

        foreach ($this->getPostTagsJoinTag(new Criteria()) as $ref) {
            $tags[] = $ref->getTag();
        }
	   
        return $tags;
	}
	
	public function getTagNames() {
        $tags = array();

        foreach ($this->getPostTagsJoinTag(new Criteria()) as $ref) {
            $tags[] = $ref->getTag()->getName();
        }
	   
        return $tags;
	}
	
	public function setFullContent($content) {
	    $max_p = sfConfig::get('app_content_max_p');
        $max_br = sfConfig::get('app_content_max_br');
        $shortened = false;
         
        $tmp = explode('</p>', $content);
        $cnt = count($tmp);

        if ($cnt > $max_p) {
            $tmp = array_slice($tmp, 0, $max_p);
            $tmp = implode('</p>', $tmp) . '</p>';
            $shortened = true;
        } else {
            $tmp = explode('<br />', $content);
            $cnt = count($tmp);
             
            if ($cnt > $max_br) {
                $tmp = array_slice($tmp, 0, $max_br);
                $tmp = implode('<br />', $tmp) . '</p>';
                $shortened = true;
            }
        }
        
        if ($shortened) {
	        $this->setContent($tmp); 
            $this->setContentMore(str_replace($tmp, '', $content));
	        
            return true;
        } else {
            $this->setContent($content);
            
            return false;
        }
	}
	
	public function addTag($tag) {
	    if ($tag) {
		    $pt = new PostTag();
			$pt->setTag($tag);
	
			$this->addPostTag($pt);
			
			return true;
		}
		
		return false;
	}
	
	public function hasTags() {
	    return count($this->collPostTags) > 0;
	}
}
