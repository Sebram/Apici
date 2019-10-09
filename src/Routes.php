<?php

namespace Api;
    
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use Api\Logic;

/**
 * Info(title="APICI", version="0.1")
 */
class Routes {
 

############################# *** DEV CONSORTIUM ROUTES *** ##################################
##############################################################################################
##############################################################################################
##############################################################################################

    # @Routes
    # @GET "/annonce/id"
    # @Description Retourne une annonce avec son id
    # @Param annonce/10
    # @End
    public static function annonceById() {    
        $config = Logic::setRouteResponseRequestAndTokenConfig('id');
        Logic::setRouteToReturnSelectResponseById( $config, 'habitation', $config['idhabit'] );
    } 
    



    # @Routes
    # @POST "/annonces/tel/count"
    # @Description Retourne le nombre d'annonces d'un compte à partir de son numéro de tel
    # @Param { "telhab" : "0476000000" }
    # @End
    public static function annoncesCount() {
        $config = Logic::setRouteResponseRequestAndTokenConfig();
        Logic::setRouteToReturnSelectResponseToDev( $config, 'habitation', "");
    }
    
    
    
     
    # @Routes
    # @POST "/annonces/tel"    
    # @Description Retourne toutes les annonces  et leur valeurs correspondantes à un tel
    # @Param { "dev":1, "telhab" : "0476000000", "start": 0, "nbitems": 10 }
    # @End
    public static function annoncesByTel() {  
        $config = Logic::setRouteResponseRequestAndTokenConfig();
        Logic::setRouteToReturnSelectResponseToDev( $config, 'habitation', 1 );
    }
    



    
    
    
    
    # @Routes
    # @POST "/annonces/tel/ville"
    # @Description Retourne toutes les annonces correspondantes à une ville
    # @Param { "dev":1, "telhab" : "0476000000", "ville" : "montpellier", "start": 0, "nbitems": 10 }
    # @End
    public static function annoncesByVille() {
        $config = Logic::setRouteResponseRequestAndTokenConfig();
        Logic::setRouteToReturnSelectResponseToDev( $config, 'habitation', 1 );
    }
    

    


    

    # @Routes
    # @POST "/annonces/tel/type"
    # @Description Retourne toutes les annonces correspondantes à un type (maison, appartemment ... )
    # @Param { "dev":1, "telhab" : "0476000000", "type" : "maison", "start": 0, "nbitems": 10 }
    # @End
    public static function annoncesByType() {
        $config = Logic::setRouteResponseRequestAndTokenConfig();
        Logic::setRouteToReturnSelectResponseToDev( $config, 'habitation', 1 );
    }
   
    


    
    # @Routes
    # @POST "/annonces/tel/transac"
    # @Description Retourne toutes les annonces correspondantes à une transaction (vente, location ...)
    # @Param { "dev":1, "telhab" : "0476000000", "transac" : "vente", "start": 0, "nbitems": 10 }
    # @End
    public static function annoncesBytransac() {
        $config = Logic::setRouteResponseRequestAndTokenConfig();
        Logic::setRouteToReturnSelectResponseToDev( $config, 'habitation', 1 );
    }




    
    # @Routes
    # @POST "/annonces/tel/prix"
    # @Description Retourne toutes les annonces correspondantes à un prix
    # @Param { "dev":1, "telhab" : "0476000000", "prix" : "35000", "start": 0, "nbitems":100 }
    # @End
    public static function annoncesByPrix() {
        $config = Logic::setRouteResponseRequestAndTokenConfig();
        Logic::setRouteToReturnSelectResponseToDev( $config, 'habitation', 1 );
    }

    
    


    # @Routes
    # @POST "/annonces/tel/prix/between"
    # @Description Retourne toutes les annonces correspondantes à une fourchette de prix
    # @Param { "dev": 1, "telhab": "0476000000", "from": 25000, "to": 500000 }
    # @End
    public static function annoncesByPrixBetween() { 
        $config = Logic::setRouteResponseRequestAndTokenConfig();
        Logic::setRouteToReturnSelectResponseToDev( $config, 'habitation', 0 );
    }
    

    

