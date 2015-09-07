<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * PageStudio
 *
 * A web application for managing website content. For use with PHP 5.4+
 * 
 * This application is based on the PHP framework, 
 * PIP http://gilbitron.github.io/PIP/. PIP has been greatly altered to 
 * work for the purposes of our development team. Additional resources 
 * and concepts have been borrowed from CodeIgniter,
 * http://codeigniter.com for further improvement and reliability. 
 *
 * @package     PageStudio
 * @author      Cosmo Mathieu <cosmo@cosmointeractive.co>   
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
 * @modified:   07/01/2015
 *
 * Table of Contents:
 * ------------------------------
 * - escape_and_addslashes()
 * - remove_slashes()
 * - remove_dbl_slashes()
 * - filter_POST()
 * - filter_preg_replc()
 * - strtotime_date()
 * - shorten_string()
 * - shorten_phrase()
 * - make_slug()
 * - dash_to_underscore()
 * - remove_dash_and_underscore()
 * - list_directory()
 * - ucproper()
 * - highlight()
 * - remove_from_string()
 * - wrap_in_html_entities()
 * - random_readable_string()
 * - random_alphanumeric()
 * - random_passwd()
 * - extract_emails()
 * - arrayToObject()
 * - mime_file_type()
 * - datetime()                         Function with formated date
 * - remove_am_pm()                     Removes AM PM from a given string
 */
 
/**
 * String sanitation 
 *
 * @syntax       escape_and_addslash($var)
 * @param        string $string (Required) The string to be processed
 *
 * @return       string
 */
function escape_and_addslashes($string) {
    $array = array (
		'\r\n' => '',
		'<p>\r\n</p>' => ''
	);

	$string = strtr( $string, $array );
    
	return addcslashes($string, "%_"); 
}

/**
 * STRING SANITATION 
 * This function removes slashes twice. This is
 * because we are adding the slashes twice before writing to the database.
 */
function remove_slashes($string) {
    $array = array (
		'\r\n' => '',
		'<p>\r\n</p>' => ''
	);

	$string = strtr( $string, $array );
    
	return stripcslashes(stripslashes($string));
}

/**
 * remove_dbl_slashes() 
 * 
 * This function removes slashes that are back to back, i.e. //
 * 
 * @syntax     remove_dbl_slashes( $string ) 
 * @param      $string
 * @since      1.1.0
 * @modified   06/19/2014    
 * @return     $string
 */ 
function remove_dbl_slashes( $string ) {
	/*
	 * Remove all double (//) slashes.
	 */
	//return $url = preg_replace( '#/+#','/',$string );
	
	/*
	 * Removes all trailing slashes.
	 */
	return $url = rtrim($string, '/');
}

/**
 * Function used for escaping values from a $_POST. 
 *
 * @param        $param
 * @return       string
 */
function filter_POST( $param ) {
	//return mysql_real_escape_string($param);
	return addcslashes(mysql_real_escape_string($param), "%_"); 
}

/**
 *
 */
function filter_preg_replc( $var ) 
{
	return preg_replace('/[^a-zA-Z0-9@.]/','',$var);
//	return mysql_real_escape_string($var);
}

/**
 * Formats a date from XXXX-XX-XX to readable format 
 * @note       Date Formats - (l, F jS, Y == Weekday, Month, nth, YYYYY)
 * @note       Time Formats - (h:m, A == Hour, Minute, AM/PM)
 *
 * @param      string $datetime_value
 * @param      string $datetime_format
 * @param      string $message
 * @return     string
 */
function strtotime_date($datetime_value, $datetime_format, $message = 'No Date Entered' ) {
	return ($datetime_value == '0000-00-00' || $datetime_value == '0000-00-00 00:00:00') 
            ? $message 
            : date($datetime_format, strtotime($datetime_value));
}

/*****************************************************************************
*         Name: shorten_string
*       Syntax: shorten_string($phrase, 300) 
*  Description: This function accepts a @phrase and shortens a string by 
*  				that @phrase by @max_words value.
* 				Then returns the @param to the caller.
*   Parameters:
*               $phrase   (required): The @param to be processed
*               $max_words   (required): The @param of desired word count
*
*	   Updated: 03/09/2014
*Return Values: $short_string
******************************************************************************/
function shorten_string($phrase, $max_words)
{
	$phrase = strip_tags(trim("$phrase")); 
	$phrase_array = explode(' ',$phrase);
	if(count($phrase_array) > $max_words && $max_words > 0)
		$phrase = implode(' ',array_slice($phrase_array, 0, $max_words));  
		
	return $phrase;
}

