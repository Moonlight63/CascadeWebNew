<?php

require_once("./inc/settings.php");
require_once("./inc/functions.php");
require_once("DatasetAPI/datasets.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function retriveElements($DataSet){
	
	function getEntry($elem, $DataSet){
		ob_start();
		$additionalInfo = "";
		if(isset($_SESSION["DatasetInfo"]["Feedback"])){
			foreach($_SESSION["DatasetInfo"]["Feedback"] as $key => $value){
				if(isset($elem[$key]) && is_callable($value)){
					$additionalInfo .= $value($elem[$key]);
				}
			}
		}
		?>
		<tr class="pageItem<?php echo($additionalInfo); ?>">
			<td>
				<h4 class="itemTitle"><?php echo($elem['name']); ?></h4>
			</td>
			<td>
				<div class="pull-right">
					<button type="button" class="btn btn-default entryEdit" data-link="<?php echo($elem["UID"]); ?>" >
						Edit
					</button>
				</div>
			</td>
		</tr>
		<?php 
		$content = ob_get_contents();
		ob_end_clean();
		
		return($content);
	}
	
	$DataSet = new $DataSet();
	$allElements = $DataSet->getAll();
	$releventElements = array();

	if($allElements != false){
		foreach($allElements as $elem){
			if (isset($_GET['search']) && !empty($_GET['search'])) {
				if( strpos(strtolower($elem["name"]), $_GET['search']) === false ) {
					continue;
				}
			}
			if(isset($_SESSION["DatasetInfo"]["SearchQueries"])){
				foreach($_SESSION["DatasetInfo"]["SearchQueries"] as $key => $value){
					if(isset($elem[$key]) && strpos(strtolower($elem[$key]), $value) === false ){
						continue 2;
					}
				}
			}
			if(isset($_SESSION["DatasetInfo"]["MatchQueries"])){
				foreach($_SESSION["DatasetInfo"]["MatchQueries"] as $key => $value){
					if( isset($elem[$key]) && $elem[$key] != $value ){
						continue 2;
					}
				}
			}
			
			$releventElements[] = $elem;
		}
	}
	
	$elems_per_page = 10;
	$page = (isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 1) ? $_GET['page'] : 1;
	$offset = ($page - 1) * $elems_per_page;
	
	ob_start();
	foreach(array_slice($releventElements,$offset,$elems_per_page) as $elem){
		echo(getEntry($elem, $DataSet));
	}
	$markup = ob_get_contents();
	ob_end_clean();
	return($markup);
}

if(!isset($DataSet)){
	$DataSet = $_SESSION["DatasetInfo"]["DataSet"];
}

//echo(json_encode( Datasets::get($entryType)->get("2017-03-22_test1") ));
echo(retriveElements($DataSet));

?>