<?php
require_once(__DIR__ . "/DataField_Base.php");

class DataField_TagInput extends DataField_Base{
	
	public static $properties = [
		"id", "label", "optionsList", "freeInput", "validation"
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
			<input class="form-control" id="<?php echo($this->id); ?>" name="<?php echo($this->id); ?>" <?php if ($currentValue != ""){ echo("value=\"{$currentValue}\""); } ?> <?php if(isset($this->tabIndex)){echo("tabindex=$this->tabIndex");} ?> />
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