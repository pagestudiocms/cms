<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
/**
 * PageStudio
 *
 * @author      Cosmo Mathieu
 * @copyright   Copyright (c) 2015
 * @license     MIT License
 * @link        http://pagestudioapp.com
 */
 
// -------------------------------------------------------------------

/**
 * Google Analytics PHP API Accessor
 *
 * This class can be used to retrieve data from the Google Analytics API with PHP
 * It fetches data as array for use in applications or scripts
 *
 * Changes
 * ----------------
 * This API now depends on Google PHP API
 *
 * Credits:  Vincent Kleijnendorst <http://www.swis.nl> original developer.
 *
 * @author  Cosmo Mathieu <http://cosmointeractive.co>
 * @version 0.2
 */
class ga_api 
{
	private $_sUser;
	private $_sPass;
	private $_sAuth;
	private $_sProfileId;
	private $_sStartDate;
	private $_sEndDate;
	private $_bUseCache;
	private $_iCacheAge;
    private $_client;
    private $_errors = [];  // Stores exception errors

	/**
	 * public constructor
	 *
	 * @param string $sUser
	 * @param string $sPass
	 * @return analytics
	 */
	public function __construct($params = array())
	{
		$this->_sUser = $params['username'];
		$this->_sPass = $params['password'];
        $this->clientId = $params['clientId'];
        $this->clientEmail = $params['clientEmail'];
        $this->pKey = $params['key'];

		$this->_bUseCache = false;
        
        // Load Google API libraries
        require_once BASEPATH . '../application/third_party/Google/autoload.php';
        require_once BASEPATH . '../application/third_party/Google/Client.php';
        require_once BASEPATH . '../application/third_party/Google/Service/Analytics.php';

		$this->auth();
	}

	/**
	 * Google Authentification
	 */
	private function auth()
	{
        try 
        {
            $this->_client = new Google_Client();
            echo $this->_client->setApplicationName("ApplicationName");

            if (isset($_SESSION['service_token'])) {
                $this->_client->setAccessToken($_SESSION['service_token']);
            }

            $key = file_get_contents($this->pKey);
            if (empty($key)) {
                throw new Exception('Private key not found!');
            }
            
            $cred = new Google_Auth_AssertionCredentials(
                $this->clientEmail, [
                    'https://www.googleapis.com/auth/analytics',
                ],
                $key, // Private key
                'notasecret' // Private key password
            );
            
            $this->_client->setAssertionCredentials($cred);
            
            if ($this->_client->getAuth()->isAccessTokenExpired()) {
                $this->_client->getAuth()->refreshTokenWithAssertion($cred);
            }
            $_SESSION['service_token'] = $this->_client->getAccessToken();	
            
            if ( ! is_object($this->_client) && (count(get_object_vars($this->_client)) < 0)) {
                throw new Exception('The Google Client object returned empty.');
            }
        } 
        catch(Exception $e) 
        {
            $this->_errors = $e->getMessage();
        }
	}

	/**
	 * Use caching (bool)
	 * Whether or not to store GA data in a session for a given period
	 *
	 * @param bool $bCaching (true/false)
	 * @param int $iCacheAge seconds (default: 10 minutes)
	 */
	public function useCache($bCaching = true, $iCacheAge = 600)
	{
		$this->_bUseCache = $bCaching;
		$this->_iCacheAge = $iCacheAge;
		if ($bCaching && !isset($_SESSION['cache']))
		{
			$_SESSION['cache'] = array();
		}
	}

	/**
	 * Returns an array with profileID => accountName
	 *
	 */
	public function getProfileList()
	{
		
	}

