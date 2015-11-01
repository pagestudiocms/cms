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
     * {{ calendar:events segment="1|calendar" status="published|recurring" sort="desc" limit="5" }}
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
        $next_seven_days = array();
        $datetime = new DateTime($now);
        
        // Build and array containing the dates for the next 7 days 
        // including the days of the week
        for($i = 0; $i <= 6; $i++) {
            $day_of_week_date = date("Y-m-d", strtotime($datetime->modify('+1 day')->format('Y-m-d')));
            $day_of_week = date("l", strtotime($day_of_week_date));
            $next_seven_days[$day_of_week . 's'] = $day_of_week_date;
        }
        
        $options = [
            'Sundays' => '0',
            'Mondays' => '1',
            'Tuesdays' => '2',
            'Wednesdays' => '3',
            'Thursdays' => '4',
            'Fridays' => '5',
            'Saturdays' => '6',
        ];
        
        if(isset($attr['segment'])) {
            $parts   = explode('|', $attr['segment']);
            $key     = $parts[0];
            $match   = $parts[1];
            $segment = $CI->uri->segment($key);

            if($segment === $match || $match === 'home') {
                $query  = $CI->db->order_by("start", $sort)->get_where('calendar', array('end >=' => $now), $limit); 
                $result = $query->result();
                foreach($result as $key) {  
                    /**
                     * Check if the event is a reocurrence and include it in the 
                     * list of events to return. Find the day of the week it should 
                     * reocure on and assign it a date.
                     */
                    if( ! empty($key->recurrence)) {
                        $recurrence = json_decode($key->recurrence, true);
                        foreach($options as $o_key => $o_value) {
                            $key_to_check = (in_array($o_value, $recurrence['dow'])) ? $o_key : false;
                            if(isset($next_seven_days[$key_to_check])){
                                $key->start = $next_seven_days[$key_to_check];
                            }
                        }
                        $events[] = (array) $key;
                    } else {
                        if( $key->start <= $now ) {
                            $key->start = 'Now';
                        }
                        $events[] = (array) $key;
                    }
                }
                
                return $events;
            }
        } else {
            $query  = $CI->db->order_by("start", $sort)->get_where('calendar', array('end >=' => $now), $limit); 
            $result = $query->result();

            foreach($result as $key) {
                /**
                 * Check if the event is a reocurrence and include it in the 
                 * list of events to return. Find the day of the week it should 
                 * reocure on and assign it a date.
                 */
                if( ! empty($key->recurrence)) {
                    $recurrence = json_decode($key->recurrence, true);
                    foreach($options as $o_key => $o_value) {
                        $key_to_check = (in_array($o_value, $recurrence['dow'])) ? $o_key : false;
                        if(isset($next_seven_days[$key_to_check])){
                            $key->start = $next_seven_days[$key_to_check];
                        }
                    }
                    $events[] = (array) $key;
                } else {
                    if( $key->start <= $now ) {
                        $key->start = 'Now';
                    }
                    $events[] = (array) $key;
                }
            }
            
            // Sort the events by date 
            usort($events, function($a, $b){
                $da = strtotime($a['start']);
                $db = strtotime($b['start']);
                return $da > $db; // use "<" to reverse sort
            });
            
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
        $then   = date('Y-m-d G:i:s', strtotime('-1 month', strtotime($now)));
        $CI     =& get_instance();
        
        
        $query  = $CI->db->order_by("start", 'asc')->get_where('calendar', array('end >=' => $then)); 
        $result = $query->result();
        
        foreach($result as $key => $val) {
            // $events .= "{ 
                // title: '". $val->title ."', 
                // url: '". site_url() . "calendar/" . $val->id . "-" . date("Y-m-d", strtotime($val->created)) ."', 
                // start: '". $val->start ."', 
                // end: '". $val->end ."', 
                // description: '". shorten_phrase( $val->description, 50 ) ."' 
            // },";
            // if($val->end >= $now) {
                
                $dow = '';
                if( ! empty($val->recurrence)) {
                    $recurrence = json_decode($val->recurrence, true);
                    foreach($recurrence['dow'] as $dow_key => $dow_value) {
                        $dow .= $dow_value . ',';
                    }
                    $dow .= '[' . $dow . ']';
                }
                
                $events .= json_encode(
                    array(
                        'title' => $val->title,
                        'url' => site_url() . "calendar/" . $val->id . "-" . date("Y-m-d", strtotime($val->created)), 
                        'start' => $val->start,
                        'end' => $val->end,
                        'description' => shorten_phrase( $val->description, 50 ), 
                        'dow' => $dow
                    )
                );
                $events .= ',';
            // }
        }
        
        $output  = '';
        $scripts = array();
        $scripts[] = site_url() . 'application/modules/calendar/assets/js/moment.min.js';
        $scripts[] = site_url() . 'application/modules/calendar/assets/js/fullcalendar.min.js';
        $scripts[] = site_url() . 'application/modules/calendar/assets/js/gcal.js';

        // To set default view state go here: 
        // http://stackoverflow.com/questions/12573134/fullcalendar-remember-user-option-eg-month-week-day-in-cookie
        // http://w3facility.org/question/how-can-the-browser-remember-the-selected-view-of-week-month-day/
        $output .= "
            <script type=\"text/javascript\">
                $(document).ready(function() {
                    
                    $('#fullcalendar').fullCalendar({
                        header: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'month,basicWeek,'
                        },
                        defaultDate: moment(),
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
            </script>\n";
        
        foreach($scripts as $script) {
            $output .= '<script type="text/javascript" src="' . $script . '"></script>' . "\n";
        }
        
        return $output;
    }
}
