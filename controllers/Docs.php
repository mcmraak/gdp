<?php namespace Zen\Gdp\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use View;
use Log;
use Input;
use Zen\Gdp\Models\Doc;
use RainLab\Pages\Classes\Page;

class Docs extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'zen.gdp.main' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Zen.Gdp', 'gdp-main');
        $this->addCss('/plugins/zen/gdp/assets/css/zen.gdp.docs.css');
    }

    public function go()
    {
        $steep = intval(Input::get('steep'));
        $items = Doc::get();
        $count = $items->count();
        $item = $items[$steep];
        $this->parse($item);
        echo json_encode([
            'id' => $item->id,
            'steep' => $steep,
            'count' => $count,
        ]);
    }

    public function parse($item)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $item->link);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        $html = curl_exec($curl);
        curl_close($curl);
        $html = $this->htmlCleaner($html);
        $item->html = $html;
        $item->save();
    }

    public function htmlCleaner($html)
    {
        $html = explode('<div id="contents">', $html);
        $html = $html[1];
        $html = explode('<div id="footer">', $html);
        $html = $html[0];
        $html = preg_replace('/<style type="text\/css">.*<\/style>/','', $html);
        $html = str_replace('<img','_img', $html);
        $html = str_replace('<a','_a', $html);
        $html = preg_replace('/<([a-z0-9]+) [^>]+>/i','<$1>', $html);
        $html = str_replace('_img','<img', $html);
        $html = str_replace('_a','<a', $html);
        return $html;
    }

    public function one()
    {
        $doc_id = Input::get('doc_id');
        $item = Doc::find($doc_id);
        $this->parse($item);
    }
}
