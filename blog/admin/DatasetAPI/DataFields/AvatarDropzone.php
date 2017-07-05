<?php
require_once(__DIR__ . "/DataField_Base.php");

class DataField_AvatarDropzone extends DataField_Base{
	
	public static $properties = [
		"id", "label", "directory", "filename", "validation"
	];
	
	public function getIncludes(){
		ob_start();
		?>

		<link href="<?php echo(self::getPathToIncludes())?>/dropzone/dropzoneFroala.css" rel="stylesheet" />
		<link href="<?php echo(self::getPathToIncludes())?>/dropzone/dropzone.css" rel="stylesheet" />
		<script src="<?php echo(self::getPathToIncludes())?>/dropzone/dropzone.js" type='text/javascript'></script>
		
		<?php 
		$content = ob_get_contents();
		ob_end_clean();

		return($content);
	}
	
	public function getHTML($currentValue = ""){
		ob_start();
		?>
		
		<div class="form-group">
			<label><?php echo($this->label); ?></label>
			<div id="<?php echo($this->id); ?>" class="dropzone" style="overflow: auto; /*max-width: 200px;*/" draggable="false">
				<!--Created with JS-->
			</div>
		</div>

		<?php 
		$content = ob_get_contents();
		ob_end_clean();

		return($content);
	}
	
	function getJS($currentValue = ""){
		ob_start();
		?>
		
		<div id="dz_template">
			<div class="dz_preview" draggable="true">
				<div class="thumbnail">
					<img data-dz-thumbnail />
				</div>
				<div class="dz_hover_details">
					<i class="fa fa-trash" style="left: 50%;" aria-hidden="true" title="Delete" data-dz-remove></i>
				</div>
				<div class="dz-progress">
					<span class="dz-upload" data-dz-uploadprogress></span>
				</div>
				<div class="dz-error-message">
					<span data-dz-errormessage></span>
				</div>
				<div class="dz-success-mark">
					<svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
						<title>Check</title>
						<defs></defs>
						<g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
							<path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF" sketch:type="MSShapeGroup"></path>
						</g>
					</svg>
				</div>
				<div class="dz-error-mark">
					<svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
						<title>Error</title>
						<defs></defs>
						<g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
							<g id="Check-+-Oval-2" sketch:type="MSLayerGroup" stroke="#747474" stroke-opacity="0.198794158" fill="#FFFFFF" fill-opacity="0.816519475">
								<path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" sketch:type="MSShapeGroup"></path>
							</g>
						</g>
					</svg>
				</div>
			</div>
		</div>

		<script>
			Dropzone.autoDiscover = false;
			var previewNode = document.querySelector("#dz_template");
			var previewTemplate = previewNode.innerHTML;
			previewNode.parentNode.removeChild(previewNode);

			$("div#<?php echo($this->id); ?>").dropzone({
				url: "<?php echo(self::getPathToIncludes())?>/dropzone/file_ops.php",
				params: {reqType: 'imgUploadWithName', folder: "<?php echo($this->directory);?>", name: "<?php echo($this->filename);?>"},
				previewTemplate: previewTemplate,
				thumbnailWidth: null,
				thumbnailHeight: null,
				maxFiles: 1,
				dictDefaultMessage: "Drop file here or click to upload.",
				dictCancelUploadConfirmation: "Are you sure? File will be deleted.",
				dictRemoveFileConfirmation: "Are you sure? File will be deleted.",
				init: function() {
					var that = this;
					$.get( "<?php echo(self::getPathToIncludes())?>/dropzone/file_ops.php", {reqType: 'imgList', folder: "<?php echo($this->directory);?>"}, function(data){
						var response = JSON.parse(data);
						response.forEach(function(item, index){
							if(item.name.startsWith("<?php echo($this->filename);?>")){
								var mockFile = { name: item.name, size: item.fileSize, type: item.mime, url: item.url, accepted: true };

								that.emit("addedfile", mockFile);
								that.emit("thumbnail", mockFile, item.thumb);
								that.emit("complete", mockFile);
								that.files.push(mockFile);
							}
						});					
					} );
					this.on("success", function(file, response) {
						file.url = JSON.parse(response).link;
					}).on("removedfile", function(file) {
						$.post("<?php echo(self::getPathToIncludes())?>/dropzone/file_ops.php", {reqType: 'imgDelete', src: file.url}); 
					}).on("addedfile", function(file){
						$(file.previewTemplate).on("dragstart", function(e){
							e.originalEvent.dataTransfer.setData("Text", JSON.stringify({"imageURL" : file.url}));
						});
					}).on("maxfilesexceeded", function(file){
						this.removeAllFiles(true);
						this.addFile(file);
					});
					this.hiddenFileInput.removeAttribute('multiple');
				}
			});
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