/*****************************************************************************
*         Name: shorten_phrase
*       Syntax: shorten_phrase($phrase, 300) 
*  Description: Shortens passed @phrase by $max_words. With options to keep
* 				and not to keep the last word whole. 
* 				Then returns the @param to the caller.
*   Parameters:
*               $phrase   (required): The @param to be processed
*               $max_words   (required): The @param of desired word count
*
*	   Updated: 03/09/2014
*Return Values: $short_string
******************************************************************************/
function shorten_phrase($phrase, $max_words) 
{
	//[OPTION 1] Breaks up whole word after N'th character
	//		$short_string = strip_tags(trim("{$phrase}")); 
	//		$short_string = substr($short_string, 0, 50) . '...';
	
	//[OPTION 2] Keeps whole word after N'th character
	$short_string = strpos($phrase, ' ', $max_words);
	$short_string = substr($phrase, 0, $short_string ) . '...'; 
	
	return $short_string;
}

/*****************************************************************************
*         Name: make_slug
*       Syntax: make_slug($text)
*  Description: This function replaces 'spaces' from @text with dashes.
* 				Then returns the @text to the caller. 
*   Parameters:
*               $text   (Required): The @text to be processed
*
*Return Values: $text, If @text is empty return 'n-a'
******************************************************************************/
function make_slug($text)
{ 
	// replace non letter or digits by -
	$text = preg_replace('~[^\\pL\d]+~u', '-', $text);

	// trim
	$text = trim($text, '-');

	// transliterate
	$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

	// lowercase
	$text = strtolower($text);

	// remove unwanted characters
	$text = preg_replace('~[^-\w]+~', '', $text);

	return (empty($text)) ?  '' : $text;
}

/**
 * Replace dashes with underscores
 *
 * Find dashes in a string and replace it with underscores.
 *
 * @Since: 1.1.0 
 */ 
function dash_to_underscore($string)
{
	return str_replace("-","_",$string);
}

/**
 * Replace dashes, underscores, with spaces
 *
 * @Since: 1.1.0 
 */ 
function remove_dash_and_underscore($string)
{
	return preg_replace('/[-_]+/', ' ', $string);
} 

/**
 * List the contents of a directory, receive file path to read from, 
 * accept @param $blacklist as array of items not to display. 
 *
 * Example: $blacklist = array('.', '..', 'somedir', 'somefile.php'), 
 *          list_directory(file_path, false), set to false when not wanting 
 *          to exclude any directories.
 *
 * Required: $path
 */
function list_directory($path, $blacklist)
{
	$blacklist = (empty($blacklist) || !$blacklist) ? array('.', '..') : $blacklist;
	
	if ($handle = opendir($path)) {
		while (false !== ($file = readdir($handle))) {
			if (!in_array($file, $blacklist)) {
				echo "$file\n";
			}
		}
		closedir($handle);
	}
}

/*****************************************************************************
*         Name: ucproper
*       Syntax: ucproper($string)
*  Description: Properly Capitalize the First Character Of Each Word
*               Allow words such as "DNA","URL","HD","API", etc, 
* 				to be in all-caps.
*   Parameters:
*               $string     (Required): The string to be processed
*
*Return Values: $string
******************************************************************************/
function ucproper($string)
{
    $str = strtolower($string);
    $patterns = array(
        '/\b(us|ip|3d|dna|ux|hd|sd|url|api|cnn|cim)\b/i',
        '/\b(php|ajax|js|rss|asp|sql|json|doctypes|ssl)\b/i',
        '/\b((ie|css?|md|html)[0-9]?)\b/i',
        '/\b(ae|ai|psd|pdf|jpe?g|png|gif)\b/i',
        '/\b(jq)(?=uery\b)/i',
        '/\b(hta)(?=ccess\b)/i',
        '/(?<=(\bmy))(sql\b)/i',
        '/(?<=(\bjava))(s)(?=cript\b)/i',
        '/(?<=(\bword))(p)(?=ress\b)/i',
        '/(?<=(\bmy))(isam)\b/i',
        '/(?<=(\binno))(db)\b/i',
        '/(w){3}/i'
    );
    $str = preg_replace_callback(
        '/\b([a-zA-Z]+)\b/',
        create_function(
            '$match','return ucfirst($match[0]);'
        ),
        $str
    );
    $str = preg_replace_callback(
        '/(?<!^)\b(and?|or|the|is)\b/i',
        create_function(
            '$match',
            'return strtolower($match[0]);'
        ),
        $str
    );

	return preg_replace_callback(
        $patterns,create_function(
            '$match',
            'return strtoupper($match[0]);'
        ),
        $str
    );
}

