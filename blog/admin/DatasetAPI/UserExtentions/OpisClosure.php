<?php
//if($handle = opendir(__DIR__ . "/opisclosure/")) {
//	while ($entry = readdir($handle)) {
//		if((substr($entry, -strlen(".php")) === ".php")){
//			require_once(__DIR__ . "/opisclosure/{$entry}");
//		}
//	}
//}

spl_autoload_register(function($class){
   
    $class = ltrim($class, '\\');
    $dir = __DIR__ . '/opisclosure';
    $namespace = 'Opis\Closure';
    
    if(strpos($class, $namespace) === 0)
    {
        $class = substr($class, strlen($namespace));
        $path = '';
        if(($pos = strripos($class, '\\')) !== FALSE)
        {
            $path = str_replace('\\', '/', substr($class, 0, $pos)) . '/';
            $class = substr($class, $pos + 1);
        }
        $path .= str_replace('_', '/', $class) . '.php';
        $dir .= '/' . $path;
        
        if(file_exists($dir))
        {
            include $dir;
            return true;
        }
        
        return false;
    }
    
    return false;
});
?>