<?php
class postActions extends sfActions { 
    public function executeList() {
        $type = $this->getRequestParameter('type', 'all');

        $c = $this->{'list' . $type}();
        $c->addDescendingOrderByColumn(PostPeer::CREATED_AT);
        $c->add(PostPeer::DELETED, false);
        
        $pager = new sfPropelPager('Post', sfConfig::get('app_post_per_page', 7));
        $pager->setCriteria($c);
        $pager->setPage($this->getRequestParameter('page', 1));
        $pager->setPeerMethod('doSelectJoinAll');
        $pager->init();
        
        $this->pager = $pager;
        
        $r = sfRouting::getInstance();
        $this->iuri = $r->getCurrentRouteName() == 'homepage' ? '@posts?page=1' : $r->getCurrentInternalUri(true);
    }
    
    public function executeMore() {
        header('Content-type: text/html; charset=UTF-8');
        
        if (!$this->getRequest()->isXmlHttpRequest()) {
            $this->redirect404();
        }
        
        $post = PostPeer::retrieveByPK($this->getRequestParameter('id'));
        
        if ($post) {
            return $this->renderText($post->getContentMore());
        } else {
            return $this->renderText('');
        }
    }
    
    public function executeDelete() {
        $post = PostPeer::retrieveByPK($this->getRequestParameter('id'));
        $blog = $post->getBlog();
        
        $this->forward404Unless($blog->getId() == $this->getUser()->getId());
        
        if ($post) {
            $post->setDeleted(true);
            $post->save();
        }
        
        $this->redirect('ucp/index');
    }
    
    public function executeRefresh() {
        $post = PostPeer::retrieveByPK($this->getRequestParameter('id'));
        $blog = $post->getBlog();
        
        $this->forward404Unless($blog->getId() == $this->getUser()->getId());
        
        if ($post) {
            try {
                $items = FeedParser::parse($blog->getFeed());

                foreach ($items as $item) {
                    if ($item->link == $post->getLink()) {
                        $post->removeTags();
                        
                        foreach ($item->tags as $name) {
                            $tag = TagPeer::retriveByName($name, true);
                            $post->addTag($tag);
                        }
                
                        if ($post->hasTags()) {
                            $shortened = $post->setFullContent($item->content);
                             
                            $post->setLink($item->link);
                            $post->setTitle($item->title);
                            $post->setCreatedAt($item->pubdate);
                            $post->setShortened($shortened);
                            $post->save();
                        }
                        
                        break;
                    }
                }
                
                $this->setFlash('updated', 'Wpis został odświeżony.');
            } catch (Exception $e) {
                $this->setFlash('updated', 'Odswieżanie wpisu nie powiodło się.');
            }
        }
        
        $this->redirect('ucp/index');
    }
    
    private function listAll() {
        $this->getResponse()->setTitle('Planeta PHP.pl - Strona główna');
        
        return new Criteria();
    }
    
    private function listTags() {
        $c = new Criteria();
        $c->add(TagPeer::NAME, $this->getRequestParameter('name'));
        $tag = TagPeer::doSelectOne($c);
        
        $this->getResponse()->setTitle(sprintf('Planeta PHP.pl - Wpisy dla tagu: %s', $tag->getName()));
        
        $c = new Criteria();
        $c->addJoin(PostTagPeer::POST_ID, PostPeer::ID, Criteria::LEFT_JOIN);
        $c->add(PostTagPeer::TAG_ID, $tag->getId());
        
        return $c;
    }
    
    private function listArchives() {
        $year = (int)$this->getRequestParameter('year');
        $month = (int)$this->getRequestParameter('month');
        
        $this->getResponse()->setTitle(sprintf('Planeta PHP.pl - Archiwum: %s', strftime('%B %Y', strtotime(sprintf('%d-%d-01', $year, $month)))));
        
        $c = new Criteria();
        $c->add(PostPeer::YEAR, $year);
        $c->add(PostPeer::MONTH, $month);
        
        return $c;
    }
}