	/**
	 * get resulsts from cache if set and not older then cacheAge
	 *
	 * @param string $sKey
	 * @return mixed cached data
	 */
	private function getCache($sKey)
	{
		if ($this->_bUseCache === false)
		{
			return false;
		}

		if (!isset($_SESSION['cache'][$this->_sProfileId]))
		{
			$_SESSION['cache'][$this->_sProfileId] = array();
		}
		if (isset($_SESSION['cache'][$this->_sProfileId][$sKey]))
		{
			if (time() - $_SESSION['cache'][$this->_sProfileId][$sKey]['time'] < $this->_iCacheAge)
			{
				return $_SESSION['cache'][$this->_sProfileId][$sKey]['data'];
			}
		}
		return false;
	}

	/**
	 * Cache data in session
	 *
	 * @param string $sKey
	 * @param mixed $mData Te cachen data
	 */
	private function setCache($sKey, $mData)
	{

		if ($this->_bUseCache === false)
		{
			return false;
		}

		if ( ! isset($_SESSION['cache'][$this->_sProfileId]))
		{
			$_SESSION['cache'][$this->_sProfileId] = array();
		}
		$_SESSION['cache'][$this->_sProfileId][$sKey] = array('time' => time(),
			'data' => $mData);
	}

	/**
	 * Parses GA XML to an array (dimension => metric)
	 * Check http://code.google.com/intl/nl/apis/analytics/docs/gdata/gdataReferenceDimensionsMetrics.html
	 * for usage of dimensions and metrics
	 *
	 * @param array  $aProperties  (GA properties: metrics & dimensions)
	 *
	 * @return array result
	 */
	public function getData($aProperties = array())
	{
		$sUrl = 'https://www.googleapis.com/analytics/v2.4/data?ids=' . $this->_sProfileId .
				'&start-date=' . $this->_sStartDate .
				'&end-date=' . $this->_sEndDate . '&' .
				http_build_query($aProperties);

		// $aCache = $this->getCache($sUrl);
		// if ($aCache !== false)
		// {
			// return $aCache;
		// }
        
		$aResult   = [];        
        $analytics = new Google_Service_Analytics($this->_client);
        $metrics   = (isset($aProperties['metrics'])) ? $aProperties['metrics'] : '';
        $optParams = (isset($aProperties['optParams'])) ? $aProperties['optParams'] : '';
        
        try {
            $aResult = $analytics->data_ga->get(
                $this->_sProfileId, 
                $this->_sStartDate, 
                $this->_sEndDate, 
                $metrics,
                $optParams
            );
            
        } catch(Exception $e) {
            $this->_errors = 'There was an error : - ' . $e->getMessage();
        }
		
		// cache the results (if caching is true)
		$this->setCache($sUrl, $aResult);
        
        // $this->tabular($aResult);

		return $aResult;
	}

	/**
	 * Parse XML from account list
	 *
	 * @param string $sXml
	 */
	private function parseAccountList($sXml)
	{
		$oDoc = new DOMDocument();
		$oDoc->loadXML($sXml);
		$oEntries = $oDoc->getElementsByTagName('entry');
		$i = 0;
		$aProfiles = array();
		foreach ($oEntries as $oEntry)
		{

			$aProfiles[$i] = array();

			$oTitle = $oEntry->getElementsByTagName('title');
			$aProfiles[$i]["title"] = $oTitle->item(0)->nodeValue;

			$oEntryId = $oEntry->getElementsByTagName('id');
			$aProfiles[$i]["entryid"] = $oEntryId->item(0)->nodeValue;

			$oProperties = $oEntry->getElementsByTagName('property');
			foreach ($oProperties as $oProperty)
			{
				if (strcmp($oProperty->getAttribute('name'), 'ga:accountId') == 0)
				{
					$aProfiles[$i]["accountId"] = $oProperty->getAttribute('value');
				}
				if (strcmp($oProperty->getAttribute('name'), 'ga:accountName') == 0)
				{
					$aProfiles[$i]["accountName"] = $oProperty->getAttribute('value');
				}
				if (strcmp($oProperty->getAttribute('name'), 'ga:profileId') == 0)
				{
					$aProfiles[$i]["profileId"] = $oProperty->getAttribute('value');
				}
				if (strcmp($oProperty->getAttribute('name'), 'ga:webPropertyId') == 0)
				{
					$aProfiles[$i]["webPropertyId"] = $oProperty->getAttribute('value');
				}
			}

			$oTableId = $oEntry->getElementsByTagName('tableId');
			$aProfiles[$i]["tableId"] = $oTableId->item(0)->nodeValue;

			++$i;
		}
		return $aProfiles;
	}

