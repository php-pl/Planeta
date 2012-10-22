<?php
abstract class FeedParser {
    protected $items = array();
    protected $type = '';
    
    abstract public function execute(SimpleXMLElement $xml);
    
    public static function parse($url) {
        $xml = @new SimpleXMLElement($url, LIBXML_NOERROR | LIBXML_NOWARNING, true);

        if (!$xml) {
            $error = error_get_last();
            
            throw new Exception($error['message']);
        }
        
        switch ($xml->getName()) {
            case 'feed': 
                $parser = new AtomFeedParser();
                break;
                
            case 'rss':
                $parser = new RSSFeedParser();
                break;
                
            default:
                throw new Exception('Unknown feed type!');
                break;
        }
        
        $parser->execute($xml);
        
        return $parser->getItems();
    }

    public function getItems() {
        return $this->items;
    }
}

class RSSFeedParser extends FeedParser {
    public function execute(SimpleXMLElement $xml) {
        foreach ($xml->channel->item as $entry) {
            $item = new FeedItem();
            
            $item->title = (string)$entry->title;
            $item->link = (string)$entry->link;
            $item->pubdate = strtotime($entry->pubDate);
            
            $content = $entry->children('http://purl.org/rss/1.0/modules/content/');
            
            if ($content) {
                $item->content = (string)$content->encoded;
            } else {
                $item->content = (string)$entry->description;
            }
            
            foreach ($entry->category as $category) {
                $tag = Tag::tagize(((string)$category));
                
                if (!in_array($tag, $item->tags)) {
                    $item->tags[] = $tag;
                }
            }
            
            $this->items[] = $item;
        }
    }
}

class AtomFeedParser extends FeedParser {
    public function execute(SimpleXMLElement $xml) { 
        foreach ($xml->entry as $entry) {
            $item = new FeedItem();
            
            $item->title = $entry->title;
            $item->pubdate = strtotime($entry->updated ? $entry->updated : $entry->published);

            if ($entry->content) {
                switch ($entry->content['type']) {
                    case 'xhtml':
                        $item->content = str_replace('<div xmlns="http://www.w3.org/1999/xhtml">', '', $entry->content->div->asXml());
                        $item->content = preg_replace('/\<\/div\>$/', '', $item->content);
                        break;
                        
                    default:
                        $item->content = $entry->content;
                }
            } else {
                $item->content = $entry->summary;
            }

            foreach ($entry->link as $link) {
                if ($link['rel'] == 'alternate') {
                    $item->link = $link['href'];
                    break;
                }
            }

            foreach ($entry->category as $category) {
                $tag = Tag::tagize((string)$category['term']);
                
                if (!in_array($tag, $item->tags)) {
                    $item->tags[] = $tag;
                }
            }
            
            $this->items[] = $item;
        }
    }
}

class FeedItem {
    public $title = '';
    public $link = '';
    public $pubdate = '';
    public $tags = array();
    public $content = '';
}

?>