<?php
require_once(__DIR__ . "/DataField_Base.php");

class DataField_TagAddInput extends DataField_Base{
	
	public static $properties = [
		"id", "label", "optionsList", "freeInput", "addBtnLabel", "modalHeader", "modalSubmitFormAction", "modalSubmitJSAction", "validation"
	];
	
	public function getIncludes(){
		ob_start();
		?>

		<link href="<?php echo(self::getPathToIncludes())?>/tagsinput/bootstrap-tagsinput.css" rel="stylesheet">
		<link href="<?php echo(self::getPathToIncludes())?>/typeahead/typehead.css" rel="stylesheet">
		<script src="<?php echo(self::getPathToIncludes())?>/tagsinput/bootstrap-tagsinput.js"></script>
		<script src="<?php echo(self::getPathToIncludes())?>/typeahead/typeahead.jquery.js"></script>
		<script src="<?php echo(self::getPathToIncludes())?>/typeahead/bloodhound.js"></script>
		
		<style>
		.tt-menu {
			max-height: 50vh;
			overflow-y: auto;
		}
		</style>

		<?php 
		$content = ob_get_contents();
		ob_end_clean();

		return($content);
	}
	
	public function getHTML($currentValue = ""){
		ob_start();
		?>
		
		<div class="form-group">
			<label for="<?php echo($this->id); ?>"><?php echo($this->label); ?></label>

			<div class="input-group" style="z-index: 500">
				<input id="<?php echo($this->id); ?>" name="<?php echo($this->id); ?>" class="form-control" <?php if ($currentValue != ""){ echo("value=\"{$currentValue}\""); } ?> <?php if(isset($this->tabIndex)){echo("tabindex=$this->tabIndex");} ?> />
				<span class="input-group-btn">
					<button type="button" class="btn btn-info" id="<?php echo($this->id); ?>Btn" data-toggle="modal" data-target="#<?php echo($this->id); ?>Modal"><?php echo($this->addBtnLabel); ?></button>
				</span>
			</div>
		</div>

		<?php 
		$content = ob_get_contents();
		ob_end_clean();

		return($content);
	}
	
	function getJS($currentValue = ""){
		ob_start();
		
		$list = "var {$this->id}Options = [];";
		if(isset($this->optionsList)){
			if(isset($this->optionsList["file"])){
				if(file_exists($this->optionsList["file"])){
					$tmpvalue = file_get_contents($this->optionsList["file"]);
				}else{
					$tmpvalue = "[]";
				}
				$list = "var {$this->id}Options = {$tmpvalue}; \n";
			}
			if(isset($this->optionsList["array"])){
				$tmpvalue = json_encode($this->optionsList["array"]);
				$list = "var {$this->id}Options = {$tmpvalue}; \n";
			}
			if(isset($this->optionsList["phpCall"])){
				$tmpvalue = json_encode($this->optionsList["phpCall"]());
				$list = "var {$this->id}Options = {$tmpvalue}; \n";
			}
		}


		?>
		
		<div class="modal fade" role="dialog" id="<?php echo($this->id); ?>Modal">
			<div class="modal-dialog">
				<div class="modal-content">
					<!-- HTML Form -->
					<form action="<?php echo($this->modalSubmitFormAction); ?>" method="post" name="<?php echo($this->id); ?>ModalForm" id="<?php echo($this->id); ?>ModalForm" autocomplete="off" novalidate>
						<!-- Modal Header -->
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title"><?php echo($this->modalHeader); ?></h4>
						</div>
						<!-- Modal Body -->
						<div class="modal-body">
							<div class="form-group">
								<!--<label for="Name"></label>-->
								<input type="text" name="value" class="form-control" required autofocus>
							</div>
							<div id="display_error" class="alert alert-danger fade in"></div>
						</div>
						<!-- Modal Footer -->
						<div class="modal-footer">
							<input type="submit" class="btn btn-lg btn-success" value="Submit" id="submit">
							<button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Cancel</button>
						</div>
					</form>

				</div>
			</div>
		</div>

		<script>
			<?php echo($list); ?>
			
			var <?php echo($this->id); ?>BH = new Bloodhound({
				queryTokenizer: Bloodhound.tokenizers.whitespace,
				datumTokenizer: Bloodhound.tokenizers.whitespace,
				
				local: <?php echo($this->id); ?>Options
			});
			
			function create<?php echo($this->id); ?>(){
				$('#<?php echo($this->id); ?>').tagsinput({
					typeaheadjs: [{
						minLength: 0,
						highlight: true,
						zindex: 9999
					},{
						name: '<?php echo($this->id); ?>List',
						source: <?php echo($this->id); ?>BH,
						limit: 9999
					}],
					freeInput: <?php echo($this->freeInput); ?>
				});
			};
			<?php echo("create{$this->id}();"); ?>
			console.log(<?php echo($this->id); ?>Options);
			
		</script>
		
		<?php echo($this->modalSubmitJSAction); ?>

		<?php 
		$content = ob_get_contents();
		ob_end_clean();

		return($content);
	}
	
	
	
	public function validate($passedValue){
		$result = [];
		
		$valid = function($type, $value, $that){
			if($type == "required"){
				if(!isset($value) || $value == ""){
					return "{$that->label} is Required!";
				}
			}
		};
		
		if(!(!$this->validation)){
			if(is_array($this->validation)){
				foreach($this->validation as $type){
					$result[] = $valid($type, $passedValue, $this);
				}
			}else{
				$result[] = $valid($this->validation, $passedValue, $this);
			}
		}
		return($result);
	}
	
}

?>