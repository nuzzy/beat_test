<?php

/**
 * Simple autoloader, so we don't need Composer just for this.
 */
class Autoloader
{
    public static function register()
    {
        spl_autoload_register(function ($class) {
            $file = str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php';
            if (strpos($file, 'App' . DIRECTORY_SEPARATOR, 0) === 0) {
                $file = 'libs' . substr($file, 3);
            }

            if (file_exists($file)) {
                require $file;
                return true;
            }
            return false;
        });
    }
}

Autoloader::register();
