<?php

if($handle = opendir(__DIR__ . "/UserExtentions/")) {
	while ($entry = readdir($handle)) {
		if((substr($entry, -strlen(".php")) === ".php")){
			require_once(__DIR__ . "/UserExtentions/{$entry}");
		}
	}
}

if($handle = opendir(__DIR__ . "/DataSets/")) {
	while ($entry = readdir($handle)) {
		if((substr($entry, -strlen(".php")) === ".php")){
			require_once(__DIR__ . "/DataSets/{$entry}");
		}
	}
}

if($handle = opendir(__DIR__ . "/DataFields/")) {
	while ($entry = readdir($handle)) {
		if((substr($entry, -strlen(".php")) === ".php")){
			require_once(__DIR__ . "/DataFields/{$entry}");
		}
	}
}

?>