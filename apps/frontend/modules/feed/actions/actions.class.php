<?php
class feedActions extends sfActions {
    public function executeIndex() {
        $name = $this->getRequestParameter('tag', '');

        $c = new Criteria();

        if ($name) {
            $c->add(TagPeer::NAME, $name);
            $tag = TagPeer::doSelectOne($c);

            $this->forward404Unless($tag);

            $c->clear();
            $c->addJoin(PostTagPeer::POST_ID, PostPeer::ID, Criteria::LEFT_JOIN);
            $c->add(PostTagPeer::TAG_ID, $tag->getId());
        }

        $c->addDescendingOrderByColumn(PostPeer::CREATED_AT);
        $c->setLimit(sfConfig::get('app_posts_in_feed', 10));
        $c->add(PostPeer::DELETED, false);
        
        $posts = PostPeer::doSelect($c);

        $this->feed = $this->createFeed($posts, $name);
        
        ReaderPeer::increment();
    }

    protected function createFeed($posts, $tag) {
        $feed = new sfAtom1Feed();

        $feed->setTitle('Planeta PHP.pl' . (empty($tag) ? '' : ' - tag: ' . $tag));
        $feed->setLink('@homepage');
        $feed->setFeedUrl(empty($tag) ? '@feed' : '@feeds?tag=' . $tag);
        $feed->setAuthorEmail('planeta@poczta.php.pl');
        $feed->setAuthorName('Planeta PHP.pl');

        foreach ($posts as $post) {
            $item = new sfFeedItem();
            $item->setTitle($post->getTitle());
            $item->setLink($post->getLink());
            $item->setAuthorName($post->getBlog()->getAuthor());
            $item->setPubdate($post->getCreatedAt('U'));
            $item->setUniqueId($post->getLink());
            $item->setContent($post->getContent());
            $item->setCategories($post->getTagNames());

            $feed->addItem($item);
        }

        return $feed;
    }

}
