<?php

namespace Composer\Installers;

class ImageCMSInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = array(
        'templates'    => 'templates/{$name}/',
        'module'      => 'application/modules/{$name}/',
        'library'     => 'application/libraries/{$name}/',
    );
}
