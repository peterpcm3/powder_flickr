<?php

namespace Lib\Template;

/**
 * @brief   Template render
 */
class Template
{
    /**
     * @var string HTTP_JSON
     */
    const HTTP_JSON = 'application/json';
    
    /**
     * @var string HTTP_HTML
     */
    const HTTP_HTML = 'text/htm';
    
    /**
     * @var string $source
     */
    private $source;
    
    /**
     * @var string $type
     */
    private $type;
    
    /**
     * @var array $data
     */
    private $data;
    
    /**
     * @brief   Init template file
     * 
     * @param   string $source
     */
    public function __construct( $type = self::HTTP_HTML )
    {
        $this->type     = $type;
    }
    
    /**
     * @brief   Render template data
     * 
     * @param   array $data
     * @param   string $type
     * 
     * @return  void
     */
    public function renderFile( $source = '', array $data = array() )
    {
        $this->source   = $source;
        $this->data     = $data;
        
        if(file_exists($this->source) === false)
        {
            throw new \RuntimeException('Invalid template source');
        }
        $content    = include_once($this->source);
    }
    
    /**
     * @brief   Render string content
     * 
     * @param   string $content
     * @param   string $type
     * 
     * @return  void
     */
    public function renderString( $content, $type = self::HTTP_HTML )
    {
        header('Content-Type ' . $content);
        print_r( $content );
    }
}