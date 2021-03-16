<?php namespace Zen\Gdp;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            'Zen\Gdp\Components\Doc' => 'doc',
        ];
    }

    public function registerSettings()
    {
    }

    public function registerPageSnippets()
    {
        return [
            'Zen\Gdp\Components\Doc' => 'doc',
        ];
    }
}
