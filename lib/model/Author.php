<?php
class Author extends BaseAuthor {
    public function setPassword($password) {
        parent::setPassword(md5($password));
    }
}
