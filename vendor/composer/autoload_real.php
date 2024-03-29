<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitc50fb3b7edd8190301e403d8ad6f028c
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

        spl_autoload_register(array('ComposerAutoloaderInitc50fb3b7edd8190301e403d8ad6f028c', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitc50fb3b7edd8190301e403d8ad6f028c', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitc50fb3b7edd8190301e403d8ad6f028c::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
