<?php if (!defined('BASEPATH')) exit('No direct script access allowed.');
/**
 * OxygenCMS
 *
 * @author      OxygenCMS Dev Team 2015
 * @author      PyroCMS Dev Team 2008-2014
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @copyright   Copyright (c) 2016, OxygenCMS 
 *
 */
/**
 * Google Analytics PHP API
 *
 * This class can be used to retrieve data from the Google Analytics API with PHP
 * It fetches data as array for use in applications or scripts
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * Credits: http://www.alexc.me/
 * parsing the profile XML to a PHP array
 *
 *
 * @link http://www.swis.nl
 * @copyright 2009 SWIS BV
 * @author Vincent Kleijnendorst - SWIS BV (vkleijnendorst [AT] swis [DOT] nl)
 *
 * @version 0.1
 */
require_once('system/cms/libraries/Gapi.php');

/**
 * Google Analytics library for PyroCMS
 *
 * Uses GAPI (https://github.com/erebusnz/gapi-google-analytics-php-interface) to access GA data
 *
 * @author Marco Grüter
 *
 * @version 1.0
 */
class Analytics 
{
	protected $gapi;
	protected $isValid;
	protected $_path;
	protected $_email;

	/**
	 * public constructor
	 *
	 * @param string $sUser
	 * @param string $sPass
	 * @return analytics
	 */
	public function __construct($parameters)
	{
		$this->_path = SITE_STORAGE_PATH.SITE_REF.DIRECTORY_SEPARATOR.'keys'.DIRECTORY_SEPARATOR . $parameters['key_file'];
		$this->_path = str_replace(["/","\\"], DIRECTORY_SEPARATOR , $this->_path);
		$this->_email = $parameters['email'];
	}

	public function initGapi() 
	{
		$this->isValid = true;

		try
		{
			$this->gapi = new Gapi( $this->_email, $this->_path );
			$this->isValid = true;		
		}
		catch(Exception $e)
		{
			$this->isValid = false;
		}

		return $this->isValid;
	}

	public function isValid() 
	{
		return $this->isValid;
	}

	public function getToken()
	{
		return $this->gapi->getToken();
	}

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
	/**
	 * Get visitors for given period
	 *
	 */
	public function getVisitors()
	{
		$gaData = $this->gapi->requestReportData($this->_sProfileId, array('date'), array('visits'), array('date'), null, $this->_sStartDate, $this->_sEndDate);
		$aData = array();
		foreach($gaData as $row)
		{
			$aData[$row->getDate()] = $row->getVisits();
		}
		return $aData;
	}
	/**
	 * Get pageviews for given period
	 *
	 */
	public function getPageviews()
	{
		$gaData = $this->gapi->requestReportData($this->_sProfileId, array('date'), array('pageviews'), array('date'), null, $this->_sStartDate, $this->_sEndDate);
		$aData = array();
		foreach($gaData as $row)
		{
			$aData[$row->getDate()] = $row->getPageViews();
		}
		return $aData;		
	}
	/**
	 * Get referrers for given period
	 *
	 */
	public function getReferrers()
	{
		$gaData = $this->gapi->requestReportData($this->_sProfileId, array('source'), array('visits'), array('source'), null, $this->_sStartDate, $this->_sEndDate);
		$aData = array();
		foreach($gaData as $row)
		{
			$aData[$row->getSource()] = $row->getVisits();
		}
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
		$gaData = $this->gapi->requestReportData($this->_sProfileId, array('keyword'), array('visits'), array('keyword'), null, $this->_sStartDate, $this->_sEndDate);
		$aData = array();
		foreach($gaData as $row)
		{
			$aData[$row->getKeyword()] = $row->getVisits();
		}		
		// sort descending by number of visits
		arsort($aData);
		return $aData;
	}
}