/*****************************************************************************
*         Name: highlight
*       Syntax: highlight($sString, $aWords)
*  Description: Highlight Specific Words In A Phrase
* 				Application: when displaying search results, it is a great 
*				idea to highlight specific words. 
*   Parameters:
*				$aWords		(Required): Words to be highlighted
*               $string     (Required): The string to be processed
*
*Return Values: $sString
******************************************************************************/
function highlight($sString, $aWords)
{
	if (
        !is_array ($aWords) 
        || empty ($aWords) 
        || !is_string ($sString)
    ) {
		return false;
	}
	$sWords = implode ('|', $aWords);
	
	return preg_replace(
        '@\b('.$sWords.')\b@si', 
        '<strong style="background-color:yellow"></strong>', 
        $sString
    );
} 

/**
 * Name: remove_from_string
 * 
 * Extend functionality of short_codes API (lib/shortcodes.php). 
 * Removes unwanted <p> and custom tags. Then returns the @param to the caller.
 * Syntax: remove_from_string($chars = array('<p>', '</p>'), $string)
 * Parameters: $atts   (required): The @param to be processed
 *
 * @since: 1.1.0
 * @return: $content
 */
function remove_from_string($chars, $string)
{	
	return $string = str_replace($chars, "", $string);
}

/**
 * Simple function to convert all applicable characters to HTML entities.
 * 
 * Required: param  
 * Since: 1.1.0
 */
function wrap_in_html_entities($param)
{
	return htmlentities($param, ENT_QUOTES);
}

/**
 * @length - length of random string (must be a multiple of 2)
 * @Note: consider using this for password generated scripts.
 */
function random_readable_string( $length = 6 )
{
    $conso = array("b","c","d","f","g","h","j","k","l","m","n","p","r","s","t","v","w","x","y","z");
    
	$vocal = array("a","e","i","o","u");
    $string = "";
    srand (( double )microtime()*1000000);
    $max = $length/2;
   
   for ($i=1; $i<=$max; $i++)
   {
		$string .= $conso[rand(0,19)];
		$string .= $vocal[rand(0,4)];
   }
   return $string;
}

/**
 * Function to create random alpha numeric string> By default the string length is 8 characters
 * @return      string $string
 */ 
function random_alphanumeric( $random_string_length = 8 )
{
	/** Allowable characters for random generation. */
	 $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
	
	 /**
	  * Choose a random number and use it as the index to the $characters string 
	  * to get a random character, and append it to the string
	  */
	$string = '';
	for ( $i = 0; $i < $random_string_length; $i++ ) {
		$string .= $characters[ rand( 0, strlen($characters) - 1 ) ];
	}
	
	return $string;
} 

/**
 * random_passwd
 * @Syntax: random_passwd()
 * @Description: Function to generate random alpha numeric strings. 
 * Used to generate random passwords, confirmation links, etc.
 * @Param:
 *         $length   (Required): The desired length
 *         $strength (Required): The desired strength
 *
 * @Updated: 03/09/2014 
 * @Return: $password
 */
function random_passwd( 
    $complexity = 'simple', 
    $length = 8, 
    $case = 'ucfirst' 
) {
	$vowels 	 = 'aeuy';
	$consonants  = 'bdghjmnpqrstvz';
	$numeric 	= '0123456789';
	$password 	 = '';	
	$alt         = time() % 2;
	
	/*
	 * Create a simple 8 alphanumeric password
	 */
	if ( $complexity == 'simple')
	{
		/* 
		 * Create a randomized alpha characters only string and add to variable $password
		 */
		$password .= random_readable_string( 4 );
		
		/*
		 * Randomize numeric characters only and add to variable $password
		 */
		for ($i = 0; $i < 4; $i++) 
		{
			$password .= $numeric[rand(0, strlen($numeric) - 1)];
		}
	}
	/*
	 * Create a strong password based on complexity level
	 */
	else if ( $complexity >= 1)
	{
		if ($complexity >= 1) {
			$consonants .= 'BDGHJLMNPQRSTVWXZ';
		}
		
		if ($complexity >= 2) {
			$vowels .= "AEUY";
		}
		
		if ($complexity >= 3) {
			$consonants .= '23456789';
		}
		
		if ($complexity >= 4 ) {
			$vowels .= '@#$%';
		}	
		
		for ($i = 0; $i < $length; $i++) 
		{
			if ($alt == 1) {
				$password .= $consonants[(rand() % strlen($consonants))];
				$alt = 0;
			} else {
				$password .= $vowels[(rand() % strlen($vowels))];
				$alt = 1;
			}
		}
	}
	
	/*
	 * Converted one or all alphabetic characters to uppercase. 
	 */
	$password = ( $case == 'ucALL' ) ? strtoupper( $password ) : ucfirst( $password );	
	
	return $password;
} 

/**
 *
 */
