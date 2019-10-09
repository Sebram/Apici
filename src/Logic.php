<?php 

namespace Api;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Api\Config;
use Api\Model;
use Api\Token;
use Api\Validator;

class Logic {



    
    public static function getHabitationFields($dev) {
        $fields = " idhabit 
        ,telhab
        ,numero
        ,visible 
        ,descriptif 
        ,titre 
        ,titre_en 
        ,type
        ,piece
        ,surface
        ,prix
        ,prix_netv
        ,adresse_bien
        ,idrue
        ,rue
        ,numrue
        ,ville
        ,quartier
        ,secteur
        ,environnement
        ,proximite
        ,departement
        ,pays
        ,insee
        ,cpdep
        ,exposition
        ,chauffage
        ,chaufindcoll
        ,chambre
        ,sejour 
        ,sbain
        ,seau
        ,wc  
        ,terrain 
        ,cos
        ,carrez
        ,jardin
        ,balcon
        ,nbbalcon 
        ,terrasse 
        ,nbterrasse 
        ,veranda 
        ,garage 
        ,parking 
        ,cave 
        ,piscine 
        ,tennis 
        ,standing
        ,dependance 
        ,climatisation 
        ,cheminee 
        ,cuisine
        ,ascenseur 
        ,handicape 
        ,etages 
        ,etage 
        ,construction
        ,etat
        ,typeconstruction
        ,typetoiture
        ,fosseseptique 
        ,toutalegout 
        ,combleamenageable 
        ,soussol 
        ,soussoltype
        ,digicode
        ,interphone 
        ,gardien 
        ,etatimmeuble
        ,charges 
        ,delaicharges  
        ,chargescomprises 
        ,depot
        ,fonciere 
        ,travaux 
        ,exclusivite 
        ,prestige 
        ,1ere_acquisition 
        ,neuf 
        ,ccoeur 
        ,investisseur 
        ,ce 
        ,bce
        ,ges 
        ,bges
        ,nodpe 
        ,dpeencours 
        ,dpevierge 
        ,datedpe
        ,ddgarantie
        ,date1 
        ,dated
        ,loc  
        ,meuble 
        ,vue
        ,centreville 
        ,maisonville 
        ,mer 
        ,montagne
        ,commission
        ,locasais 
        ,prixloccession 
        ,cession 
        ,honoraires
        ,honoraires_euro 
        ,honoraires_vendeur_euro 
        ,honoraires_charge 
        ,frais_visites
        ,frais_bail
        ,frais_dossier 
        ,frais_etatlieux 
        ,frais_pourcent
        ,statut_copropriete 
        ,numlot_copropriete 
        ,nblots_copropriete 
        ,quotepart 
        ,quotepart_tantiemes  
        ,syndicat_procedure 
        ,detail_procedure
        ,descen
        ,virtuelle
        ,perso 
        ,type2
        ,urlphoto
        ,nbphotos
        ,idedit
        ,vendu_loue
        ,date_vendu_loue
        ,baissedeprix
        ,constructible 
        ,viager
        ,viagertype
        ,viagerbouquet 
        ,viagerrente
        ,viagernbtete 
        ,viagerperiod 
        ,mandatdatedebut 
        ,mandatdatefin
        ,mandattype
        ,mandatnumregistre
        ,vitrine  
        ,journaltexte
        ,estimationmin 
        ,prixconsult 
        ,capacite 
        ,caution 
        ,detenteurcle
        ,immeuble 
        ,delegation 
        ,prixnegociable 
        ,parkingcouvert 
        ,taxe_habitation 
        ,complement_loyer 
        ,provision_charges 
        ,modalite_charges 
        ,url_bareme
        ,refinterne
        ,archivage_statut 
        ,titre_de
        ,titre_es
        ,titre_it
        ,titre_pt
        ,titre_nl
        ,titre_ru";
        
        return "*";
        
    }
    





    public static function setConfig(){
        $C = new Config();
        $cnx = new Model( $C );
        $cnx->set();
        return $cnx;
    }
    






    public static function telCheck($tel) {
        $cnx = SELF::setConfig();
        $telh = $cnx->doQuery("SELECT telpers FROM personne WHERE telpers='$tel'");
        if($telh[0]['telpers']==$tel)return true;
        return false;
    }

    




