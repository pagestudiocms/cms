<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
/**
 * PageStudio
 *
 * @author      Cosmo Mathieu
 * @copyright   Copyright (c) 2015
 * @license     MIT License
 * @link        http://pagestudioapp.com
 */
class Analytics extends Admin_Controller 
{
    function __construct()
    {
        parent::__construct();
        
        $this->clientId = '601667939223-sid4ss85hs21947ntrj6vm68468k5oqi.apps.googleusercontent.com';
        $this->clientEmail = 'account-1@pagestudio-1127.iam.gserviceaccount.com';
        $this->keyFileLocation = BASEPATH . '../application/third_party/Google/PageStudio-20c49edcceae.p12';
        
        require_once BASEPATH . '../application/third_party/Google/autoload.php';
        require_once BASEPATH . '../application/third_party/Google/Client.php';
        require_once BASEPATH . '../application/third_party/Google/Service/Analytics.php';
    }
    
    // --------------------------------------------------------------

    public function index()
    {
        $data = array();
        $data['breadcrumb'] = set_crumbs(array());
        
        $results = $this->reports( $this->connect() );
        var_dump($results);

        $this->template->view('admin/index', $data);
    }
    
    // --------------------------------------------------------------
    
    private function connect()
    {
        $client_id = $this->clientId; //Client ID
        $service_account_name = $this->clientEmail; //Email Address 
        $key_file_location = $this->keyFileLocation; //key.p12

        $client = new Google_Client();
        $client->setApplicationName("ApplicationName");
        $service = new Google_Service_Analytics($client);

        if (isset($_SESSION['service_token'])) {
          $client->setAccessToken($_SESSION['service_token']);
        }

        $key = file_get_contents($key_file_location);
        $cred = new Google_Auth_AssertionCredentials(
            $service_account_name,
            array(
                'https://www.googleapis.com/auth/analytics',
            ),
            $key,
            'notasecret'
        );
        $client->setAssertionCredentials($cred);
        if($client->getAuth()->isAccessTokenExpired()) {
            $client->getAuth()->refreshTokenWithAssertion($cred);
        }
        $_SESSION['service_token'] = $client->getAccessToken();
        
        return $client;
    }

    // --------------------------------------------------------------
    
    private function reports($client)
    {
        $analytics = new Google_Service_Analytics($client);

        $profileId = 'ga:'.$this->settings->ga_profile_id;
        $startDate = date('Y-m-d', strtotime('-31 days')); // 31 days from now
        $endDate   = date('Y-m-d'); // todays date
        $metrics   = "ga:sessions";
        $optParams = array("dimensions" => "ga:date");
        
        $results = $analytics->data_ga->get($profileId, $startDate, $endDate, $metrics, $optParams);

        $data['report'] = $results->rows; //To send it to the view later
        
        return $data;
    }
}