function extract_emails( $string )
{
    /*
     * Expression to extract all emails from a string:
	 */
    $regexp = '/([a-z0-9_\.\-])+\@(([a-z0-9\-])+\.)+([a-z0-9]{2,4})+/i';
	
	/*
	 * Perform extraction
	 */
    preg_match_all($regexp, $string, $m);

    return ( isset($m[0]) ) ? $m[0] : array();
}


/**
 * GetBetween() 
 * 
 * Retrieves the content contained within a given parameter. 
 * 
 * @usage     GetBetween( $string, $start, $end ) 
 * @param     $start, $string, $end 
 * @return    string
 */ 
function GetBetween($string,$start,$end)
{
	//	$regex = '#<code>(.*?)</code>#';
	//	http://stackoverflow.com/questions/9253027/get-everthing-between-tag-and-tag-with-php
	
	$r = @explode($start, $string);
	if (isset($r[1]))
	{
		$r = explode($end, $r[1]);		
		return $r[0];
	} 
	else 
	{		
		return '';
	}
}

/**
 * Return the base url 
 * 
 * @syntax     admin_theme_uri() 
 * @param      string BASE_URL
 * @return     string
 */ 
if( ! function_exists('admin_theme_uri')) {
    function admin_theme_uri() {
        return (BASE_URL) ? BASE_URL : '';
    }
}

/**
 * Convert an array to an object
 * 
 * @syntax     arrayToObject( $param ) 
 * @param      array $array
 * @return     object
 */ 
if( ! function_exists('arrayToObject')) {
    function arrayToObject($array) {
        $object = new stdClass();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $value = arrayToObject($value);
            }
            $object->$key = $value;
        }
        return $object;
    }
}

/**
 * Convert a two dimensional array containing multiple objects into a single array
 * 
 * $records = call_user_func_array('array_merge', $options);
 * $records = iterator_to_array(new RecursiveIteratorIterator(new RecursiveArrayIterator($options)), 0);
 * 
 * @syntax     mergeArrayObjectsToArray( $array ) 
 * @param      array|object $array
 * @return     array|object
 */ 
if( ! function_exists('mergeArrayObjectsToArray')) {
    function mergeArrayObjectsToArray($array, $key, $value) {
        $tmp_array = array();
        $final_array = array();
        
        foreach ($array as $val) {
            $tmp_array[$val->$key] = $val->$value;
        }
        
        return $final_array[] = arrayToObject($tmp_array);
    }
}

/**
 * Show css class in the html body tag
 * 
 * @param      array|string $atts
 * @return     string
 */ 
if( ! function_exists('body_class')) {
    function body_class($atts) {
        $body_class = '';    
        if( ! empty($atts)) {
            if(is_array($atts)) {
                foreach($atts as $att) {
                    $body_class .= $att . ' ';
                }
            } else {
                $body_class = $atts;
            }
        }
        return 'class="' . $body_class . '"';
    }
}

/**
 * Return the extension associated with a mime type
 *
 * @see        For more types http://php.net/manual/en/function.mime-content-type.php
 * @param      string $mime_type
 * @return     string
 */ 
if( ! function_exists('mime_file_type')) {
    function mime_file_type($mime_type) {
        $mime_types = array(
            
            // images
            'image/pjpeg'   => "jpg",
            'image/jpeg'    => "jpg",
            'image/jpg'     => "jpg",
            'image/png'     => "png",
            'image/x-png'   => "png",
            'image/gif'     => 'gif',
            'image/bmp'     => 'bmp',
            'image/vnd.microsoft.icon' => 'ico',
            'image/tiff'    => 'tiff',
            'image/tiff'    => 'tif',
            'image/svg+xml' => 'svg',
            'image/svg+xml' => 'svgz',
            
             // audio/video
            'audio/mpeg'    => 'mp3',
            'video/quicktime' => 'mov'
        );
        
        if (array_key_exists($mime_type, $mime_types)) {
            return $mime_types[$mime_type];
        }
    }
}

/**
 * Return the current server date and time to the caller 
 * 
 * @param      $format Date format 
 * @return     datetime Formated date and time 
 */
if( ! function_exists('datetime')){
    function datetime($format = 'Y-m-d H:i:s') {
        return (new DateTime())->format($format);
    }
}

/**
 * Remove AM/PM from string 
 *
 * @param        string $string (Required) The string to be processed
 *
 * @return       string
 */
if( ! function_exists('remove_am_pm')) {    
	function remove_am_pm($string) {
		$array = array(
			'AM' => '',
			'PM' => ''
		);

		return $string = trim(strtr( $string, $array ));
	}
}

/* End of file functions_helper.php */
/* Location: ./application/helpers/functions_helper.php */