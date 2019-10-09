<?php 
namespace Api;
    
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Api\Routes;
use Api\Token;
use Api\Apidoc;
use Api\Querytesting;
class Control {    

    public static function Uri() {
        //$routesclasspathname = "/home/passimmopro/www/apici/src/Routes.php";
        $routesclasspathname = "../apici/src/Token.php";
        
        $routesclasspathname2 = "../apici/src/Routes.php";
        
        switch($_SERVER['REQUEST_URI']) {

            case "/apici/apidoc" :   Apidoc::readAnnotation(array($routesclasspathname,$routesclasspathname2)); break; 
            case "/apici/gettoken" :  return Token::getToken(); break;
            case "/apici/annonce/" . @$_GET['id'] : return Routes::annonceById(); break;
            case "/apici/annonces/tel" :  return Routes::annoncesByTel();   break;
            case "/apici/annonces/tel/count" : return Routes::annoncesCount(); break;
            case "/apici/annonces/tel/ville" :  return Routes::annoncesByVille();  break;
            case "/apici/annonces/tel/type" : return Routes::annoncesByType();  break;
            case "/apici/annonces/tel/transac" : return Routes::annoncesByTransac();  break;
            case "/apici/annonces/tel/prix" : return Routes::annoncesByPrix();  break;
            case "/apici/annonces/tel/prix/between" : return Routes::annoncesByPrixBetween();  break;
            case "/apici/annonces/tel/piece" : return Routes::annoncesByPiece();  break;
            case "/apici/annonces/tel/chambre" : return Routes::annoncesByChambre();  break;
            case "/apici/annonces/tel/surface" : return Routes::annoncesBySurface();  break;
            case "/apici/annonces/tel/surface/between" : return Routes::annoncesBySurfaceBetween();  break;

            case "/apici/annonces" : return Routes::annonces();  break;
            case "/apici/annonces/prix" : return Routes::annoncesPrix();  break;
            case "/apici/annonces/type" : return Routes::annoncesType();  break;
            case "/apici/annonces/transac" : return Routes::annoncesTransac();  break;
            case "/apici/annonces/surface" : return Routes::annoncesSurface();  break;
            case "/apici/annonces/piece" : return Routes::annoncesPiece();  break;
            case "/apici/annonces/chambre" : return Routes::annoncesChambre();  break;
            case "/apici/annonces/ville" : return Routes::annoncesVille();  break;
            case "/apici/annonces/prix/between" : return Routes::annoncesPrixBetween();  break;
            case "/apici/annonces/surface/between" : return Routes::annoncesSurfaceBetween();  break;
            case "/apici/agence" : return Routes::agence();  break;
            case "/apici/annonces/criteres" :  return Routes::annoncesCriteres();  break;
            
       
           
        }   
    }    
}
 