	/**
	 * Get data from given URL
	 * Uses Curl if installed, falls back to file_get_contents if not
	 *
	 * @param string $sUrl
	 * @param array $aPost
	 * @param array $aHeader
	 * @return string Response
	 */
	private function getUrl($sUrl, $aPost = array(), $aHeader = array())
	{
		if (count($aPost) > 0)
		{
			// build POST query
			$sMethod = 'POST';
			$sPost = http_build_query($aPost);
			$aHeader[] = 'Content-type: application/x-www-form-urlencoded';
			$aHeader[] = 'Content-Length: ' . strlen($sPost);
			$sContent = $aPost;
		}
		else
		{
			$sMethod = 'GET';
			$sContent = null;
		}

		if (function_exists('curl_init'))
		{

			// If Curl is installed, use it!
			$rRequest = curl_init();
			curl_setopt($rRequest, CURLOPT_URL, $sUrl);
			curl_setopt($rRequest, CURLOPT_RETURNTRANSFER, 1);

			// Stop it bitching on local installs
			curl_setopt($rRequest, CURLOPT_SSL_VERIFYPEER, 0);

			if ($sMethod == 'POST')
			{
				curl_setopt($rRequest, CURLOPT_POST, 1);
				curl_setopt($rRequest, CURLOPT_POSTFIELDS, $aPost);
			}
			else
			{
				curl_setopt($rRequest, CURLOPT_HTTPHEADER, $aHeader);
			}

			$sOutput = curl_exec($rRequest);
			if ($sOutput === false)
			{
				throw new Exception('Curl error (' . curl_error($rRequest) . ')');
			}

			$aInfo = curl_getinfo($rRequest);

			if ($aInfo['http_code'] != 200)
			{
				// not a valid response from GA
				if ($aInfo['http_code'] == 400)
				{
					throw new Exception('Bad request (' . $aInfo['http_code'] . ') url: ' . $sUrl);
				}
				if ($aInfo['http_code'] == 403)
				{
					throw new Exception('Access denied (' . $aInfo['http_code'] . ') url: ' . $sUrl);
				}
				throw new Exception('Not a valid response (' . $aInfo['http_code'] . ') url: ' . $sUrl);
			}

			curl_close($rRequest);
		}
		else
		{
			// Curl is not installed, use file_get_contents
			// create headers and post
			$aContext = array('http' => array(
				'method' => $sMethod,
				'header' => implode("\r\n", $aHeader) . "\r\n",
				'content' => $sContent
			));
			$rContext = stream_context_create($aContext);

			if (($sOutput = @file_get_contents($sUrl, 0, $rContext)) === false)
			{
				// not a valid response from GA
				throw new Exception('Not a valid response url: ' . $sUrl);
			}
		}
		return $sOutput;
	}

    // -----------------------------------------------------------------
    // SETTERS
    // -----------------------------------------------------------------
    
	/**
	 * Sets GA Profile ID  (Example: ga:12345)
	 */
	public function setProfileById($sProfileId)
	{
		$this->_sProfileId = $sProfileId;
	}
    
	/**
	 * Sets the date range for GA data
	 *
	 * @param string $sStartDate (YYY-MM-DD)
	 * @param string $sEndDate   (YYY-MM-DD)
	 */
	public function setDateRange($sStartDate, $sEndDate)
	{
		$this->_sStartDate = $sStartDate;
		$this->_sEndDate = $sEndDate;
	}

