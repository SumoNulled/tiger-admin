<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit966ebd8b75c8a535b952bf8db411c680
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInit966ebd8b75c8a535b952bf8db411c680', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit966ebd8b75c8a535b952bf8db411c680', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit966ebd8b75c8a535b952bf8db411c680::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}