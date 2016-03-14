<?php  defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * PageStudioCMS
 *
 * A web application for managing website content. For use with PHP 5.4+
 * 
 * This application is based on CMS Canvas, a CodeIgniter based application, 
 * http://cmscanvas.com/. It has been greatly altered to work for the 
 * purposes of our development team. Additional resources and concepts have 
 * been borrowed from PyroCMS http://pyrocms.com, for further improvement
 * and reliability. 
 *
 * @package     PageStudioCMS
 * @author      Cosmo Mathieu <cosmo@cosmointeractive.co>
 * @copyright   Copyright (c) 2015, Cosmo Interactive, LLC
 * @license     MIT License
 * @link        http://pagestudiocms.com
 */

// ------------------------------------------------------------------------

/**
 * Helper Functions
 *
 * Helper functions are a collection of functions that helps you with tasks. 
 * Unlike most other systems, in this CMS, Helper Functions are not written 
 * in an Object Oriented format. They are simple, procedural functions. 
 * Each helper function performs one specific task, and may be dependent of one or 
 * more other Helper Functions.
 * Helper functions are not native to this application alone. They can be reused in 
 * other php applications. 
 *
 * @version:    Version 0.2.0 
 * @modified:   03/12/2016
 *
 * Table of Contents:
 * ------------------------------
 * - mime_file_type()
 * - datetime()                         Function with formated date
 * - remove_am_pm()                     Removes AM PM from a given string
 * - _pr()                              Simply wraps a print_r() in pre tags
 * - _vd()
 * - array_to_object()
 * - object_to_array()
 * - is_ajax()
 * - image_thumb()
 * - br2nl()                            Converts html <br /> to new line \n
 * - option_array_value()
 * - in_uri()
 * - theme_partial()
 * - theme_url()
 * - domain_name()
 * - glob_recursive()
 * - url_base64_encode()
 * - url_base64_decode()
 * - xml_output()
 * - js_start()
 * - js_end()
 * - str_to_bool()
 * - is_inline_editable()
 * - 
 */
/*
 * Print Recursive
 *
 * Simply wraps a print_r() in pre tags for debugging.
 *
 * @param mixed
 * @return string
 */
if ( ! function_exists('_pr'))
{
    function _pr($a)
    {
        echo "<pre>";
        print_r($a);
        echo "</pre>";
    }
}

// ------------------------------------------------------------------------

/*
 * Variable Dump
 *
 * Simply wraps a var_dump() in pre tags for debugging.
 *
 * @param mixed
 * @return string
 */
if ( ! function_exists('_vd'))
{
    function _vd($a)
    {
        echo "<pre>";
        var_dump($a);
        echo "</pre>";
    }
}

// ------------------------------------------------------------------------

/**
 * Array to Object
 * 
 * Converts an array to an object with optional param for recursion 
 *
 * @param   int $recursion Defaults to false 
 * @param   array $array 
 * @return  object
 */
if ( ! function_exists('array_to_object'))
{
    function array_to_object($array, $recursion = false)
    {
        $Object = new stdClass();
        foreach($array as $key => $value)
        {
            if ($recursion && is_array($value)) {
                $value = array_to_object($value);
            }
            $Object->$key = $value; 
        }

        return $Object;
    }
}

// ------------------------------------------------------------------------

/*
 * Object to Array
 * 
 * Converts an object to an array
 * 
 * @param object
 * @return array
 */
if ( ! function_exists('object_to_array'))
{
    function object_to_array($Object)
    {
        $array = get_object_vars($Object);

        return $array;
    }
}

// ------------------------------------------------------------------------

/*
 * Is Ajax
 *
 * Returns true if request is ajax protocol
 *
 * @return bool
 */
if ( ! function_exists('is_ajax'))
{
    function is_ajax() 
    {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'));
    }
}

// ------------------------------------------------------------------------

/*
 * Image Thumb
 *
 * Creates an image thumbnail and caches the image
 *
 * @param string
 * @param int
 * @param int
 * @param bool
 * @param array
 * @return string
 */
if ( ! function_exists('image_thumb'))
{
    function image_thumb($source_image, $width = 0, $height = 0, $crop = FALSE, $props = array()) 
    {
        $CI =& get_instance();
        $CI->load->library('image_cache');

        $props['source_image'] = '/' . str_replace(base_url(), '', $source_image);
        $props['width'] = $width;
        $props['height'] = $height;
        $props['crop'] = $crop;

        $CI->image_cache->initialize($props);
        $image = $CI->image_cache->image_cache();
        $CI->image_cache->clear();

        return $image;
    }
}

// ------------------------------------------------------------------------

/*
 * BR 2 NL
 *
 * Converts html <br /> to new line \n
 *
 * @param string
 * @return string
 */
if ( ! function_exists('br2nl'))
{
    function br2nl($text)                                                                   
    {                                                                                       
        return  preg_replace('/<br\\s*?\/??>/i', '', $text);                            
    }                                                                                       
}

// ------------------------------------------------------------------------

/* 
 * Option Array Value
 *
 * Returns single dimension array from an Array of objects with the key and value defined
 *
 * @param array
 * @param string
 * @param string
 * @param array
 * @return array
 */
