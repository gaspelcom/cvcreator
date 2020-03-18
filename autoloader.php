<?php

class Autoloader
{
    public static function register()
    {
        spl_autoload_register(function ($class) {
			$namespaces = explode('\\', $class);
			if (count($namespaces) > 1) {
				$appPrefix = array_shift($namespaces);
				if ($appPrefix === '') {
					$appPrefix = array_shift($namespaces);
				}
				if ($appPrefix != 'cv') {
					$classPath = './external/' . $appPrefix . DIRECTORY_SEPARATOR;
				} else {
					$classPath = './lib/';
				}
				$classPath .= implode('/', $namespaces) . '.php';
				if (file_exists($classPath)) {
					require_once ($classPath);
					return true;
				}
			}
			return false;
        });
    }
}

Autoloader::register();