    // return error message or json_data
    public static function jsonCheck( $json ) {
        $ok=null;  $message ="";  
        
        foreach ( $json as $string ) {
            json_decode( $string );
           
            switch ( json_last_error() ) {
                case JSON_ERROR_NONE: $ok = true;
                break;
                case JSON_ERROR_DEPTH:
                    $message =  'ErrorCode : Profondeur_maximale_atteinte';
                break;
                case JSON_ERROR_STATE_MISMATCH:
                     $message = 'ErrorCode : Inadéquation_des_modes_ou_underflow';
                break;
                case JSON_ERROR_CTRL_CHAR:
                     $message = 'ErrorCode : Erreur lors du contrôle des caractères';
                break;
                case JSON_ERROR_SYNTAX:
                     $message = 'ErrorCode : Erreur de syntaxe ; JSON malformé'. $string;
                break;
                case JSON_ERROR_UTF8:
                     $message = 'ErrorCode : Caractères UTF-8 malformés, probablement une erreur d\'encodage';
                break;
                default:
                     $message = 'ErrorCode : Erreur inconnue';
                break;
            }
            if($ok)return json_decode( $string );
            return $message;
            // echo PHP_EOL;
        }
    }
    






    // need object Response
    public static function return_response(JsonResponse $response, $code, $data) {
        $array_reponse_definitive = array( 
            'count'=> is_array($data) ? count($data) : 0,
            'code' =>$code ,
            'data' => $data
        );
        $response->headers->set('Content-Type', 'application/json');
        $response->setStatusCode($code);
        $reponse = $response->setData( $array_reponse_definitive ); 
        $response->send();
    }









	public static function setDataReceivedFromPost($config) {
		$arraydata=[];
		foreach($config['data'] as $key => $data) {
		    $arraydata[$key]= $data; 
		    if(is_array($data)){
		        foreach($data as $k => $val) {
		            $arraydata[$key][$k]=$val;
		        }
		    }
		}
          
		return $arraydata;
	}










	public static function setRouteResponseRequestAndTokenConfig($type=null) {
        
       
		if($type==null) 
        {
			$response   =   new JsonResponse();
			$request    =   new Request(); 
			$veriftoken =   Token::verifToken();
			$jsonposted =   $request->getContent();
			$data[]     =   $jsonposted;   
            
          
            if($data[0] == 'no parameters' ){ $data ='';}
			$datatmp    =   SELF::jsonCheck($data);
			$data       =   $datatmp;
            
            
            
			$config = array(
			    "response" => $response,
			    "request"   =>$request,
			    "veriftoken"=>$veriftoken,
			    "jsonposted"=>$jsonposted,
			    "data"    =>  $data,
			    "statutcode"=>null,
			);
            
			return $config;

		} else {
			$request = Request::createFromGlobals(); 
        	$idhabit = $request->query->all()[$type];
        	$response = new JsonResponse();
        	$veriftoken = Token::verifToken();
        	$config = array(
			    "response" => $response,
			    "request"  =>$request,
			    "veriftoken"=>$veriftoken,
			    "idhabit" => $idhabit,
			    "statutcode"=>null,
			);
            
          //  print_r($config);
            
			return $config;
		}
	}









	public static function setRouteToReturnSelectResponseById( $config, $table, $idhabit ) {

		if( $config['veriftoken'] != 3 ) {
            if ( $config['veriftoken'] != 0 ) {
                $cnx = SELF::setConfig();
                $dev = isset($data->dev); $dev=1;
                $fields = SELF::getHabitationFields($dev);
                $datarow = $cnx->doQuery("SELECT ".$fields." FROM habitation WHERE idhabit ='$idhabit'");
                $cnx->closeCnx();  

                SELF::return_response($config['response'], 200,  $datarow);
            } else {
                SELF::return_response($config['response'], 401, 'Le login est inexistant, contacter le service technique');
              }
            
        } else {
            SELF::return_response($config['response'], 401,  'Token time out');
        } 
	}









	public static function checkIfErrorCode($config) {
     
		if(is_string($config['data']) && preg_match( '#ErrorCode#i', $config['data'] ) ) {
	       	
            $config['statutcode'] =   409;

            return SELF::return_response($config['response'], $config['statutcode'], $config['data']); 

        } 
        else return 2;

	}









	public static function issetDatavalue($datavalue) {
		$data = [];
		if( isset($datavalue['dev']) ) {   
        	$data [] = $datavalue['dev'];
        	unset($datavalue['dev']); 
        	$data [] = $datavalue;
        }
        return $data;
	}









	public static function prepareQuery($datavalue) {
        
        $issetdatavalue = SELF::issetDatavalue($datavalue);
		$dev 		= 	isset($issetdatavalue[0]) ? $issetdatavalue[0] : "";
        $datavalue2  = 	isset($issetdatavalue[1]) ? $issetdatavalue[1] : $datavalue;
        $fields     =   SELF::getHabitationFields($dev);
        $cnx        =   SELF::setConfig();
        $datarow    =   null;
        $countdata  =   count($datavalue2);
    	$xplduri = explode("/", $_SERVER['REQUEST_URI']);
        $count_uri = $xplduri[count($xplduri)-1];

        $array = [
        	'dev'=>$dev, 
	    	'datavalue'=>$datavalue2, 
	    	'fields'=>$fields, 
	    	'cnx'=>$cnx, 
	    	'datarow'=>$datarow,
	    	'countdata'=>$countdata,
	    	'count_uri'=>$count_uri
    	];
    	return $array;
	}






