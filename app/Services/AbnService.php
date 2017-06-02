<?php
namespace App\Services;

class AbnService extends \SoapClient {

	private $url = "http://abr.business.gov.au/abrxmlsearch/ABRXMLSearch.asmx?WSDL";
	private $guid = "1b2cc842-6922-403f-9a89-f0181622443d";

	public function __construct()
	{
	    $params = array(
	        'soap_version' => SOAP_1_1,
	        'exceptions' => true,
	        'trace' => 1,
	        'cache_wsdl' => WSDL_CACHE_NONE
	    );

	    parent::__construct($this->url, $params);
	}

	public function searchByAbn($abn, $historical = 'N')
	{
	    $params = new \stdClass();
	    $params->searchString                = $abn;
	    $params->includeHistoricalDetails    = $historical;
	    $params->authenticationGuid            = $this->guid;

	    return $this->ABRSearchByABN($params);
	}

	public function searchByName($company_name)
	{
	    $params = new stdClass();
	    $params->externalNameSearch($company_name);
	    $params->authenticationGuid = $this->guid;

	    return $this->ABRSearchByName($params);
	}
}