if ( ! function_exists('option_array_value'))
{
    function option_array_value($object_array, $key, $value, $default = array())
    {
        $option_array = array();

        if ( ! empty($default))
        {
            $option_array = $default;
        }

        foreach($object_array as $Object)
        {
            $option_array[$Object->$key] = $Object->$value;
        }

        return $option_array;
    }
}

// ------------------------------------------------------------------------

/* 
 * In URI
 *
 * Checks if current uri segments exist in array of uri strings
 *
 * @param string or array
 * @param string
 * @param bool
 * @return bool
 */
if ( ! function_exists('in_uri'))
{
    function in_uri($uri_array, $uri = null, $array_keys = FALSE)
    {
        if ( ! is_array($uri_array)) 
        {
            $uri_array = array($segments);
        }

        $CI =& get_instance();

        if ( ! empty($uri))
        {
            $uri_string = '/' . trim($uri, '/');
        }
        else
        {
            $uri_string = '/' . trim($CI->uri->uri_string(), '/');
        }

        $uri_array = ($array_keys) ? array_keys($uri_array) : $uri_array;

        foreach($uri_array as $string)
        {
            if (strpos($uri_string, ($string != '') ? '/' . trim($string, '/') : ' ') === 0)
            {
                return true;
            }
        }

        return false;
    }   
}   

// ------------------------------------------------------------------------

/* 
 * Theme Partial
 *
 * Load a theme partial
 *
 * @param string
 * @param array
 * @param bool
 * @return string
 */
if ( ! function_exists('theme_partial'))
{
    function theme_partial($view, $vars = array(), $return = TRUE)
    {
        $CI =& get_instance();
        $CI->load->library('parser');
        return $CI->parser->parse_string($CI->load->theme($CI->template->theme . '/views/partials/' . trim($view, '/'), $vars, $return, $CI->template->theme_path), $vars, $return);
    }
}

// ------------------------------------------------------------------------

/* 
 * Theme Url
 *
 * Create a url to the current theme
 *
 * @param string
 * @return string
 */
if ( ! function_exists('theme_url'))
{
    function theme_url($uri = '')
    {
        $CI =& get_instance();
        return base_url($CI->template->theme_path . '/' . $CI->template->theme . '/'  . trim($uri, '/'));
    }
}


// ------------------------------------------------------------------------

/* 
 * Domain Name
 *
 * Returns the site domain name and tld
 *
 * @return string
 */
if ( ! function_exists('domain_name'))
{
    function domain_name()
    {
        $CI =& get_instance();

        $info = parse_url($CI->config->item('base_url'));
        $host = $info['host'];
        $host_names = explode(".", $host);
        return $host_names[count($host_names)-2] . "." . $host_names[count($host_names)-1];
    }
}

// ------------------------------------------------------------------------

/*
 * Glob Recursive
 *
 * Run glob function recursivley on a directory
 *
 * @param string
 * @return array
 */
if ( ! function_exists('glob_recursive'))
{
    // Does not support flag GLOB_BRACE
    
    function glob_recursive($pattern, $flags = 0)
    {
        $files = glob($pattern, $flags);
        
        foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir)
        {
            $files = array_merge($files, glob_recursive($dir.'/'.basename($pattern), $flags));
        }
        
        return $files;
    }
}

// ------------------------------------------------------------------------

/*
 * URL Base64 Encode
 * 
 * Encodes a string as base64, and sanitizes it for use in a CI URI.
 * 
 * @param string
 * @return string
 */
if ( ! function_exists('url_base64_encode'))
{
    function url_base64_encode(&$str="")
    {
        return strtr(
            base64_encode($str),
            array(
                '+' => '.',
                '=' => '-',
                '/' => '~'
            )
        );
    }
}

// ------------------------------------------------------------------------

/*
 * URL Base64 Decode
 *
 * Decodes a base64 string that was encoded by ci_base64_encode.
 * 
 * @param string
 * @return string
 */
if ( ! function_exists('url_base64_decode'))
{
    function url_base64_decode(&$str="")
    {
        return base64_decode(strtr(
            $str, 
            array(
                '.' => '+',
                '-' => '=',
                '~' => '/'
            )
        ));
    }
}

// ------------------------------------------------------------------------

/*
 * Output XML
 *
 * Sets the header content type to XML and
 * outputs the <?php xml tag
 * 
 * @param string
 * @return string
 */
if ( ! function_exists('xml_output'))
{
    function xml_output()
    {
        $CI =& get_instance();
        $CI->output->set_content_type('text/xml');
        $CI->output->set_output("<?xml version=\"1.0\"?>\r\n");
    }
}

// ------------------------------------------------------------------------

/*
 * JS Head Start
 *
 * Starts output buffering to place javascript in the <head> of the template
 * 
 * @return void
 */
if ( ! function_exists('js_start'))
{
    function js_start()
    {
        ob_start();
    }
}

// ------------------------------------------------------------------------

/*
 * JS Head End
 *
 * Ends output buffering to place javascript in the <head> of the template
 * 
 * @return void
 */
