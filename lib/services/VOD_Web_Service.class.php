<?php

class VOD_Web_Service{

	
	
	private $instance = null;
	
	
	public function getInstance(){
		if( !$this->instance ){
			$this->instance = new VOD_Web_Service();
		}
		
		return $this->instance;
		
	}
	


	public function sendRequest( $submit_url, $request_method="PUT", $request_data="request", &$response_code = null){
	
		$ch = curl_init();
	    curl_setopt( $ch, CURLOPT_URL, $submit_url );
	    curl_setopt( $ch, CURLOPT_HEADER, 1 );
	    //curl_setopt($ch, CURLOPT_USERPWD, self::$user.":".self::$pass);
	    //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
	    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
	    curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
	    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );

	    if($request_method == "POST")
	    {
	    	curl_setopt($ch, CURLOPT_POST, true);
	    	curl_setopt($ch, CURLOPT_POSTFIELDS, $request_data);
	    }
	    elseif($request_method == "PUT")
	    {
	    	//without this you will get "DATA REWIND ERROR"
	    	$putString = $request_data;
			$putData = tmpfile();
			fwrite($putData, $putString);
			
	    	curl_setopt($ch, CURLOPT_PUT, true);
			curl_setopt($ch, CURLOPT_INFILE, $putData);
			curl_setopt($ch, CURLOPT_INFILESIZE, strlen($putString)); 
	    }
		elseif($request_method == "DELETE")
		{
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		}
		elseif($request_method == "GET")
		{
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		}
		else
		{
			$response_code = "curl error: unknown request";
			return false;
		}
		
		
	    if(curl_exec($ch) === false)
	    {
	    	$response_code = 'curl error: ' . curl_error($ch);
	    	return false;
	    }

	    
	    if($response_code != null)$response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
		
		 return curl_multi_getcontent($ch);
	}

}