	public static function prepareSelectQ($prepare, $table, $telhab) {
        
        // echo "<pre>";  print_r($prepare); die;
        
		$query = "SELECT ".$prepare['fields']." ";

        if( $prepare['count_uri']=='count') { 
            $query = "SELECT count(*) as count "; 
        }
        elseif($prepare['count_uri'] == 'agence') {
          
            $query .= "FROM ".$table." WHERE telpers ='".$telhab."' "; 
            
        }
        elseif( $prepare['count_uri'] != 'count'  ||  $prepare['count_uri'] != 'annonces' ||  $prepare['count_uri'] != 'agence' || $prepare['count_uri'] != 'tel'  ) {
            
            $query .= "FROM ".$table." WHERE telhab ='".$telhab."' "; 
         
        }
 

        return $query;
	}









	public static function prepareFromWhereQ($query, $prepare, $search_by, $table, $telhab, $config) {

       if( $prepare['count_uri'] != 'tel' && $prepare['count_uri']!='count'  ) { unset($prepare['datavalue']['telhab']) ; }

        $arraykeys = array_keys( $prepare['datavalue'] );
        
		foreach( $arraykeys as $tabkey ) {
      
            if( $tabkey != 'nbitems' && $tabkey != 'start'  ) {

                if($prepare['count_uri']=='count') {
                    
                    $query .= "FROM ".$table." WHERE telhab ='".$telhab."' ";
                }
                elseif($prepare['count_uri']=='tel'){
                   
                    //$query .= "FROM ".$table." WHERE telhab ='".$telhab."' ";
                    
                }
                
                elseif($search_by != 0 && $search_by != 1){ break;}
   
                if($tabkey == 'transac') { $tabkey = 'loc'; }

                elseif( $tabkey == 'from' ) {
                    
                    $xplduri = explode("/", $_SERVER['REQUEST_URI']);
                    
                    $tabkey = $xplduri[count($xplduri)-2];
                }
        
                if( $search_by && $search_by != "" && $prepare['countdata'] > 2 && !in_array(  $prepare['count_uri'], array('tel', 'count'))) { 
                
                   $query .= " AND ".$tabkey." = '".( $tabkey=='loc' ? $prepare['datavalue']['transac'] : $prepare['datavalue'][$tabkey])."' "; 
                }

                elseif(!$search_by ){ $query .= " AND ".$tabkey." "; }
            }

            if( is_int($search_by) ) {

                if($search_by) {

                	if(isset($prepare['datavalue']['start']) && isset($prepare['datavalue']['nbitems']) ) 
                    {
                    	$query .= " LIMIT ".$prepare['datavalue']['start'].", ".$prepare['datavalue']['nbitems']."; ";  break;
                	}
                	else
                	{
                		 SELF::return_response( $config['response'], $config['statutcode'], "Vous êtes en mode de requête BETWEEN et non en LIMIT! placez le paramètre à FALSE"); die; 
                	}
                }
                elseif(!$search_by) {
                	if(isset($prepare['datavalue']['from'])) {

                    	$query .= " BETWEEN ".$prepare['datavalue']['from']." AND ".$prepare['datavalue']['to']."; ";  break;
                	}
                	else
                	{
                		 SELF::return_response( $config['response'], $config['statutcode'], "Vous êtes en mode de requête LIMIT et non en BETWEEN! placez le paramètre à TRUE"); die; 
                	}
                }
              
            }
        }
        return $query;
	}
 

 
 
 
 
 

	# if search_by == true  its by "select limit start and nbitems"
	# else if search_by == false its "select between from and to"

