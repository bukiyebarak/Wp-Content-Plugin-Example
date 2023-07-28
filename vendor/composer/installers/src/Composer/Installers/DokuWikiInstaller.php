<?php

namespace Composer\Installers;

class DokuWikiInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = array(
        'plugin' => 'lib/plugins/{$name}/',
        'templates' => 'lib/tpl/{$name}/',
    );

    /**
     * Format package name.
     *
     * For package type dokuwiki-plugin, cut off a trailing '-plugin',
     * or leading dokuwiki_ if present.
     *
     * For package type dokuwiki-templates, cut off a trailing '-templates' if present.
     */
    public function inflectPackageVars(array $vars): array
    {
        if ($vars['type'] === 'dokuwiki-plugin') {
            return $this->inflectPluginVars($vars);
        }

        if ($vars['type'] === 'dokuwiki-templates') {
            return $this->inflectTemplateVars($vars);
        }

        return $vars;
    }

    /**
     * @param array<string, string> $vars
     * @return array<string, string>
     */
    protected function inflectPluginVars(array $vars): array
    {
        $vars['name'] = $this->pregReplace('/-plugin$/', '', $vars['name']);
        $vars['name'] = $this->pregReplace('/^dokuwiki_?-?/', '', $vars['name']);

        return $vars;
    }

    /**
     * @param array<string, string> $vars
     * @return array<string, string>
     */
    protected function inflectTemplateVars(array $vars): array
    {
        $vars['name'] = $this->pregReplace('/-templates$/', '', $vars['name']);
        $vars['name'] = $this->pregReplace('/^dokuwiki_?-?/', '', $vars['name']);

        return $vars;
    }
}
