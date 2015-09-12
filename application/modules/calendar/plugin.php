<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Plugin Functions
 *
 * Provides the ability to execute code via template tags. 
 *
 * @package		CodeIgniter
 * @subpackage	codeigniter
 * @category	Common Functions
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/
 */
class Calendar_plugin extends Plugin
{    
    public function month() 
    {
        $CI   =& get_instance();
        $attr = $this->attributes();
        
        if(isset($attr['segment'])) {
            $parts   = explode('|', $attr['segment']);
            $key     = $parts[0];
            $match   = $parts[1];
            $segment = $CI->uri->segment($key);

            if($segment === $match) {
                return '<div id="fullcalendar"></div>';
            }
        } else {
            return '<div id="fullcalendar"></div>';
        }
    }
    
    // --------------------------------------------------------------------
    
    /**
     * {{ calendar:events segment="1|calendar" status="published" sort="desc" limit="5" }}
     * 
     * @access     public 
     * @return     string
     */
    public function events()
    {
        $events = array();
        $now    = date("Y-m-d G:i:s");
        $CI     =& get_instance();
        $attr   = $this->attributes();
        $sort   = ( ! empty($attr['sort'])) ? $attr['sort'] : 'asc';
        $limit  = ( ! empty($attr['limit'])) ? $attr['limit'] : 5;
        
        if(isset($attr['segment'])) {
            $parts   = explode('|', $attr['segment']);
            $key     = $parts[0];
            $match   = $parts[1];
            $segment = $CI->uri->segment($key);

            if($segment === $match || $match === 'home') {
                $query  = $CI->db->order_by("start", $sort)->get_where('calendar', array('start >=' => $now), $limit); 
                $result = $query->result();
                
                foreach($result as $key) {            
                    $events[] = (array) $key;
                }
                
                return $events;
            }
        } else {
            $query  = $CI->db->order_by("start", $sort)->get_where('calendar', array('start >=' => $now), $limit); 
            $result = $query->result();
            
            foreach($result as $key) {            
                $events[] = (array) $key;
            }
            
            return $events;
        }
    }

    // --------------------------------------------------------------------
    
    public function stylesheets()
    {
        $css    = '';
        $styles = array();
        $styles[] = site_url() . 'application/modules/calendar/assets/css/fullcalendar.css';
        
        foreach($styles as $stylesheet) {
            $css .= '<link href='. $stylesheet .' rel="stylesheet" type="text/css">' . "\n";
        }
        
        return $css;
    }

    // --------------------------------------------------------------------
    
    public function javascript()
    {   
        $events = '';
        $now    = date("Y-m-d G:i:s");
        $CI     =& get_instance();
        
        $query  = $CI->db->order_by("start", 'asc')->get_where('calendar', array('start >=' => $now)); 
        $result = $query->result();
        
        foreach($result as $key => $val) {
            $events .= "{ 
                title: '". $val->title ."', 
                url: '". site_url() . "calendar/" . $val->id . "-" . date("Y-m-d", strtotime($val->created)) ."', 
                start: '". $val->start ."', 
                end: '". $val->end ."', 
                description: '". shorten_phrase( $val->description, 50 ) ."' 
            },";
        }
        
        $output  = '';
        $scripts = array();
        $scripts[] = site_url() . 'application/modules/calendar/assets/js/moment.min.js';
        $scripts[] = site_url() . 'application/modules/calendar/assets/js/fullcalendar.min.js';
        $scripts[] = site_url() . 'application/modules/calendar/assets/js/gcal.js';
        $output .= "
            <script type=\"text/javascript\">
                $(document).ready(function() {
                    // To set default view state go here: 
                    // http://stackoverflow.com/questions/12573134/fullcalendar-remember-user-option-eg-month-week-day-in-cookie
                    // http://w3facility.org/question/how-can-the-browser-remember-the-selected-view-of-week-month-day/
                    
                    $('#fullcalendar').fullCalendar({
                        header: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'month,basicWeek,'
                        },
                        //defaultDate: '2014-09-12',
                        editable: false,
                        eventLimit: true, // allow \"more\" link when too many events
                        events: [
                            ".$events."
                        ], 
                        // Load events in a modal for viewing
                        // Source: http://www.mikesmithdev.com/fullcalendar-jquery-ui-modal/
                        eventRender: function (event, element) {
                            element.attr('href', 'javascript:void(0);');
                            element.click(function() {
                                $(\"#startTime\").html(moment(event.start).format('MMM Do h:mm A'));
                                $(\"#endTime\").html(moment(event.end).format('MMM Do h:mm A'));
                                $(\"#eventInfo\").html(event.description);
                                $(\"#eventLink\").attr('href', event.url);
                                $(\"#eventContent\").dialog({ modal: true, title: event.title, width:350});
                            });
                        }
                    });
                });
            </script>";
        
        foreach($scripts as $script) {
            $output .= '<script type="text/javascript" src="' . $script . '"></script>' . "\n";
        }
        
        return $output;
    }
}
