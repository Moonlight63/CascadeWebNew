<?php

require_once("DatasetAPI/datasets.php");

if(!isset($DataSet)){
	$DataSet = $_SESSION["DatasetInfo"]["DataSet"];
}

if( !isset($externalLoad) ){
	echo("This file was improperly loaded. Please try again."); return;
}elseif( !isset($_GET["entryID"]) || $_GET["entryID"] == "" ){
	$dataset = new $DataSet("NEW_SET");	
}else{
	$entryID = $_GET["entryID"];
	$dataset = new $DataSet($entryID);
}

$entryData = $dataset->getCurrentData();
if(!$entryData){
	echo("This file was improperly loaded. Please try again."); return;
}

$htmlData = $dataset->getHTML();
$jsData = $dataset->getJS();
$includes = $dataset->getIncludes();

$ableToDelete = ($dataset->getSetting("canDelete") && !$entryData["firstCreate"]);

//echo(json_encode($entryData = $dataset->getCurrentData()));

?>

<?php echo($includes); ?>

<div class="container">

	<div class="row">
		<div class="col-sm-offset-0 col-sm-12 col-md-10 col-md-offset-1">

			<h1 class="modal-header modal-title">Edit Entry</h1>

			<form action="submit.php" method="post" name="edit_entry" id="edit_entry" class="edit_entry" data-successaction="location.reload()" data-entrytype="<?php echo($DataSet); ?>" data-entryid="<?php echo($entryData["UID"]); ?>" autocomplete="off" novalidate>
				<div class="modal-body">
				
					<?php echo($htmlData); ?>
					
					<div id="display_error" class="alert alert-danger fade in"></div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-lg btn-default btn_cancel">Cancel</button>
					<?php if($ableToDelete): ?>
					<button type="button" class="btn btn-lg btn-danger btn_delete">Delete</button>
					<?php endif; ?>
					<input type="submit" class="btn btn-lg btn-success" value="Save" id="submit">
				</div>
			</form>

		</div>
	</div>

</div>

<?php echo($jsData); ?>

<script type="application/javascript">
	
	//Cancel-------------------------------------------------------------------------
	
	$(".btn_cancel").on("click", function(){
		<?php if($entryData['firstCreate']){
		?>
		$.ajax({
			type: "POST",
			url: "submit.php",
			data: "Action=delete_entry<?php echo("&entryID={$entryData["UID"]}&entryType={$DataSet}");?>",
			cache: false,
			success: function (JSON) {
				console.log(JSON);
				if (JSON.error != '') {
					$("#edit_user #display_error").show().html(JSON.error);
				} else {
					window.location.href = "<?php echo($_SESSION['DatasetInfo']['CloseLink']); ?>";
				}
			},
			error: function ( jqXHR, textStatus, errorThrown){
				console.log(errorThrown);
				console.log(textStatus);
				console.log(jqXHR);
			}
		});
		<?php
		} else {
		?>
		window.location.href = "<?php echo($_SESSION['DatasetInfo']['CloseLink']); ?>";
		<?php
		}
		?>
	});
	
	<?php if($ableToDelete): ?>
	$(".btn_delete").on("click", function(){
		if(confirm("Are you sure? This will Permenatly delete this item and all of it's assets. Items cannot be recovered!")){
			$.ajax({
				type: "POST",
				url: "submit.php",
				data: "Action=delete_entry<?php echo("&entryID={$entryData["UID"]}&entryType={$DataSet}");?>",
				cache: false,
				success: function (JSON) {
					console.log(JSON);
					if (JSON.error != '') {
						$("#edit_user #display_error").show().html(JSON.error);
					} else {
						window.location.href = "<?php echo($_SESSION['DatasetInfo']['CloseLink']); ?>";
					}
				},
				error: function ( jqXHR, textStatus, errorThrown){
					console.log(errorThrown);
					console.log(textStatus);
					console.log(jqXHR);
				}
			});
		}
	});
	<?php endif; ?>
	
	$(".edit_entry").submit(function (e) {
		e.preventDefault();
		var obj = $(this);
		$(".edit_entry #display_error").hide().html("");
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&Action=editEntry&entryID=" + obj.data("entryid") + "&entryType=" + obj.data("entrytype"),
			//data: obj.serialize()+"&Action=editEntry<?php echo("&entryID={$entryData["UID"]}&entryType={$DataSet}");?>",
			cache: false,
			success: function (JSONdata) {
				console.log(JSONdata);
				if (JSONdata.error != '') {
					var errors = "<ul>";
					JSONdata.error.forEach(function(elem){
						errors += "<li>";
						errors += elem;
						errors += "</li>";
					});
					errors += "</ul>";
					$(".edit_entry #display_error").show().html(errors);
					//$("#edit_entry #display_error").show().html(JSON.stringify(JSONdata.error));
				} else {
					/*var action = eval(obj.data("successaction"));
					action();*/
					window.location.href = "<?php echo($_SESSION['DatasetInfo']['CloseLink']); ?>";
					//window.location.href = "./dashboard.php";
				}

			}
		});
	});
	
</script>

