<?php
class Tag extends BaseTag {
    protected $size;
    protected $count;

    public function __toString() {
        return $this->getName();
    }
    
    public function getSize() {
        return $this->size;
    }
    
    public function setSize($size) {
        $this->size = $size;
    }
    
    public function getCount() {
        return $this->count;
    }
    
    public function setCount($count) {
        $this->count = $count;
    }
    
    public static function tagize($string) {
        $string = StringUtils::removeAccents($string);
        $string = strtolower($string);
        $string = str_replace(' ', '_', $string);
        
        return $string;
    }
}
