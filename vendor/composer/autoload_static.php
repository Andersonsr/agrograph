<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1d85b70e528c3431ce4b6d1f89ebdc57
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit1d85b70e528c3431ce4b6d1f89ebdc57::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit1d85b70e528c3431ce4b6d1f89ebdc57::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