if ( ! function_exists('js_end'))
{
    function js_end()
    {
        $CI =& get_instance();
        $CI->template->add_script(ob_get_contents());
        ob_end_clean();
    }
}

// ------------------------------------------------------------------------

/*
 * String to Boolean
 *
 * This function analyzes a string and returns false if the string is empty, false, or 0
 * and true for everything else
 * 
 * @param string
 * @return bool
 */
if ( ! function_exists('str_to_bool'))
{
    function str_to_bool($str)
    {
        if (is_bool($str))
        {
            return $str;
        }

        $str = (string) $str;
        
        if (in_array(strtolower($str), array('false', '0', '')))
        {
            return false;
        }
        else
        {
            return true;
        }
    }
}

// ------------------------------------------------------------------------

/*
 * Is Inline Editable
 *
 * Returns true if inline editing is enabled, admin toolbar is enabled, and user is an administrator
 *
 * @return bool
 */
if ( ! function_exists('is_inline_editable'))
{
    function is_inline_editable($content_type_id = null)
    {
        $CI =& get_instance();
        $CI->load->model('content_types_model');

        if ($CI->settings->enable_inline_editing && $CI->settings->enable_admin_toolbar && $CI->secure->group_types(array(ADMINISTRATOR))->is_auth())
        {
            if (empty($content_type_id))
            {
                return TRUE;
            }

            if ($CI->Group_session->type != SUPER_ADMIN)
            {
                // Check if we have already cached permissions for this content type
                if ( ! isset($CI->content_types_model->has_permission_cache[$content_type_id]))
                {
                    $Content_types_model = new Content_types_model();

                    // No permission for this content type has been cached yet.
                    // Query to see if current user has permission to this content type
                    $Content_type = $Content_types_model->group_start()
                        ->where('restrict_admin_access', 0)
                        ->or_where_related('admin_groups', 'group_id', $CI->Group_session->id)
                        ->group_end()
                        ->get_by_id($content_type_id);

                    $CI->content_types_model->has_permission_cache[$content_type_id] = ($Content_type->exists()) ? TRUE : FALSE;
                }

                return $CI->content_types_model->has_permission_cache[$content_type_id];
            }
            else
            {
                return TRUE;
            }
        }
        else
        {
            return FALSE;
        }
    }
    
}
    
// ------------------------------------------------------------------------

/**
 * Replace dashes with underscores
 *
 * @since   1.1.0 
 * @return  string 
 */
if ( ! function_exists('dash_to_underscore'))
{ 
    function dash_to_underscore($string)
    {
        return str_replace("-", "_", $string);
    }
}

/**
 * Replace underscores with dashes
 *
 * @since   1.1.0 
 * @return  string 
 */
if ( ! function_exists('underscore_to_dash'))
{ 
    function underscore_to_dash($string)
    {
        return str_replace("_", "-", $string);
    }
}

/**
 * Replace dashes and underscores. By default replaces with spaces.
 * 
 * @since   1.1.0 
 * @param   string $replace Specifies character replacement
 * @return  string
 */ 
if ( ! function_exists('remove_dash_and_underscore'))
{
    function remove_dash_and_underscore($string, $replace = ' ')
    {
        return preg_replace('/[-_]+/', $replace, $string);
    } 
} 

// ------------------------------------------------------------------------

/**
 * This function replaces 'spaces' from @text with dashes.
 * Then returns the @text to the caller. 
 * 
 * @param    $text (Required): The text to be processed
 * @return   string $text
 */
if ( ! function_exists('make_slug'))
{
    function make_slug($text, $options = [])
    { 
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
        $text = trim($text, '-');   // trim
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);   // transliterate
        $text = strtolower($text);   // lowercase

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        return (empty($text)) ?  '' : $text;
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('random_number'))
{
    function random_number($length = 8) 
    {
        $numeric = '0123456789';
        $number  = '';
        
        for ($i = 0; $i < $length; $i++) {
            $number .= $numeric[rand(0, strlen($numeric) - 1)];
        }
        
        return $number;
    }
}
    
// ------------------------------------------------------------------------

/**
 * Creates a human readable string 
 *
 * @param   int $length String length (must be a multiple of 2)
 * @note    consider using this for password generated scripts.
 *
 * @return  string
 */
if ( ! function_exists('random_readable_string'))
{
    function random_readable_string($length = 6)
    {
        $conso = array("b","c","d","f","g","h","j","k","l","m","n","p","r",
            "s","t","v","w","x","y","z"
        );
        $vocal = array("a","e","i","o","u");
        
        $string = "";
        srand (( double )microtime()*1000000);
        $max = $length/2;
       
        for ($i = 1; $i <= $max; $i++)
        {
            $string .= $conso[rand(0,19)];
            $string .= $vocal[rand(0,4)];
        }
        
        return $string;
    }
}

function hash_passwd($string, $options = [])
{
    $secure = (isset($options['secure'])) ? true : false;

    switch($secure) {
        case true :
        case 'encrypt' :
        case 'sha1'	:
            $CI =& get_instance();
            $CI->load->helper('security');
            return do_hash(uniqid(mt_rand(), TRUE), 'sha1');
            break;
        default:
            return $string;
    }
}