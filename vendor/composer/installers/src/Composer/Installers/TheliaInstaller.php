<?php

namespace Composer\Installers;

class TheliaInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = array(
        'module'                => 'local/modules/{$name}/',
        'frontoffice-templates'  => 'templates/frontOffice/{$name}/',
        'backoffice-templates'   => 'templates/backOffice/{$name}/',
        'email-templates'        => 'templates/email/{$name}/',
    );
}
