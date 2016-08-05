<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
/**
 * PageStudio CMS
 *
 * @author      Cosmo Mathieu
 * @copyright   Copyright (c) 2015
 * @license     MIT License
 * @link        http://pagestudiocms.com
 */

// ------------------------------------------------------------------------
 
/**
 * Mobile detection plugin for PageStudio CMS 2
 *
 * An implementation of Gareth Davies' <http://www.garethtdavies.com> and 
 * Max Lazar's <max@eec.ms> Mobile Detect plugin altered for PageStudio CMS
 *
 * @package     PageStudio CMS
 * @category    Plugin
 * @version     1.0
 * @since       1.2.0
 * @author      Cosmo Mathieu
 * @copyright   Copyright (c) 2016
 * @link        http://www.pagestudiocms.com
 */

class Mobile_detect_plugin extends Plugin
{
    /**
     * @var $return_data The data to return to the view 
     */
	public $return_data = "";
    
    /**
     *  TODO: Document this 
     */
	private $isTablet = "";
	
    /**
     *  TODO: Document this 
     */
    private $isMobile = "";
    
    // These will be used later 
    // var $location = '';
	// var $conds = array ();
	// var $cache;
	// var $enable;
	// var $cookie_value;
	// var $redirect;
	// var $cookie_name;
	// var $client_request;
	// var $ignore_cookies;
	// var $refresh;
	// var $agent;
	// var $cookie_expire = 86500;
	
	/**
     * Constructor
	 *  
	 * @return     void
	 */
	public function __construct()
	{
        $this->init();
	}

	// --------------------------------------------------------------------
    
    /**
     *  We need this method because the Plugin abstract class prevents us 
     *  from using the contruct method any otherwise than for calling 
     *  methods within the current class.
     *  
     *  @return     void
     */
    public function init()
    {
        $CI =& get_instance();
        $CI->load->library('Mobile_detect'); // Load the Mobile Detect Class

        // Perform the device detection
		$this->isTablet = $CI->mobile_detect->isTablet();
		$this->isMobile = $CI->mobile_detect->isMobile();
    }
	
	// --------------------------------------------------------------------

	/**
	 * This function simply returns true or false depending on whether a 
     * mobile is detected
     */
	public function is_mobile()
	{
		return $this->return_data = $this->isMobile ? TRUE : FALSE;
	}
	
	/**
	 * This function simply returns true or false depending on whether a 
     * mobile is detected
     */
	public function is_not_mobile()
	{
		return $this->return_data = $this->isMobile ? FALSE : TRUE;
	}
	
	/**
	 * This function simply returns true or false depending on whether a 
     * tablet is detected
     */
	public function is_tablet()
	{
		return $this->return_data = $this->isTablet ? TRUE : FALSE;
	}
	
	/**
	 * This function simply returns true or false depending on whether a 
     * phone and not tablet is detected
     */
	public function is_phone()
	{
		return $this->return_data = ($this->isMobile && ! $this->isTablet) ? TRUE : FALSE;
	}
	
    /**
     * This function simply returns true or false depending on whether a 
     * phone and not tablet is detected
     */
    public function is_not_phone()
    {
        return ($this->isMobile && ! $this->isTablet) 
            ? $this->return_data = FALSE : $this->return_data = TRUE;
    }
	
	// --------------------------------------------------------------------
	
	/**
     * type function
	 * This function simply returns the type of the device
     */
	public function device()
	{
        $device = $this->attribute('device');

		if ( $this->isTablet )
		{
			$this->return_data = "tablet";
		}
		elseif ( $this->isMobile )
		{
			$this->return_data = "phone";
		}
		else
		{
			$this->return_data = "not_mobile";	
		}
		
		return $this->return_data;
	}
	
	// --------------------------------------------------------------------
    
