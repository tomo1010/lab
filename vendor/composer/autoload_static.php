<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd979d3a7c8f9ee25f2daff23d343da84
{
    public static $prefixesPsr0 = array (
        'R' => 
        array (
            'RakutenRws_' => 
            array (
                0 => __DIR__ . '/..' . '/rakuten-ws/rws-php-sdk/lib',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixesPsr0 = ComposerStaticInitd979d3a7c8f9ee25f2daff23d343da84::$prefixesPsr0;
            $loader->classMap = ComposerStaticInitd979d3a7c8f9ee25f2daff23d343da84::$classMap;

        }, null, ClassLoader::class);
    }
}