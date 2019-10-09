<?php
namespace Api;

use \PDO;

set_time_limit ( 30000 );

# ---------------------------------------------------------------------
class Model
{
	public $cnx ;
	public $_cnx ;
	public $confobj;
	
    public function __construct( Config $C, $post='' ) {	
		$this->confobj = $C;
		if(@$post) { $C->setdbConfig($post); }
		else { $C->setdbConfig(); }
		$this->cnx = $C->getConfig();
	}
	
    public function getCnx() {
        
		return $this->cnx;
	}
	
    public function connected() {
		if( $this->_cnx ) { return TRUE; }
		else return FALSE;
	}
	
    public function set() {
		$this->_cnx = new PDO( $this->getCnx()[0], $this->getCnx()[1], $this->getCnx()[2], array( PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8" ));
	}
    
	public function closeCnx() {
		$this->_cnx = null; 
	}

	public function quotes($string) {
		return $this->_cnx->quote($string);
	}
	
	public function doQuery($query) {
	 	//echo $query ;
		$result = $this->_cnx->prepare( $query );
		if($result->execute()) {
			if(preg_match('#SELECT#i' , $query)){
				while ($row = $result->fetchAll( PDO::FETCH_ASSOC ) ){
					return $row;
				}
			}
			else return true;
		}
		else {
			echo "<h4 style='background-color:blue; color:white'><em> ";
				print_r($result->errorInfo());
			echo "</em></h4>";
		}
	}
    
    public function doSelect($query) {
	 	//echo $query ;
		$result = $this->_cnx->prepare( $query );
		if($result->execute()) {
		    return $row = $result->fetchAll( PDO::FETCH_ASSOC ) ;
		}
		else {
			echo "<h4 style='background-color:blue; color:white'><em> ";
				print_r($result->errorInfo());
			echo "</em></h4>";
		}
	}


	public function doInsert($query) {
	//	echo $query ;
		$result = $this->_cnx->prepare( $query );
		 if( $result->execute() ) return true;
		else {
			echo "<h4 style='background-color:blue; color:white'><em>";
				print_r($result->errorInfo());
			echo "</em></h4>";
		}
	}

	public function doInsertAndGetLastIserted($query) {
	//	echo $query ;
		$result = $this->_cnx->prepare( $query );
		 if( $result->execute() ) return $this->_cnx->lastInsertId();
		else {
			echo "<h4 style='background-color:blue; color:white'><em>";
				print_r($result->errorInfo());
			echo "</em></h4>";
            
            return $result->errorInfo()[2];
		}
	}

	
	
	public function getAllFromTableName($table, $DESC="", $id="") {
        $query 	= "SELECT * FROM ".$table;
        if($DESC!="" && $id!=""){ $query 	= "SELECT * FROM ".$table ." ORDER BY $id DESC"; }
        $result = $this->_cnx->prepare( $query );
        $result->execute();	
        $row 	= $result->fetchAll( PDO::FETCH_ASSOC ) ;
        return 	$row;
	}

    
    
    
 // getFromTableNameWhere  should be called getFromTableNameWhereTmp0 !!
	public function getFromTableNameWhere( $newtable, $habit_mandat ) {
		$query 	= "SELECT * FROM ".$newtable." WHERE tmp0 ='".$habit_mandat."'";
 		$result = $this->_cnx->prepare( $query );
	 	if($result->execute()){
		 	$row 			= $result->fetchAll( PDO::FETCH_ASSOC ) ;
		 	return 	$row;
	 	}else{
	 		print_r($result->errorInfo());
	 	}
	}
	
	public function getFromHabitationWhere( $newtable, $idhabit ) {
		$query 	= "SELECT * FROM ".$newtable." WHERE idhabit ='".$idhabit."'";
 		$result = $this->_cnx->prepare( $query );
	 	if($result->execute()){
		 	$row 			= $result->fetchAll( PDO::FETCH_ASSOC ) ;
		 	return 	$row;
	 	}
			else
			{
				echo "<h4 style='background-color:blue; color:white'><em> ";
					print_r($result->errorInfo());
				echo "</em></h4>";
	 	}
	}
	
	public function getAllFromAcquereurWhere(  $idpers ) {
		$query 	= "SELECT * FROM acquereur WHERE idpers ='".$idpers."'";
 		$result = $this->_cnx->prepare( $query );
	 	if($result->execute()){
		 	$row 			= $result->fetchAll( PDO::FETCH_ASSOC ) ;
		 	return 	$row;
	 	}else{
	 		print_r($result->errorInfo());
	 	}
	}
	
	public function getAllFromProprietaireWhere(   $idpers ) {
		$query 	= "SELECT * FROM proprietaire WHERE idpers_proprietaire ='".$idpers."'";
 		$result = $this->_cnx->prepare( $query );
	 	if($result->execute()){
		 	$row 			= $result->fetchAll( PDO::FETCH_ASSOC ) ;
		 	return 	$row;
	 	}else{
	 		print_r($result->errorInfo());
	 	}
	}
	

	public function deleteWhere($query){
		$result = $this->_cnx->prepare( $query );
	 	if($result->execute()){
				return true;
	 	}else{
	 		print_r($result->errorInfo());
	 	}
	}
	
	
	public function dropTable($table){
		$query ="DROP TABLE $table";
		$sql=$this->_cnx->prepare($query);
		if($sql->execute()){
			return true;
		}else{
			return false; #$sql->errorInfo(); 
		}
	}

	public function createTable( $table, $nbfields ) {
   //$this->_cnx->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );//Error Handling	
			$sql ="CREATE TABLE $table (
    id INT( 11 ) AUTO_INCREMENT PRIMARY KEY ";
    for($i=0; $i<$nbfields; $i++) {
			$sql .= ", tmp".$i." VARCHAR( 500 )";
		}
		$sql .= ");";

		if($this->_cnx->exec($sql)) {
			return true;
		}
		else{ 
			if($this->_cnx->errorInfo()[2] != ""){
				echo "<h4 style='background-color:red; color:white'><em>";
				print_r($this->_cnx->errorInfo()[2]); //return false;  #$sql->errorInfo(); 
				echo "</h4></em>";
			}
			else echo "<h4 style='background-color:blue; color:white'><em> $table   O K . . .</em></h4>";
			
		}
	}

	public function getRefTable($tablename )
	{
		$query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='".$tablename."'";
		$tmp_result = $this->_cnx->prepare( $query );
		$tmp_result->execute();	
		$row 	= $tmp_result->fetchAll( PDO::FETCH_ASSOC ) ;
		return 	$row;
	} 



	public function getIdhabit( $ref, $telhab )
	{
		$query = "SELECT idhabit FROM habitation WHERE telhab='".$telhab."' AND numero='".$ref."' AND idedit='".$ref."'";
		$tmp_result = $this->_cnx->prepare( $query );
		$tmp_result->execute();	
		$row 	= $tmp_result->fetch( PDO::FETCH_ASSOC ) ;
		print_r($tmp_result->errorInfo()[2]);
		return 	$row;
	} 



	public function insertLoadFileQuery($query) {
			$server = $this->confobj->getDbhost(); 
			$username = $this->confobj->getDbuser(); 
			$password = $this->confobj->getDbpass(); 
			$bdd = $this->confobj->getDbname();
			$sqlcnx = mysqli_connect($server,$username,$password) or die ("No Connection");
			if($sqlcnx) {
			 mysqli_select_db($sqlcnx, $bdd) or die ( "No Database found!" );
				$db = mysqli_query($sqlcnx, $query) or die ("<H4> ERROR ...".mysqli_error($sqlcnx)."</H4>"); 
				if( $db ){ return "registred"; }
			}
			else return "<h3> ERROR ...".mysqli_error($sqlcnx) ;
	}

	public function getLastInsertedHabit($table, $limit, $telhab) {
	 	$query 	= "SELECT idhabit, numero, idedit, telhab FROM ".$table." WHERE telhab ='".$telhab."' ORDER BY idhabit DESC LIMIT ".$limit."";
	 	$result = $this->_cnx->prepare( $query );
	 	$result->execute();	
	 	$row 			= $result->fetchAll( PDO::FETCH_ASSOC ) ;
	 	return 	$row;
	}

	public function getLastInserted( $table, $limit , $idname="id" ) {
	 	$query 	= "SELECT * FROM ".$table." ORDER BY ".$idname." DESC LIMIT ".$limit."";
	 	$result = $this->_cnx->prepare( $query );
	 	$result->execute();	
	 	$row 			= $result->fetchAll( PDO::FETCH_ASSOC ) ;
	 	return 	$row;
	}
	
	
	public function getAcquereur($idpers) {
	 	$query 	= "SELECT * FROM acquereur WHERE idpers = '$idpers'";
	 	$result = $this->_cnx->prepare( $query );
	 	$result->execute();	
	 	$row 			= $result->fetchAll( PDO::FETCH_ASSOC ) ;
	 	return 	$row;
	}
	
	
	
	

	public function insertUrlphoto($idhabit,  $urlphoto ) {
			// TODO INSERT idhabit into csvimagetmp where tmp0 = ref
				$stmt = $this->_cnx->prepare("UPDATE habitation SET urlphoto = :urlphoto WHERE idhabit=:idhabit");
				$stmt->bindParam(":urlphoto", $urlphoto);
				$stmt->bindParam(":idhabit", $idhabit);
				if($stmt->execute()){
					return true;
				}
				else return false;
	}
	
	public function insertDescriptif($idhabit,  $text ) {
			
				$stmt = $this->_cnx->prepare("UPDATE habitation SET descriptif = :texte WHERE idhabit=:idhabit");
				$stmt->bindParam(":texte", $text);
				$stmt->bindParam(":idhabit", $idhabit);
				if($stmt->execute()){
					return true;
				}
				else return false;
	}


	public function insertHabProp($idhabit,  $idproprietaire ) {
			$stmt = $this->_cnx->prepare( "INSERT INTO habitation_proprietaire SET id_habit = :idhabit, id_proprietaire=:idproprietaire" );
			$stmt->bindParam(":idhabit", $idhabit);
			$stmt->bindParam(":idproprietaire", $idproprietaire);
			if($stmt->execute()){
				return true;
			}
			else print_r( "<h3> ERROR ...".$stmt->errorInfo()[2] ." </h3> ");
	}



	public function insertProprietaire( $proprietaires ) {
			
		$query = "INSERT INTO proprietaire SET ";
		$query .= "nom_proprietaire=:nom_proprietaire,";
		$query .= "prenom_proprietaire=:prenom_proprietaire,";
		$query .= "idpers_proprietaire=:idpers_proprietaire,";
		$query .= "adresse_proprietaire=:adresse_proprietaire,";
		$query .= "ville_proprietaire=:ville_proprietaire,";
		$query .= "departement_proprietaire=:departement_proprietaire,";
		$query .= "telephonem_proprietaire=:telephonem_proprietaire,";
		$query .= "telephonef_proprietaire=:telephonef_proprietaire,";
		$query .= "mail_proprietaire=:mail_proprietaire, commentaire_proprietaire=:commentaire_proprietaire ON DUPLICATE KEY UPDATE ";
		$query .= "nom_proprietaire=:nom_proprietaire,";
		$query .= "idpers_proprietaire=:idpers_proprietaire,";
		$query .= "adresse_proprietaire=:adresse_proprietaire,";
		$query .= "ville_proprietaire=:ville_proprietaire,";
		$query .= "departement_proprietaire=:departement_proprietaire,";
		$query .= "telephonem_proprietaire=:telephonem_proprietaire,";
		$query .= "telephonef_proprietaire=:telephonef_proprietaire,";
		$query .= "mail_proprietaire=:mail_proprietaire; ";

		$stmt = $this->_cnx->prepare($query);
		$stmt->bindParam(":nom_proprietaire" ,$proprietaires ["nom_proprietaire"]);
		$stmt->bindParam(":prenom_proprietaire" ,$proprietaires ["prenom_proprietaire"]);
		$stmt->bindParam(":idpers_proprietaire" ,$proprietaires ["idpers_proprietaire"]);
		$stmt->bindParam(":adresse_proprietaire" ,$proprietaires ["adresse_proprietaire"]);
		$stmt->bindParam(":ville_proprietaire" ,$proprietaires ["ville_proprietaire"]);
		$stmt->bindParam(":departement_proprietaire" ,$proprietaires ["departement_proprietaire"]);
		$stmt->bindParam(":telephonem_proprietaire" ,$proprietaires ["telephonem_proprietaire"]);
		$stmt->bindParam(":telephonef_proprietaire" ,$proprietaires ["telephonef_proprietaire"]);
		$stmt->bindParam(":mail_proprietaire" ,$proprietaires ["mail_proprietaire"]);
		$stmt->bindParam(":commentaire_proprietaire" ,$proprietaires ["commentaire_proprietaire"]);
		if($stmt->execute()){
			return true;
		}
		else print_r($stmt->errorInfo()[2]);
	}



	public function insertAcheteur( $acheteur ) 
	{
		$query = "INSERT INTO acquereur SET ";
		$query .= "idpers=:idpers,";
		$query .= "nomacquereur=:nomacquereur,";
		$query .= "adresse=:adresse,";
		$query .= "cp=:cp,";
		$query .= "ville=:ville,";
		$query .= "telacquereur=:telacquereur,";
		$query .= "portacquereur=:portacquereur,";
		$query .= "emailacquereur=:emailacquereur,";
		$query .= "visible=:visible, source=:source ON DUPLICATE KEY UPDATE ";
		$query .= "idpers=:idpers,";
		$query .= "nomacquereur=:nomacquereur,";
		$query .= "adresse=:adresse,";
		$query .= "cp=:cp,";
		$query .= "ville=:ville,";
		$query .= "telacquereur=:telacquereur,";
		$query .= "portacquereur=:portacquereur,";
		$query .= "emailacquereur=:emailacquereur,";
		$query .= "visible=:visible, source=:source;";

		
		$stmt = $this->_cnx->prepare($query);
		$stmt->bindParam(":idpers" ,$acheteur["idpers"]);
		$stmt->bindParam(":nomacquereur" ,$acheteur["nomacquereur"]);
		$stmt->bindParam(":adresse" ,$acheteur["adresse"]);
		$stmt->bindParam(":cp" ,$acheteur["cp"]);
		$stmt->bindParam(":ville" ,$acheteur["ville"]);
		$stmt->bindParam(":telacquereur" ,$acheteur["telacquereur"]);
		$stmt->bindParam(":portacquereur" ,$acheteur["portacquereur"]);
		$stmt->bindParam(":emailacquereur" ,$acheteur["emailacquereur"]);
		$stmt->bindParam(":visible" ,$acheteur["visible"]);
		$stmt->bindParam(":source" ,$acheteur["source"]);
		if($stmt->execute())
		{
		//	echo $query;
			return true;
		}
		else print_r($stmt->errorInfo()[2]);
	}

	
	public function insertAcqu_rech($acquereurRech)
	{
		$idtempacquereur = 0000000;
		$query = "INSERT INTO acquereur_rech SET ";
		$query .= "type=:type,";
		$query .= "type2=:type2,";
		$query .= "loc=:loc,";
		$query .= "prixmax=:prixmax,";
		$query .= "piecesmin=:piecesmin,";
		$query .= "surfacemin=:surfacemin,";
		$query .= "idacquereur=:idacquereur ON DUPLICATE KEY UPDATE ";
		$query .= "type=:type,";
		$query .= "loc=:loc,";
		$query .= "prixmax=:prixmax,";
		$query .= "piecesmin=:piecesmin,";
		$query .= "surfacemin=:surfacemin,";
		$query .= "idacquereur=:idacquereur;";
		 
		$stmt = $this->_cnx->prepare($query);
		$stmt->bindParam(":type" ,$acquereurRech["type"]);
		$stmt->bindParam(":type2" ,$acquereurRech["type2"]);
		$stmt->bindParam(":loc" ,$acquereurRech["loc"]);
		$stmt->bindParam(":prixmax" ,$acquereurRech["prixmax"]);
		$stmt->bindParam(":piecesmin" ,$acquereurRech["piecesmin"]);
		$stmt->bindParam(":surfacemin" ,$acquereurRech["surfacemin"]);
		$stmt->bindParam(":idacquereur" , $idtempacquereur);
		if($stmt->execute())
		{
		//	echo $query;
			return true;
		}
		else print_r($stmt->errorInfo()[2]);
	}

	 
	 
	public function updateVisible($up = true, $idhabit) 
	{
		if($up) 
		{
			$stmt = $this->_cnx->prepare( "UPDATE habitation SET visible = 1, etat = '' WHERE idhabit = '$idhabit'" );
			if($stmt->execute()){
				return true;
			}
			else print_r( "<h3> ERROR ...".$stmt->errorInfo()[2] ." </h3> ");
		}
		else {
			$stmt = $this->_cnx->prepare( "UPDATE habitation SET visible = 3, etat = '', archivage_statut = 3, vendu_loue = 1 WHERE idhabit = '$idhabit'" );
			if($stmt->execute()){
				return true;
			}
			else print_r( "<h3> ERROR ...".$stmt->errorInfo()[2] ." </h3> ");	
		}
	}
	
	public function updateLoc($loc, $idhabit) 
	{
		$stmt = $this->_cnx->prepare( "UPDATE habitation SET loc = '$loc' WHERE idhabit = '$idhabit'" );
		if($stmt->execute()){
			return true;
		}
		else print_r( "<h3> ERROR ...".$stmt->errorInfo()[2] ." </h3> ");
	}

	public function updateType($type, $idhabit) 
	{
		$stmt = $this->_cnx->prepare( "UPDATE habitation SET type = '$type' WHERE idhabit = '$idhabit'" );
		if($stmt->execute()){
			return true;
		}
		else print_r( "<h3> ERROR ...".$stmt->errorInfo()[2] ." </h3> ");
	}

	
	
	public function updateTelAcq($idacqu, $telm="", $telf="") 
	{
		if($telm){
			//echo  "UPDATE acquereur SET portacquereur = '$telm' WHERE idacquereur = '$idacqu'<br>" ;
			$stmt = $this->_cnx->prepare( "UPDATE acquereur SET portacquereur = '$telm' WHERE idacquereur = '$idacqu'" );
			if($stmt->execute()){
				echo '.';
			}
			else print_f($stmt->errorInfo()[2]);
		}
		
		if($telf){
			//echo  "UPDATE acquereur SET portacquereur = '$telf' WHERE idacquereur = '$idacqu'<br>" ;
			$stmt = $this->_cnx->prepare( "UPDATE acquereur SET telacquereur = '$telf' WHERE  idacquereur = '$idacqu'" );
			if($stmt->execute()){
				echo '.';
			}
			else print_f($stmt->errorInfo()[2]);
		}
	}

	
	
	public function updateTelProp($idprop, $telm="", $telf="") 
	{
		if( $telm ){
		//	echo "UPDATE proprietaire SET telephonem_proprietaire = '$telm' WHERE id_proprietaire = '$idprop'<br>";
			$stmt = $this->_cnx->prepare( "UPDATE proprietaire SET telephonem_proprietaire = '$telm' WHERE id_proprietaire = '$idprop'" );
		 if($stmt->execute()){
				echo '.';
			}	else print_f($stmt->errorInfo()[2]);
		}
		if( $telf ){
			//echo "UPDATE proprietaire SET telephonem_proprietaire = '$telf' WHERE id_proprietaire = '$idprop'<br>";
			$stmt = $this->_cnx->prepare( "UPDATE proprietaire SET telephonef_proprietaire = '$telf' WHERE  id_proprietaire = '$idprop'" );
			if($stmt->execute()){
				echo '.';
			}	else print_f($stmt->errorInfo()[2]);
		}
	}
		
		
		
	public function updateDpe($dpes, $idhabit) 
	{
		$stmt = $this->_cnx->prepare( "UPDATE habitation SET ce = '".$dpes['ce']."' , bce = '".$dpes['bce']."', ges = '".$dpes['ges']."', bges = '".$dpes['bges']."'  WHERE idhabit = '$idhabit'" );
		if($stmt->execute()){
			return true;
		}
		else {
				echo "<h4 style='background-color:red; color:white'><em> ";
                print_r( "".$stmt->errorInfo()[2] ."");
            echo "</em></h4>";
         }
		
	}

	
}