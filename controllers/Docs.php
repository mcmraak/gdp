<?php namespace Zen\Gdp\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use View;
use Log;
use Input;
use Zen\Gdp\Models\Doc;
use RainLab\Pages\Classes\Page;
use Exception;

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
        $parse = $this->parse($item);
        echo json_encode([
            'id' => $item->id,
            'steep' => $steep,
            'count' => $count,
            'error' => ($parse)?false:true
        ]);
    }

    public function parse($item)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $item->link);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        $html = curl_exec($curl);
        curl_close($curl);
        if(!$html) return false;
        try {
        $html = $this->htmlCleaner($html);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return false;
        }
        if(!$html) {
            return false;
        }
        $item->html = $html;
        $item->save();
        return true;
    }

    public function htmlCleaner($html)
    {
        try {
            $html = explode('<div id="contents">', $html);
            if (count($html) > 1) {
                $html = $html[1];
            } else return false;

            $html = explode('<div id="footer">', $html);
            if (count($html) > 1) {
                $html = $html[123]; // 0
            } else return false;

            $html = preg_replace('/<style type="text\/css">.*<\/style>/', '', $html);
            $html = str_replace('<img', '_img', $html);
            $html = str_replace('<a', '_a', $html);
            $html = preg_replace('/<([a-z0-9]+) [^>]+>/i', '<$1>', $html);
            $html = str_replace('_img', '<img', $html);
            $html = str_replace('_a', '<a', $html);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return false;
        }
        return $html;
    }

    public function one()
    {
        $doc_id = Input::get('doc_id');
        $item = Doc::find($doc_id);
        $this->parse($item);
    }
}