	public static function setRouteToReturnSelectResponseToDev ($config, $table, $search_by="") {
    
        if( $config['veriftoken'] == 1 ) {
  
            if( SELF::checkIfErrorCode($config) == 2  ) { 
  
                $config['statutcode'] =   200; 
    
                $datavalue = SELF::setDataReceivedFromPost( $config );
                
                $telhab="";
                
                if($datavalue['telhab'] != "" ) {
                    $telhab = $datavalue['telhab'] ; 
                }
                
                if( SELF::telCheck( $telhab )=='1' ) { 
     
                    $prepare = SELF::prepareQuery($datavalue);

                    $query = SELF::prepareSelectQ($prepare, $table, $telhab);
  
                    if(is_int( $search_by ) ) {

                        $query = SELF::prepareFromWhereQ( $query, $prepare, $search_by, $table, $telhab, $config );
                        
       
                    }
                    else {
                        $query = SELF::prepareFromWhereQ( $query, $prepare, "", $table, $telhab, $config );
                    }
                    
           
                    $datarow = $prepare['cnx']->doQuery(trim((string)$query));

                    SELF::return_response( $config['response'], $config['statutcode'], $datarow); 

                    $prepare['cnx']->closeCnx();

                } 

                else {
	                $config['statutcode'] =   404; 

	                SELF::return_response($config['response'], $config['statutcode'], 'Le téléphone est inexistant'); 
	            }
	        } 

            else {

	        	SELF::checkIfErrorCode($config); 
	        }      
	    }
	    elseif($config['veriftoken']==3) {

	        $config['statutcode']=401; 

	        SELF::return_response($config['response'], $config['statutcode'], 'Token time out'); 
	    } else {

	        $config['statutcode']=401; 

	        SELF::return_response($config['response'], $config['statutcode'], 'Vous n\'êtes pas Dev Consortium'); 
	    } 

	}






	 # if search_by == true  its by "select limit start and nbitems"
	 # else if search_by == false its "select between from and to"

	public static function setRouteToReturnSelectResponseToClient ($config, $table, $search_by="") {
         
	    if( $config['veriftoken'] > 3 ) {
 
	    	if( SELF::checkIfErrorCode($config) == 2  ) { 
            
	            $config['statutcode'] =   200; 
    
	            $datavalue = SELF::setDataReceivedFromPost( $config );

	            $telhab = $config['veriftoken'];

				unset($datavalue['telhab']); if($datavalue['tel']){ unset($datavalue['tel']); }
	            
	            if($telhab != "" && SELF::telCheck( $telhab )) { 
					
                    $prepare = SELF::prepareQuery($datavalue);

                    $query = SELF::prepareSelectQ($prepare, $table, $telhab);
 
                    if(is_int( $search_by ) ) {
 
                        $query = SELF::prepareFromWhereQ( $query, $prepare, $search_by, $table, $telhab, $config );
                        
                    }
                    else {
                        $query = SELF::prepareFromWhereQ( $query, $prepare, "", $table, $telhab, $config );
                    }
                    

                    $datarow = $prepare['cnx']->doQuery($query);
                  
                    SELF::return_response( $config['response'], $config['statutcode'], $datarow); 

	                $prepare['cnx']->closeCnx();

	            } else {

	                $config['statutcode'] =   404; 

	                SELF::return_response($response, $config['statutcode'], 'Le téléphone est inexistant'); 
	            }
	        } else {

	        	SELF::checkIfErrorCode($config); 
	        }      
	    }
	    elseif($config['veriftoken']==3) {

	        $config['statutcode']=401; 

	        SELF::return_response($config['response'], $config['statutcode'], 'Token time out'); 
	    } else {

	        $config['statutcode']=401; 

	        SELF::return_response($config['response'], $config['statutcode'], 'Vous n\'êtes pas Dev Consortium'); 
	    } 
	}


    
    public static function setRouteToReturnSelectResponseCritere ( $config ) {
        
        $table="";   
        
        $critere =  $config['data']->crit;
        
        $cnx        =   SELF::setConfig();
        
        if( $config['veriftoken'] != 3 ) {
                
            if ( SELF::checkIfErrorCode($config) == 2  ) {
            
            
                $table = $config['data']->table; 
                
                $laquery = "SELECT * FROM " . $table . " WHERE ";
                
                foreach( $critere as $key => $crit ) {
                    
                    if( is_numeric( $crit->valeur ) ) { $laquery .= trim( $crit->champ ) .' '. trim( $crit->operateur ) .' '. trim( $crit->valeur );  }
                    
                    else { $laquery .= $crit->champ .' '. $crit->operateur .' \''.  trim( addslashes( $crit->valeur ) ).'\' ';  }
                    
                    if($key < count($critere)-1) {
                        
                        $laquery .= ' AND '; 
                    }
                }
                
                /** TODO QUERY WITH LIKE "%$%" et printf  ***/
                
                
                
                
                $cnx = SELF::setConfig();
                 
                $datarow = $cnx->doQuery( $laquery );
                
                if(count($datarow)>0) {
                    
                    $config['statutcode']=200; 

	                SELF::return_response($config['response'], $config['statutcode'], $datarow);
                }
                
            } else {
                
	        	SELF::checkIfErrorCode($config); 
	        }
        
        } elseif ( $config['veriftoken']==3 ) {

	        $config['statutcode']=401; 

	        SELF::return_response($config['response'], $config['statutcode'], 'Token time out');
	    }
    }


}