<?php

/**
 * Subclass for representing a row from the 'blog' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Blog extends BaseBlog {
    public function __toString() {
        return $this->getName();
    }
    
    public function setUrl($url) {
        if ($url[strlen($url) - 1] != '/' && !strstr($url,'.htm')) {
            $url .= '/';
        }
        
        parent::setUrl($url);
    }
    
    public function getUrlWithEndingSlash() {
        $url = $this->url;
        
        if ($url[strlen($url) - 1] != '/') {
            $url .= '/';
        }
        
        return $url;
    }
}
