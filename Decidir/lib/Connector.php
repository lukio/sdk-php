<?php
namespace Decidir; 

define('DECIDIR_VERSION','1.0.0');

class Connector
{
	private $connection_timeout = NULL;
	private $local_cert = NULL;
	private $end_point = NULL;
	
	private $authorize = NULL;
	private $operation = NULL;
	
	private $merchant;
	
	const DECIDIR_ENDPOINT_TEST = "https://sandbox.decidir.com/services/t/1.1/";
	const DECIDIR_ENDPOINT_PROD = "https://sps.decidir.com/services/t/1.1/";
	
	public function __construct($header_http_array, $endpoint, $merchant = null){
		
		if(($endpoint != self::DECIDIR_ENDPOINT_TEST)&&($endpoint != self::DECIDIR_ENDPOINT_PROD))
			throw new \Decidir\Exception\InvalidEndpointException($endpoint);
		
		$this->end_point = $endpoint;
		$this->header_http = $this->getHeaderHttp($header_http_array);
		$this->merchant = $merchant;
		
		$this->authorize = new \Decidir\Authorize($this->end_point, $this->header_http);
		$this->operation = new \Decidir\Operation($this->end_point, $this->header_http);
	}
	
	public function Authorize() {
		return $this->authorize;
	}

	public function Operation() {
		return $this->operation;
	}
	
	private function getHeaderHttp($header_http_array){
		$header = "";
		foreach($header_http_array as $key=>$value){
			$header .= "$key: $value\r\n";
		}
		
		return $header;
	}
	
}