    # @Routes
    # @POST "/annonces/tel/piece"
    # @Description Retourne toutes les annonces correspondantes à un nombre de pièces
    # @Param { "dev": 1, "telhab": "0476000000", "piece" : 3, "start": 0, "nbitems": 100 }
    # @End
    public static function annoncesByPiece() {
        $config = Logic::setRouteResponseRequestAndTokenConfig();
        Logic::setRouteToReturnSelectResponseToDev( $config, 'habitation', 1 );
    }


 

    # @Routes
    # @POST "/annonces/tel/chambre"
    # @Description Retourne toutes les annonces correspondantes à un nombre de chambres
    # @Param { "dev": 1, "telhab": "0476000000", "chambre" : 2, "start": 0, "nbitems": 100 }
    # @End
    public static function annoncesByChambre() {
        $config = Logic::setRouteResponseRequestAndTokenConfig();
        Logic::setRouteToReturnSelectResponseToDev( $config, 'habitation', 1 );
    }





    # @Routes
    # @POST "/annonces/tel/surface"
    # @Description Retourne toutes les annonces correspondantes à une surface
    # @Param { "dev": 1, "telhab": "0476000000", "surface" : 50, "start": 0, "nbitems": 100 }
    # @End
    public static function annoncesBySurface() {
        $config = Logic::setRouteResponseRequestAndTokenConfig();
        Logic::setRouteToReturnSelectResponseToDev( $config, 'habitation', 1 );
    }
    

    
    # @Routes
    # @POST "/annonces/tel/surface/between"
    # @Description Retourne toutes les annonces correspondantes à une fourchette de surface 
    # @Param { "dev": 1, "telhab": "0476000000", "from":25, "to": 200 }
    # @End
    public static function annoncesBySurfaceBetween() {
        $config = Logic::setRouteResponseRequestAndTokenConfig();
        Logic::setRouteToReturnSelectResponseToDev( $config, 'habitation', 0 );
    }
    




################################## *** CLIENT ROUTES *** #####################################
##############################################################################################
##############################################################################################
##############################################################################################




    # @Routes
    # @POST "/apici/annonces"    
    # @Description Retourne toutes les annonces correspondantes au compte connecté et à son token
    # @Param { "dev":1, "start": 0, "nbitems": 100 }
    # @End
    public static function annonces() {  
        $config = Logic::setRouteResponseRequestAndTokenConfig();
        Logic::setRouteToReturnSelectResponseToClient( $config, 'habitation', 1 );
    }   
        
     
    # @Routes
    # @POST "/apici/annonces/prix"    
    # @Description Retourne toutes les annonces d'un compte connecté et correspondantes au prix 
    # @Param { "dev":1, "prix": 200000, "start": 0, "nbitems": 50 }
    # @End
    public static function annoncesPrix() {
        $config = Logic::setRouteResponseRequestAndTokenConfig();
        Logic::setRouteToReturnSelectResponseToClient( $config, 'habitation', 1 ); 
    }   
        

    # @Routes
    # @POST "/apici/annonces/prix/between"    
    # @Description Retourne toutes les annonces correspondantes à une fourchette de prix
    # @Param { "dev":1, "from": 50000, "to": 200000 }
    # @End
    public static function annoncesPrixBetween() {
       $config = Logic::setRouteResponseRequestAndTokenConfig();
        Logic::setRouteToReturnSelectResponseToClient( $config, 'habitation', 0 );
    }   
    

    # @Routes
    # @POST "/apici/annonces/type"    
    # @Description Retourne toutes les annonces correspondantes à un type (maison, appart...)
    # @Param { "dev":1, "type": "appartement", "start": 0, "nbitems": 100 }
    # @End
    public static function annoncesType() {
       $config = Logic::setRouteResponseRequestAndTokenConfig();
        Logic::setRouteToReturnSelectResponseToClient( $config, 'habitation', 1 );
    }   

