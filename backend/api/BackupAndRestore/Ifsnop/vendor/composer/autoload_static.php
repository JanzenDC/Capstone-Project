<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita6c6681191fc8057e9eaaa4cc9e6ddc1
{
    public static $prefixLengthsPsr4 = array (
        'I' => 
        array (
            'Ifsnop\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Ifsnop\\' => 
        array (
            0 => __DIR__ . '/..' . '/ifsnop/mysqldump-php/src/Ifsnop',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita6c6681191fc8057e9eaaa4cc9e6ddc1::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita6c6681191fc8057e9eaaa4cc9e6ddc1::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInita6c6681191fc8057e9eaaa4cc9e6ddc1::$classMap;

        }, null, ClassLoader::class);
    }
}
