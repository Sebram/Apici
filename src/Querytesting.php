<?php

namespace Api;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Api\Config;
use Api\Model;
use Api\Token;
use Api\Logic;

class Querytesting {

	public static function nettoyerChaine($string) {
        $string = str_replace(' ', '-', $string);
        $string = preg_replace('/[^A-Za-z0-9]/', '', $string);
        return $string;
	}

	public static function send() {
		
		$request    =   new Request(); 

		$jsonposted =   $request->getContent();

		$token = "";
		
        
     
		$explode_pipe_toget_token = explode('|', $jsonposted);
        
         $url_for_token = "";
        if( isset($explode_pipe_toget_token[2]) ) { $url_for_token = trim($explode_pipe_toget_token[2]); }
     
		if( isset($explode_pipe_toget_token[1]) ) {

			$token = trim(str_replace('"','', $explode_pipe_toget_token[1]));
		}

		$data = trim(
			stripslashes( 
				str_replace('"','', 
					str_replace('\n','', 
						str_replace(' ','', $explode_pipe_toget_token[0]) 
						) 
					) 
				) 
			);

			$arraydata=[];

		    $array = explode(',', $data);
			
			foreach ($array as $key => $value) {
				
				$xpld = explode(':', $value); 
				
				foreach ( $xpld as $key2 => $value2 ) {
					
					if( preg_match('#int#', $value2)) { 
					
						print_r("enter parameters in : ".$value); 

						exit; 

					} elseif( preg_match('#string#', $value2)) { 

						print_r("enter parameters in : ".$value2);  					

						exit; 

					} else {

						$arraydata[] = $value2;
					}
				}
			}

			$datatosendarray = [];

			foreach ( $arraydata as $k => $val ) {
				
				$sanitize_val = str_replace( '{', '',  $val );

				$sanitize_val =implode('', explode ( '}',  $sanitize_val )); 
				
				$sanitize_val = trim( SELF::nettoyerChaine( $sanitize_val ) ); 
				
				if( $k%2 == 0 ) {
				
					$datatosendarray[$sanitize_val] = "";
					
					$sanitize_val1 = str_replace( '{', '', $arraydata[$k+1] );

					$sanitize_val1 =implode('', explode ( '}',  $sanitize_val1 ) ); 
					
					$sanitize_val1 = trim( SELF::nettoyerChaine ( $sanitize_val1 ) ); 

					$datatosendarray[$sanitize_val] .=  is_numeric($sanitize_val1) ? (int)$sanitize_val1 : $sanitize_val1 ;
				
				}
			}

        
		
	 
	    print_r(json_encode($datatosendarray));  exit;
 		
        // POST to get Token
        if($url_for_token == "url_for_token") {
           $ch = curl_init('/apici/gettoken'); // INITIALISE CURL
           $post = json_encode($datatosendarray); // Create JSON string from data ARRAY
           curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));  
           curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
           curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
           curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
           curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
           $result = curl_exec($ch);
           curl_close($ch);
           return json_decode($result);
        }
 
		 
		// TODO GET DATA AND DO CURL REQUEST TO URI
/*
		$endpoint_url = 'http://s.wbrm/apici/testing';
		// Creates our data array that we want to post to the endpoint
		$data_to_post = [
			'field1' => 'foo',
			'field2' => 'bar',
			'field3' => 'spam',
			'field4' => 'eggs',
		];

		// Sets our options array so we can assign them all at once
		$options = [
		  	CURLOPT_URL        => $endpoint_url,
			CURLOPT_POST       => true,
			CURLOPT_POSTFIELDS => $data_to_post,
		];

		// Initiates the cURL object
		$curl = curl_init();

		// Assigns our options
		curl_setopt_array($curl, $options);

		// Executes the cURL POST
		$results = curl_exec($curl);

		// Be kind, tidy up!
		curl_close($curl);
		


		$cnx = SELF::setConfig();
        $telh = $cnx->doQuery("SELECT telpers FROM personne WHERE telpers='$tel'");*/
	}
}