<?php 


namespace Api;

class Apidoc {
	
	public static function setPage() {}

	public static function readLigne(&$path) {
		$tabline=[];
		if(is_string($path)){
			if(($handle = fopen ( $path, "r" )) !== FALSE ) {
				while (($line = fgetcsv( $handle, 0, "\n" )) !== FALSE ) {
					$tabline []= $line;
				}
			}
			return $tabline;

		} else {

			if(is_array($path)) {
				foreach ($path as $key => $realpath) {
					if(($handle = fopen ( $realpath, "r" )) !== FALSE ) {
						while (($line = fgetcsv( $handle, 0, "\n" )) !== FALSE ) {
							$tabline []= $line;
						}
					}
				}
			}
		}
	}

    
	public static function readAnnotation($path) {
       //echo $path;

		$lignes = SELF::readLigne($path);
		$doclignes = [];
		if(is_string($path)){
			foreach ($lignes as $key => $value) {
				if(preg_match('#\# @#', $value[0])){
					$doclignes[] = $value[0];
					if(preg_match('#\# @End#', $value[0])) {
						$doclignes[] = "";
					}
				}
			}
			return SELF::constructDocumentation($doclignes);
		}
		elseif(is_array($path)) {
			foreach($path as $realpath) {
				$lignes = SELF::readLigne($realpath);
				foreach ($lignes as $key => $value) {
					if(preg_match('#\# @#', $value[0])){
						$doclignes[] = $value[0];
						if(preg_match('#\# @End#', $value[0])) {
							$doclignes[] = "";
						}
					}
				}
			}
			echo  SELF::constructDocumentationWbrm($doclignes);
			
		}
	}
	
    /*
	public static function constructDocumentation($doclignes) {
		$doc = "";
		foreach ($doclignes as $key => $value) {

			if(preg_match('#\# @POST#', $value) 
			|| preg_match('#\# @GET#', $value)
			|| preg_match('#\# @PUT#', $value)
			|| preg_match('#\# @DELETE#', $value)) {
				$xpld1 = explode('@', $value);
				$doc .= "<h2><em>". $xpld1[1] ."</em></h2>";
			}
			else{
				if(preg_match('#\# @End#', $value)){
					$doc .= "<hr>";	
				} 	
				else {
					if(preg_match('#@Description#', $value)) {
						$txt = explode('Description', $value);
						$txt1 = trim($txt[1]);
						$doc .= "<h4>Desciption</h4><p>".$txt1."</p>";
					}
					elseif(preg_match('#@Param#', $value)) {
						$txt = explode('Param', $value);
						$txt1 = trim($txt[1]);
						$doc .= "<code>@Params: ".$txt[1]."</code>";
					}
				}
			}
		}
		return SELF::writeDocumentation($doc);
	}
    */
    
	public static function constructDocumentationWbrm($doclignes) {
		$doc = "";
		$i=0;
		foreach ($doclignes as $key => $value) {
		
			if(preg_match('#\# @POST#', $value) 
			|| preg_match('#\# @GET#', $value)
			|| preg_match('#\# @PUT#', $value)
			|| preg_match('#\# @DELETE#', $value)) {

			$doc .= '<table class="container">
			<tr><td>
			<br/><br/>
			<div class="row">
			<div class="col-lg-12">	';
				$xpld1 = explode('@', $value);
				$xpl = explode('"/', $xpld1[1]);
				$accordion_id = str_replace('/', '', $xpld1[1]);
				$accordion_id = str_replace('"', '', $accordion_id);
				$accordion_id = trim(str_replace($xpl[0], '', $accordion_id));

				$doc .= '<p class="subtitle">'.$xpl[0].'</p>';

				$doc .= '  <button data-target="#'.$accordion_id.'" 
								class="target_accordion btn btn-default form-control" data-toggle="collapse" style="height:50px"><h2 style="margin-top:-2px; text-align:left"> /'.str_replace('"','', $xpl[1] ).'</h2>';
					
				$doc .= '
				<div class="col-lg-12 text-center">
					<div class="visible-md visible-lg">
				    	<?php include("wbrm-assets/include/_linesvg.php"); ?>
				    </div>
					<div class="visible-sm visible-xs">
				    	<?php include("wbrm-assets/include/_linesvg-small.php"); ?>
				    </div>
				</div></button>
				</div> 
				<div id="'.$accordion_id.'" class="collapse col-lg-12 padding30 text-justify">  <div class="">
				   <br><br><blockquote>';

			} else {
				if(preg_match('#@Description#', $value)) {
					$txt = explode('Description', $value);
					$txt1 = trim($txt[1]);
					$doc .='<h3>Description :</h3>';
					$doc .= '<p>'.$txt1.'</p>';
				}
				elseif(preg_match('#@Param#', $value)) {
					$txt = explode('Param', $value);
					$txt1 = trim($txt[1]);
					$urlroute ='/'. str_replace('"','',$xpl[1]);
					$doc .= '<hr><br>
					       <div class="shell-wrap">
  							<p class="shell-top-bar">'. $urlroute .'</p>
    						<form class="form">';
                            if($urlroute == '/apici/gettoken') { $doc .= '<input type="hidden" name="url_for_token" value="url_for_token" class="url_for_token">'; }
    				$doc .= '<input type="hidden" class="route" value="'.$urlroute.'">
    						
    				
    						<textarea class="shell-body">';
    				$doc .= trim(str_replace('{','{'.chr(13).'  ',
								str_replace(',',','.chr(13).'  ', 
									str_replace('}',chr(13).'}', trim($txt[1]))))); 
    				$doc .= '</textarea>
    							<br>';
                                
                    if($urlroute != '/apici/gettoken') {
                        
         				$doc .= '<hr><input type="text" name="token" class="token form-control" placeholder=" ... TOKEN" value="" style="height:60px">';
                    }
                    
  					$doc .='	<br>
    							<div class="text-right">
									<kbd class="sendquery2">Envoyer</kbd>
    							</div><br>
								<div class="windowreturn"><p class="shell-top-bar">Http-Response</p><textarea class="bodyreturn shell-body" style="display:none"></textarea></div>
    							</form>
							<br>
							</div>';			
						
				}
				if(preg_match('#\# @End#', $value)){
					$i++;
					$doc .= '	</blockquote>	</div>
						
					</td>
					</tr>';
					/*if($i%2==0){
						$doc .= '<br><br><br><div class="row bandeau from-left-anim-slow"></div>';	
					}*/
				} 
			}

		}
		return SELF::writeDocumentation($doc);
	}
    

	public static function setHeaderDiv() {
		$headerhtml = file_get_contents('../apici/wbrm_template/wbrm-assets/include/header.php');
		$headerhtml .= file_get_contents('../apici/wbrm_template/wbrm-assets/include/menu.php');
		return $headerhtml;	
	}


	public static function setFooterDiv() {
		$footer="";
		$footer = file_get_contents('../apici/wbrm_template/wbrm-assets/include/footer.php');
		return $footer;
	}


	public static function writeDocumentation($doc) {
		return SELF::setHeaderDiv().$doc."<br><br><br><br>".SELF::setFooterDiv();	 
	}


}