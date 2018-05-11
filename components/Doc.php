<?php namespace Zen\Gdp\Components;

use Cms\Classes\ComponentBase;
use Zen\Gdp\Models\Doc as Document;

class Doc extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Google document',
            'description' => ''
        ];
    }

    public function defineProperties()
    {
        return [
            'idDoc'    => [
                'title'       => 'Document',
                'description' => '',
                'type'        => 'dropdown',
            ],
        ];
    }

    public function getidDocOptions()
    {
        return Document::orderBy('name')->lists('name', 'id');
    }

    public function onRender()
    {
        $document = Document::find($this->property('idDoc'));
        $this->page['document'] = $document->html;
    }

}