    # @Routes
    # @POST "/apici/annonces/transac"    
    # @Description Retourne toutes les annonces correspondantes à une transaction (vente, location...)
    # @Param { "dev":1, "transac": "vente", "start": 0, "nbitems": 100 }
    # @End
    public static function annoncesTransac() {
        $config = Logic::setRouteResponseRequestAndTokenConfig();
        Logic::setRouteToReturnSelectResponseToClient( $config, 'habitation', 1 );
    }   
     

    # @Routes
    # @POST "/apici/annonces/surface"    
    # @Description Retourne toutes les annonces correspondantes à une surface
    # @Param { "dev":1, "surface": 50, "start": 0, "nbitems": 100 }
    # @End
    public static function annoncesSurface() {
        $config = Logic::setRouteResponseRequestAndTokenConfig();
        Logic::setRouteToReturnSelectResponseToClient( $config, 'habitation', 1 );
    }   
     

    # @Routes
    # @POST "/apici/annonces/surface/between"    
    # @Description Retourne toutes les annonces correspondantes à une fouchette de surface
    # @Param { "dev":1, "from": 50, "to":200 }
    # @End
    public static function annoncesSurfaceBetween() {
        $config = Logic::setRouteResponseRequestAndTokenConfig();
        Logic::setRouteToReturnSelectResponseToClient( $config, 'habitation', 0 );
    }   


    # @Routes
    # @POST "/apici/annonces/piece"    
    # @Description Retourne toutes les annonces correspondantes à un nombre de piece
    # @Param { "dev":1, "piece": 3, "start": 0, "nbitems": 10 }
    # @End
    public static function annoncesPiece() {
        $config = Logic::setRouteResponseRequestAndTokenConfig();
        Logic::setRouteToReturnSelectResponseToClient( $config, 'habitation', 1 );
    }   



    # @Routes
    # @POST "/apici/annonces/chambre"    
    # @Description Retourne toutes les annonces correspondantes à un nombre chambre
    # @Param { "dev":1, "chambre": 2, "start": 0, "nbitems": 10 }
    # @End
    public static function annoncesChambre() {
        $config = Logic::setRouteResponseRequestAndTokenConfig();
        Logic::setRouteToReturnSelectResponseToClient( $config, 'habitation', 1 );
    }   


    # @Routes
    # @POST "/apici/annonces/ville"    
    # @Description Retourne toutes les annonces correspondantes à une ville
    # @Param { "dev":1, "ville": "grenoble", "start": 0, "nbitems": 100 }
    # @End
    public static function annoncesVille() {
        $config = Logic::setRouteResponseRequestAndTokenConfig();
        Logic::setRouteToReturnSelectResponseToClient( $config, 'habitation', 1 );
    }   
        

    
    # @Routes
    # @POST "/apici/agence"    
    # @Description Retourne toutes les annonces correspondantes à une agence
    # @Param { "dev":1 }
    # @End
    public static function agence() {
        $config = Logic::setRouteResponseRequestAndTokenConfig();
        Logic::setRouteToReturnSelectResponseToClient( $config, 'personne', 1 );
    }   
        

//***************************************************************************************************************    
    
    # @Routes
    # @POST "/apici/annonces/criteres"    
    # @Description Retourne toutes les annonces correspondantes à une requêtes
    # @Param { "dev": 1, "table": "habitation", "crit":[ { "champ": "telhab" , "valeur": "0689795282" , "operateur": "=" } , { "champ": "ville" , "valeur": "montpellier" , "operateur": "=" } , { "champ": "prix" , "valeur": 100000, "operateur": ">" } ] }
    # @End
    public static function annoncesCriteres() {
        
        $config = Logic::setRouteResponseRequestAndTokenConfig();

        Logic::setRouteToReturnSelectResponseCritere( $config );
    }   
    
}
