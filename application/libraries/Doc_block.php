<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
/**
 * PageStudio CMS
 *
 * @author      Cosmo Mathieu
 * @copyright   Copyright (c) 2015
 * @license     MIT License
 * @link        http://pagestudiocms.com
 */
 
// -------------------------------------------------------------------

/**
 * Doc block parser
 *  
 * Doc Block parser created by Baylor Rae, adapted for PageStudio CMS
 *  
 * <code>
 *  $doc_block = new DocBlock($block);
 *  echo 'Author: ' . $doc_block->author;
 *  echo 'Params:';
 *  print_r($doc_block->params);
 *  
 *  OR
 *  
 *  $doc_block = new Doc_block(
 *      file_location/file_name.ext
 *  );
 *  echo 'Author: ' . $doc_block->author;
 * </code>
 *  
 * @author  Baylor Rae <https://gist.github.com/BaylorRae>
 * @author  Cosmo Mathieu <cosmo@cosmointeractive.co>
 * @link    https://gist.github.com/BaylorRae/3131887
 */
class Doc_block 
{
    public $docblock,
           $description = null,
           $all_params = array();
    
    /**
     * Parses a docblock;
     */
    function __construct($docblock = null) {
        if( ! is_string($docblock) && ! is_null($docblock) ) {
            throw new Exception("DocBlock expects first parameter to be a string");
        }
        
        $this->docblock = $docblock;
        $this->parse_block();
    }
    
    /**
     * An alias to __call();
     * allows a better DSL
     *
     * @param string $param_name
     * @return mixed
     */
    public function __get($param_name) {
        return $this->$param_name();
    }
    
    /**
     * Checks if the param exists
     * 
     * @param string $param_name
     * @return mixed
     */
    public function __call($param_name, $values = null) {
        if( $param_name == "description" ) {
            return $this->description;
        }else if( isset($this->all_params[$param_name]) ) {
            $params = $this->all_params[$param_name];
            
            if( count($params) == 1 ) {
                return $params[0];
            }else {
                return $params;
            }
        }
        
        return null;
    }
    
    /**
     * Parse each line in the docblock
     * and store the params in `$this->all_params`
     * and the rest in `$this->description`
     */
    private function parse_block() {
        // split at each line
        foreach(preg_split("/(\r?\n)/", $this->docblock) as $line)
        {
            // if starts with an asterisk
            if( preg_match('/^(?=\s+?\*[^\/])(.+)/', $line, $matches) ) 
            {
                $info = $matches[1];
                
                // remove wrapping whitespace
                $info = trim($info);
                
                // remove leading asterisk
                $info = preg_replace('/^(\*\s+?)/', '', $info);
                
                // if it doesn't start with an "@" symbol
                // then add to the description
                if( $info[0] !== "@" ) 
                {
                    $this->description .= "\n$info";
                    continue;
                }
                else 
                {
                    // get the name of the param
                    preg_match('/@(\w+)/', $info, $matches);
                    $param_name = $matches[1];
                    
                    // remove the param from the string
                    $value = str_replace("@$param_name:", '', $info);
                    
                    // if the param hasn't been added yet, create a key for it
                    if( ! isset($this->all_params[$param_name]) ) {
                        $this->all_params[$param_name] = array();
                    }
                    
                    // push the param value into place
                    $this->all_params[$param_name][] = $value;
                    
                    continue;
                }
            }
        }
    }
}
