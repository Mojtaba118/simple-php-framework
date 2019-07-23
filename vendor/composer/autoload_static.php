<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf479974699ab860a7fef6aaf78102daf
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'Core\\' => 5,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Core\\' => 
        array (
            0 => __DIR__ . '/../..' . '/core',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf479974699ab860a7fef6aaf78102daf::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf479974699ab860a7fef6aaf78102daf::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