	/**
	 * Sets de data range to a given month
	 *
	 * @param int $iMonth
	 * @param int $iYear
	 */
	public function setMonth($iMonth, $iYear)
	{
		$this->_sStartDate = date('Y-m-d', strtotime($iYear . '-' . $iMonth . '-01'));
		$this->_sEndDate = date('Y-m-d', strtotime($iYear . '-' . $iMonth . '-' . date('t', strtotime($iYear . '-' . $iMonth . '-01'))));
	}
    
    // -----------------------------------------------------------------
    // GETTERS
    // -----------------------------------------------------------------

	/**
	 * Get visitors for given period
	 *
	 */
	public function getVisitors()
	{
		return $this->getData(array(
			'dimensions' => 'ga:date',
			'metrics' => 'ga:visits',
			'sort' => 'ga:date'
		));
	}

	/**
	 * Get pageviews for given period
	 *
	 */
	public function getPageviews()
	{
		return $this->getData(array(
			'dimensions' => 'ga:date',
			'metrics' => 'ga:pageviews',
			'sort' => 'ga:date'
		));
	}

	/**
	 * Get pageviews for given period
	 *
	 */
	public function getTimeOnSite()
	{
		return $this->getData(array(
			'dimensions' => 'ga:date',
			'metrics' => 'ga:timeOnSite',
			'sort' => 'ga:date'
		));
	}

	/**
	 * Get visitors per hour for given period
	 *
	 */
	public function getVisitsPerHour()
	{
		return $this->getData(array(
			'dimensions' => 'ga:hour',
			'metrics' => 'ga:visits',
			'sort' => 'ga:hour'
		));
	}

	/**
	 * Get Browsers for given period
	 *
	 */
	public function getBrowsers()
	{
		$aData = $this->getData(array(
		   'dimensions' => 'ga:browser,ga:browserVersion',
			'metrics' => 'ga:visits',
			'sort' => 'ga:visits'
		));
		arsort($aData);
		return $aData;
	}

	/**
	 * Get Operating System for given period
	 *
	 */
	public function getOperatingSystem()
	{
		$aData = $this->getData(array(
			'dimensions' => 'ga:operatingSystem',
			'metrics' => 'ga:visits',
			'sort' => 'ga:visits'
		));
		// sort descending by number of visits
		arsort($aData);
		return $aData;
	}

	/**
	 * Get screen resolution for given period
	 *
	 */
	public function getScreenResolution()
	{
		$aData = $this->getData(array(
			'dimensions' => 'ga:screenResolution',
			'metrics' => 'ga:visits',
			'sort' => 'ga:visits'
		));

		// sort descending by number of visits
		arsort($aData);
		return $aData;
	}

	/**
	 * Get referrers for given period
	 *
	 */
	public function getReferrers()
	{
		$aData = $this->getData(array(
			'dimensions' => 'ga:source',
			'metrics' => 'ga:visits',
			'sort' => 'ga:source'
		));

		// sort descending by number of visits
		arsort($aData);
		return $aData;
	}

	/**
	 * Get search words for given period
	 *
	 */
	public function getSearchWords()
	{
		$aData = $this->getData(array(
			'dimensions' => 'ga:keyword',
			'metrics' => 'ga:visits',
			'sort' => 'ga:keyword'
		));
		// sort descending by number of visits
		arsort($aData);
		return $aData;
	}
    
    // ----------------------------------------------------------------
    
    /**
     * Table to display data sets for debugging.
     * @access      private
     */
    private function tabular($data)
    {
        if( ! empty($data)) {            
            echo '
            <table class="list"><tr>';
            foreach($data->getColumnHeaders() as $header){  
                print "<td>".$header['name']."</td>";   
            }
            echo '</tr>';
            
            //printing each row.
            foreach ($data->getRows() as $row) {  
                print '<tr>';
                foreach ($row as $td) {
                    echo '<td>'.$td.'</td>';
                }
                print '</tr>';
            }

            //printing the total number of rows
            echo '
            <tr><td colspan="2">Rows Returned ' . print $data->getTotalResults() . ' </td></tr>
            </table>
            </html>';
        }
    }

}