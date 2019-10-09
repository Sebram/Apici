<?php
namespace Api;
    
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Api\Config;
use Api\Model;
use \Firebase\JWT\JWT;
use Api\Logic;
use Api\Apidoc;
 
class Token {
    
    
    public static function setConfig(){
        $C = new Config();
        $cnx = new Model( $C );
        $cnx->set();
        return $cnx;
    }

    # @Routes
    # @POST "/apici/gettoken"
    # @Description Retourne le token
    # @Param { "login" : "seb", "password": "xyzxyz" }
    # @End
    public static function getToken() {
        
        $request = new Request(); // new object httpfoudation/Request
        
        $jsonposted =  $request->getContent(); // Recup le contenu json 
        
        $data[] = $jsonposted; // implemente le contenu du json dans tableau
        
        $datatmp = Logic::jsonCheck($data); // check si le json est bon
        
        $data = $datatmp;
        
        if(is_string($data) && preg_match( '#ErrorCode#i', $data ) ) { // si jsonCheck retourne du string et le code "ErrorCode"
            
            $statutcode=409; // Conflict
            
            $array_reponse_definitive = array(  // data Reponse
            
            'count'=>0,
            
            'code' =>$statutcode,
            
            'data' => $data
            );

            $response = new JsonResponse();
                    
            $response->headers->set('Content-Type', 'application/json');
            
            $response->setStatusCode($statutcode);
            
            $reponse = $response->setData($array_reponse_definitive);      
      
            $response->send();
            
        } else { // Sinon 
            
            $login = isset($data->login) ? $data->login : null;  // si login est existant on enregistre, sinon null
            
            $pass = isset($data->password) ? $data->password : null;  // si pass est existant on enregistre, sinon null
            
            if($login != null && $pass != null) { // Si bien login et pass bien rempli on agit
                
                $cnx = Logic::setConfig(); // Config bdd
                
                $datarow=null;
                
                $datarow = $cnx->doSelect("SELECT * FROM login_secret_key WHERE login ='$login' and password='$pass'"); //requete sql
                
                if( count($datarow)>0 ) {
                    
                     
                    //file_put_contents ('/home/passimmopro/www/apici/src/test.txt', print_r($datarow,  1)  );
                    
                    $droit =  $datarow[0]['droit']; // on recupere le code de droit

                    
                    if($droit==1){ $telpers = 'devconsortium'; } // si le droit = 1 (full right dev) alors telpers = devconsortium
                    
                    else { $telpers =  $datarow[0]['telpers']; } // sinon on récupère le telpers
                    
                    $encoded_id = base64_encode($telpers); // puis on encode le telpers en base64
                    
                    $secret_key = $datarow[0]['secret_key']; // On recupere la secret_key enregistré en base 
                    
                    //file_put_contents ('/home/passimmopro/www/apici/src/test.txt', print_r($encoded_id. ' '.$secret_key,  1), FILE_APPEND  );
                    
                    // puis on créer le token avec le telpers encodé, le telpers normal et le timestamp du moment
                    
                    $token = array(  
                    
                        "iss" => $encoded_id,
                        
                        "iat" => $telpers, 
                        
                        "nbf" => time()
                    );
                    
                    $jwt = JWT::encode($token, $secret_key); // on créé ensuite le JWT à l'aide de la secret_key
                    
                    // puis on l'insère dans login_token_tmp avec son secret_key
                    
                    $datarow = $cnx->doQuery("INSERT INTO login_token_tmp SET secret_key ='$secret_key', token='$jwt', tokentime='".time()."'");
                    
                    $cnx->closeCnx();
                    
                    $response = new JsonResponse();
                    
                    $response->headers->set('Content-Type', 'application/json');
                    
                    $response->setStatusCode(200);
                    
                    $reponse = $response->setData(array('token' =>  $jwt));  // On implemente la réponse pour renvoyer le token
                    
                    $reponse->send(); // on renvoi le token
                    
                } else { //  Sinon on prépare une réponse "Unauthorized" code 401
                
                    $response = new JsonResponse();
                    
                    $response->headers->set('Content-Type', 'application/json');
                    
                    $response->setStatusCode(401);
                    
                    $reponse = $response->setData(array('data' =>  array('data'=>'login not exist', 'code'=>401, 'description'=>'Unauthorized')));      

                    $response->send();
                }
            }
            
            else { //  Sinon on prépare une réponse "Unauthorized" code 401
                
                $response = new JsonResponse();
                
                $response->headers->set('Content-Type', 'application/json');
                
                $response->setStatusCode(401);
                
                $reponse = $response->setData(array('data' =>  array('data'=>'login not exist', 'code'=>401, 'description'=>'Unauthorized')));      

                $response->send();
            }
        }
    }
    
    
    




   
    # retourne 1 si c'est un dev de chez nous
    # retourne 3 si c'est le token est time out
    # retourne le telpers si existant sinon retourne 0
    #
    public static function verifToken() {
        
        $request = Request::createFromGlobals();  // object httpfondation/request
        
        $header = $request->headers->all(); // recup de tous le header

        $token = isset($header['authorization'][0]) ? $header['authorization'][0] : "Unauthorized"; // recup du token reçus dans le header
        

        $token = str_replace('Bearer', '', $token); // nettoyage du token
        
        $token = trim($token);  // nettoyage du token
        
        $cnx = Logic::setConfig(); // config connect bdd
        
        
        // on récup les info de connexion dans login_token_tmp avec le token
        
        $infoKey = $cnx->doSelect("SELECT * FROM  login_token_tmp  WHERE  token LIKE '$token'"); 
       
        $time = isset($infoKey[0]['tokentime']) ? $infoKey[0]['tokentime'] : "Unauthorized"; // on recup la date de l'enregistrement du token
        
        $secretK = isset($infoKey[0]['secret_key']) ? $infoKey[0]['secret_key'] : "Unauthorized";  // on recup la secret_key
         
       
        $decoded = $decoded_array=""; // init value 
        

        if( $secretK != "" ) {
             
            
           $decoded = JWT::decode($token, $secretK, array('HS256')); // on decode le token
            
           //file_put_contents ('/home/passimmopro/www/apici/src/test.txt', print_r($decoded,  1) , FILE_APPEND );
           
           $decoded_array = (array)$decoded;  // on cast le token en tableau
        } 
        else {
            
            print_r( "empty key... " );
        }
          
        
        if( time() > $time+3600 ) {  // on vérifie le timing du token si ça depasse une heure il faudra alors se reconnecter avec login/pass
           
           //********************* TODO DELETE TOKEN  HERE *********************

           return 3;  // time out
           
        } else {
            
            $tokenfromtelhab = base64_decode($decoded_array['iss']);  // on decode le telhab envoyé en base64 dans le token

            // on récup les infos login (telpers et droit) avec la secret_key et le telhab décodé
            $infoperstoken = $cnx->doSelect("SELECT * FROM login_secret_key WHERE  secret_key = '$secretK' and telpers='$tokenfromtelhab'");
            
            $telpers = $infoperstoken[0]['telpers']; // recup du telpers
            
            $droit = $infoperstoken[0]['droit']; // recup du droit (1=dev, 0=client ou presta)
            
            $cnx->closeCnx(); // fermeture connexion
            
            if($droit) { 
            
               return 1;  //si droit full right c'est ok on retourne 1 - ok 
            
            } elseif( $telpers != "") { // sinon si c'est un tel, on vérifie  que le tel est existant dans personne 
                
                $cnx = Logic::setConfig();
                
                $infotelpers = $cnx->doSelect("SELECT telpers FROM  personne  WHERE  telpers = '$telpers'");
                
                // Si le telhab est existant alors on le retourne 
                
                if( $infotelpers[0]['telpers'] != "" ) {
                    
                    return  $infotelpers[0]['telpers'];   
                }                
                else return 0;  // telhab inexistant on retourne 0
            }
        }
    }

   
}
