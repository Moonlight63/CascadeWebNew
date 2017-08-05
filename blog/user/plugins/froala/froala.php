<?php
namespace Grav\Plugin;

use Grav\Common\Filesystem\Folder;
use Grav\Common\GPM\GPM;
use Grav\Common\Grav;
use Grav\Common\Page\Page;
use Grav\Common\Page\Pages;
use Grav\Common\Data\Blueprints;
use Grav\Common\Data\Data;
use Grav\Common\File\CompiledYamlFile;
use Grav\Common\Plugin;
use Grav\Common\Filesystem\RecursiveFolderFilterIterator;
use Grav\Common\User\User;
use Grav\Common\Utils;
use RocketTheme\Toolbox\File\File;
use RocketTheme\Toolbox\Event\Event;
use Symfony\Component\Yaml\Yaml;

class FroalaPlugin extends Plugin
{
    protected $enable = false;

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'onPluginsInitialized' => ['onPluginsInitialized', 0]
        ];
    }
	
	public function onPluginsInitialized(){
        if ($this->isAdmin()) {
            $this->initializeAdmin();
        } else {
			$this->initializeClient();
		}
		$this->initializeGlobal();
    }
	
	/**
     * Admin side initialization ---------------------------------------------------------
     */
    public function initializeAdmin()
    {
		
		$this->enable([
            'onAdminSave' => ['onAdminSave', 0]
		]);
		
    }
    
    public function onAdminSave($event)
    {
        
        $obj = $event['object'];
        
        if ($obj instanceof Page) {
            $obj->header()->markdown['escape_markup'] = false;
        }
        
        $event['object'] = $obj;
		
    }
	
	/**
     * Client side initialization -----------------------------------------------------
     */
	public function initializeClient()
    {
		$this->enable([
            
		]);
	}
	
	
	/**
     * Global initialization ---------------------------------------------------------
     */
	public function initializeGlobal()
    {
		$this->enable([
			'onTwigExtensions' => ['onTwigExtensions', 0],
			'onTwigTemplatePaths' => ['onTwigTemplatePaths', 0],
			'onTwigSiteVariables'   => ['onTwigSiteVariables', 0],
			'onGetPageTemplates' => ['onGetPageTemplates', 0]
		]);
		
	}
	
	/**
     * Add Twig Functions
     */	
	public function onTwigExtensions(){
        
	}
	
	/**
     * Add plugin templates path and css
     */	
	public function onTwigTemplatePaths()
    {
		if ($this->isAdmin()) {
            array_unshift($this->grav['twig']->twig_paths, __DIR__ . '/templates');
        } else {
			$this->grav['twig']->twig_paths[] = __DIR__ . '/templates';
		}
    }
	public function onTwigSiteVariables(){
        if($this->isAdmin()){
            $this->grav['assets']->addCss('plugin://froala/css/froala.css');
            $this->grav['assets']->addJs('plugin://froala/js/customdropzone.js', -2);
            $this->grav['assets']->addJs('plugin://froala/js/froalainit.js', -3);

            $includesForRTE = [
                "https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/css/froala_editor.css",
                "https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/css/froala_style.css",
                "https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/js/froala_editor.min.js",

                "https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css",
                "https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js",
                "https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js",

                "https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/js/plugins/align.min.js",

                "https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/css/plugins/char_counter.min.css",
                "https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/js/plugins/char_counter.min.js",

                "https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/css/plugins/code_view.min.css",
                "https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/js/plugins/code_view.min.js",

                "https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/js/plugins/code_beautifier.min.js",

                "https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/css/plugins/colors.min.css",
                "https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/js/plugins/colors.min.js",

                "https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/css/plugins/draggable.min.css",
                "https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/js/plugins/draggable.min.js",

                //"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/js/plugins/entities.min.js",

                /*"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/css/plugins/file.min.css",
                "https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/js/plugins/file.min.js",*/

                /*"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/js/plugins/font_family.min.js",*/
                /*"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/js/plugins/font_size.min.js",*/

                "https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/css/plugins/fullscreen.min.css",
                "https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/js/plugins/fullscreen.min.js",

                "https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/css/plugins/help.min.css",
                "https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/js/plugins/help.min.js",

                "https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/css/plugins/image.min.css",
                "https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/js/plugins/image.min.js",

                /*"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/css/plugins/image_manager.min.css",*/
                /*"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/js/plugins/image_manager.min.js",*/

                "https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/css/plugins/line_breaker.min.css",
                "https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/js/plugins/line_breaker.min.js",

                "https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/js/plugins/link.min.js",

                "https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/js/plugins/lists.min.js",

                "https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/js/plugins/paragraph_format.min.js",
                /*"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/js/plugins/paragraph_style.min.js",*/

                "https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/js/plugins/print.min.js",

                "https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/css/plugins/quick_insert.min.css",
                "https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/js/plugins/quick_insert.min.js",

                "https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/js/plugins/quote.min.js",

                "https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/js/plugins/save.min.js",

                "https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/css/plugins/special_characters.min.css",
                "https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/js/plugins/special_characters.min.js",

                "https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/css/plugins/table.min.css",
                "https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/js/plugins/table.min.js",

                "https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/js/plugins/url.min.js",

                "https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/css/plugins/video.min.css",
                "https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/js/plugins/video.min.js",

                "https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/js/plugins/word_paste.min.js"
            ];


            foreach($includesForRTE as $include){
                if( (substr($include, -strlen(".css")) === ".css") ){
                    $this->grav['assets']->addCss($include);
                }elseif( (substr($include, -strlen(".js")) === ".js") ){
                    $this->grav['assets']->addJs($include, -1);
                }
            }
        }
    }

    /**
	 * Get Blueprints and templates for rendering pages
     */
	public function onGetPageTemplates($event)
	{
	  	$types = $event->types;
	  	$locator = Grav::instance()['locator'];
	  	$types->scanBlueprints($locator->findResource('plugin://' . $this->name . '/blueprints/pages'));
	}
    
}