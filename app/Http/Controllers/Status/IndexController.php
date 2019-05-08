<?php

namespace App\Http\Controllers\Status;

class IndexController extends _Controller
{
    function index ()
    {
        return View()->make( 'status.index' )->with([
            'page_view' => $this->tracker->pageViews( 60 * 24 * 7),
            'page_view_country' => $this->tracker->pageViewsByCountry( 60 * 24 * 30)->each(function($item){
                $item->color = '#' . str_pad(dechex(mt_rand(30, 225)), 2, '0', STR_PAD_LEFT)
                    . str_pad(dechex(mt_rand(30, 225)), 2, '0', STR_PAD_LEFT)
                    . str_pad(dechex(mt_rand(30, 225)), 2, '0', STR_PAD_LEFT);
            })
        ]);
    }

    function visits ()
    {

        return View()->make( 'status.visits' )->with(['field'=>$this->tracker->sessions(60 * 24)]);
    }
}