    /**
	 * screen_detect function.
     *
	 * @TODO: Make this ready
	 * @access public
	 * @return void
	 */
	public function screen_detect() 
    {
        $CI =& get_instance();
		$r = '';
		
        if ( $CI->input->cookie( 'screen_width', false ) === FALSE ) 
        {
            js_start();
			$r = '<script language="javascript">
	        		function ScreenDetect(){
	        			dpr = 1;

		                if( window.devicePixelRatio !== undefined ){
		                   dpr = window.devicePixelRatio;
		                }

		                var screen_r =  getWindowSize();

		                Set_Cookie( "exp"+"_"+"screen_width", screen_r.width, "", "/", "", "");
		                Set_Cookie( "exp"+"_"+"screen_height", screen_r.height, "", "/", "", "");
 						Set_Cookie( "exp"+"_"+"pixel_ratio", dpr, "", "/", "", "");

		                location = "'.$_SERVER['PHP_SELF'].'";
	                }

					function getWindowSize() {
					    var wW, wH;
					    if (window.outerWidth) {
					        wW = window.outerWidth;
					        wH = window.outerHeight;
					    } else {
					        var cW = document.body.offsetWidth;
					        var cH = document.body.offsetHeight;
					        window.resizeTo(500,500);
					        var barsW = 500 - document.body.offsetWidth;
					        var barsH = 500 - document.body.offsetHeight;
					        wW = barsW + cW;
					        wH = barsH + cH;
					        window.resizeTo(wW,wH);
					    }
					    return { width: wW, height: wH };
					}

					function Set_Cookie( name, value, expires, path, domain, secure){
                        var today = new Date();
                        today.setTime( today.getTime() );

                        if ( expires )
                        {
                        expires = expires * 1000 * 60 * 60 * 24;
                        }
                        var expires_date = new Date( today.getTime() + (expires) );

                        document.cookie = name + "=" +escape( value ) +
                        ( ( expires ) ? ";expires=" + expires_date.toGMTString() : "" ) +
                        ( ( path ) ? ";path=" + path : "" ) +
                        ( ( domain ) ? ";domain=" + domain : "" ) +
                        ( ( secure ) ? ";secure" : "" );

					}
                    
                    ScreenDetect();
	            </script>';
            js_end();
		}
		return $r;
	}

	/**
	 * screen_size function.
	 * @TODO: Make this ready
     *
	 * @access public
	 * @return void
	 */
	public function screen_size() 
    {
        $CI =& get_instance();
        
		return $CI->input->cookie( 'screen_width', false ).'='.$CI->input->cookie( 'screen_height', false ).'='.
			$CI->input->cookie( 'pixel_ratio', '1' );
	}
    
	// --------------------------------------------------------------------
	
	/**
     * redirect function
     *
	 * This function simply redirects the user to the location parameter 
     * specified using ExpressionEngine redirect method
     * 
     * @see        https://github.com/garethtdavies/detect-mobile
     * @return     void
     */
	public function redirect()
	{
		// Retreieve the plugin parameters
		$location = $this->attribute('location');
		$tablet_location = $this->attribute('tablet_location');
		$tablet = strtolower($this->attribute('tablet'));
		$mobile = strtolower($this->attribute('mobile'));
		
		if( ! empty( $location ) )
		{
			if ($this->isTablet && $tablet == "no")
			{
				//A tablet device and don't want to redirect tablets
				return;	
			}
			elseif ($this->isTablet && ! empty( $tablet_location ))
			{
				//A tablet specific page to redirect to
				redirect($tablet_location);
				return;
			}
			elseif($this->isTablet)
			{
				//A tablet that is going to the mobile location
				redirect($location);	
				return;
			}
			elseif ($this->isMobile && $mobile != "no")
			{
				//A mobile device including tablets
				redirect($location);
				return;
			}
			else
			{
				//Not a mobile device or we don't want to redirect anything
				return;	
			}
		}
		else
		{
			//No location for redirect specified so let's get out of here
			return;	
		}
	}
    
	// --------------------------------------------------------------------
    
    /**
     *  TODO: Add method to detect version 
     */
     
    /**
     *  TODO: Add method to detect the specific device name
     *  public function user_agent() { }     
     */
}

/* End of file mobile_detect.php */
/* Location: ./application/plugins/mobile_detect.php */