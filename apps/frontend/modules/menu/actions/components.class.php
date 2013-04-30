<?php
class menuComponents extends sfComponents {
    public function executeHeader() {
        $url = 'http://php.pl/uslugi/Links.php?output';
        $tmp = SF_ROOT_DIR . '/cache/links.tmp';
        
        if (file_exists($tmp)) {
            if (filemtime($tmp) + 3600 > time()) {
                $links = unserialize(file_get_contents($tmp));
            } else {
                $data = @file_get_contents($url);
                $links = @unserialize($data);

                if (is_array($links)) {
                    file_put_contents($tmp, $data);
                } else {
                    $links = unserialize(file_get_contents($tmp));
                }
            }
        } else {
            $data = @file_get_contents($url);
            $links = @unserialize($data);
             
            if (is_array($links)) {
                file_put_contents($tmp, $data);
            } else {
                throw new Exception('Nie udało się pobrać pliku z danymi do menu, a plik tymczasowy nie istnieje.');
            }
        }
        
        $this->links = $links;
    }

    public function executeBlogs() {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(BlogPeer::NAME);
        $c->add(BlogPeer::APPROVED, true);

        $this->blogs = BlogPeer::doSelect($c);
    }

    public function executeArchives() {
        $rs = PostPeer::getArchivesRS();

        $months = array();

        while ($rs->next()) {
            $month = array();

            $month['m'] = $rs->getInt('m');
            $month['y'] = $rs->getInt('y');
            $month['f'] = strftime('%B %Y', strtotime(sprintf('%d-%d-01', $month['y'], $month['m'])));

            $months[] = $month;
        }

        $this->months = $months;
        $this->limit = sfConfig::get('app_menu_max_archives_links');
        $this->count = count($months);
        $this->max = $this->count > $this->limit ? $this->limit : $this->count;
    }

    public function executeTagCloud() {
        $count = PostTagPeer::doCount(new Criteria());
        $tags = TagPeer::getForCloud();

        if (!empty($tags) && $count > 0) {
            foreach ($tags as &$tag) {
                $p = (float) $tag->getCount() / $count;

                if ($p > 0.3) {
                    $tag->setSize('2.0');
                } elseif ($p > 0.25) {
                    $tag->setSize('1.8');
                } elseif ($p > 0.20) {
                    $tag->setSize('1.6');
                } elseif ($p > 0.15) {
                    $tag->setSize('1.4');
                } else {
                    $tag->setSize('1.0');
                }
            }

            $this->tags = $tags;
        } else {
            $this->tags = array();
        }
    }

    public function executeStats() {
        $stats = array();
        $c = new Criteria();

        // readers_cnt
        $date = date('Y-m-d', strtotime('-1 day'));

        $c->clear();
        $c->add(ReaderPeer::DATE, $date);
        $readers = ReaderPeer::doSelectOne($c);

        $cnt = $readers ? $readers->getCnt() : 0;

        $tcnt = $cnt % 100;
        $str = '';

        if ($tcnt == 1) {
            $str = 'osoba';
        } else if ($tcnt >= 12 && $tcnt <= 14) {
            $str = 'osób';
        } else if (($tcnt % 10) > 1 && ($tcnt % 10) < 5) {
            $str = 'osoby';
        } else {
            $str = 'osób';
        }

        $stats['reader_cnt'] = $cnt == 0 ? 'brak danych' : sprintf('%d %s', $cnt, $str);

        // blog_cnt
        $c->clear();
        $c->add(BlogPeer::APPROVED, true);
        $stats['blog_cnt'] = BlogPeer::doCount($c);

        // post_cnt
        $c->clear();
        $c->add(PostPeer::DELETED, false);
        $stats['post_cnt'] = PostPeer::doCount($c);

        // month_avg
        $c->clear();
        $c->addAscendingOrderByColumn(PostPeer::CREATED_AT);

        $post = PostPeer::doSelectOne($c);

        $ots = $post ? $post->getCreatedAt(null) : time();

        $years = date('Y') - date('Y', $ots);
        $months = $years * 12 + (date('n') - date('n', $ots));

        $stats['month_avg'] = $months > 0 ? round($stats['post_cnt'] / $months) : 0;

        // assign
        $this->stats = $stats;
    }
}
?>