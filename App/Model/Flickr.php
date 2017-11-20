<?php

namespace App\Model;

use Lib\Curl\Client;

/**
 * @brief   Fetch images from api and parse it
 */
class Flickr
{
    /**
     * @var string LIST_URI
     */
    const FEED_LIST_URI     = 'https://api.flickr.com/services/feeds/photos_public.gne?tags=chamonix,ski,snow';
    
    /**
     * @var string FEED_LIST_URI
     */
    const  REST_LIST_URI    = 'https://api.flickr.com/services/feeds/photos_public.gne?format=json&tags=chamonix,ski,snow';
    
    /**
     * @var \Lib\Curl\Client $client
     */
    private $client;
    
    public function __construct()
    {
        $this->client = new Client();
    }
    
    /**
     * @brief   Fetch images from api service
     * 
     * @return  array
     */
    public function getList()
    {
        if(FEED_TYPE === 'xml')
        {
            return $this->parseXmlData();
        }
        else
        {
            return $this->parseJsonData();
        }
    }
    
    /**
     * @brief   Parse json feed
     * 
     * @return  array
     */
    private function parseJsonData()
    {
        $parsedData         = array();
        $result             = $this->client->execute( self::REST_LIST_URI );
        
        $responseString     = str_replace(array("\n", "\t"), '', $result);
        preg_match('/^jsonFlickrFeed\((.*)\)/i', $responseString, $matches);
        $flickrJson         = $matches[1];
        $flickrData         = json_decode($flickrJson, true);
        $flickrJsonError    = json_last_error();
        
        if($flickrJsonError !== JSON_ERROR_NONE)
        {
            throw new \RuntimeException('Invlid json data');
        }
        
        foreach($flickrData['items'] as $item )
        {
            $author         = $item['author'];
            preg_match('/\(([^\)]*)\)/', $author, $matches);
            $author         = isset($matches[1]) ? $matches[1] : $author;
            
            $parsedData[]   = array(
                'author'    => $author,
                'title'     => $item['title'],
                'href'      => $item['link'],
                'img'       => $item['media']['m']
            );
        }
        
        return $parsedData;
    }
    
    /**
     * @brief   Parse xml feed
     * 
     * @return  array
     */
    private function parseXmlData()
    {
        $parsedData = array();
        $result     = $this->client->execute( self::FEED_LIST_URI );
        
        $data        = simplexml_load_string($result);
        if($data === false)
        {
            throw new \Exception('Invalid xml source');
        }
        
        $entries    = $data->entry;
        foreach($entries as $entry)
        {
            $content    = $entry->content;
            preg_match('/< *img[^>]*src *= *["\']?([^"\']*)/i', $content, $matches);
            $image      = isset($matches[1]) ? $matches[1] : '';
            
            $href       = '';
            foreach($entry->link[1]->attributes() as $key => $value)
            {
                if($key === 'href')
                {
                    $href  = $value;
                    break;
                }
            }
            
            $parsedData[]   = array(
                'author'    => (string) $entry->author->name[0],
                'title'     => (string) $entry->title[0],
                'href'      => (string) $href,
                'img'       => (string) $image
            );
        }
        
        return $parsedData;
    }
}
