<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitbc672af98af917956aec8afdeea68b9c
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitbc672af98af917956aec8afdeea68b9c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitbc672af98af917956aec8afdeea68b9c::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitbc672af98af917956aec8afdeea68b9c::$classMap;

        }, null, ClassLoader::class);
    }
}
