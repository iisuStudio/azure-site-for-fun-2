<?php

namespace App\Http\Controllers\Web;

use Alkhachatryan\LaravelWebConsole\LaravelWebConsole;

class IndexController extends _Controller
{
    function index ()
    {
        return View()->make( 'web.index' );
    }

    function datatable ()
    {
        return View()->make( 'web.datatable' );
    }

    function calendar ()
    {
        return View()->make( 'web.calendar' );
    }

    function gallery ()
    {
        return View()->make( 'web.gallery' );
    }

    function gmap_xml ()
    {
        return View()->make( 'web.gmap_xml' );
    }

    function inbox ()
    {
        return View()->make( 'web.inbox' );
    }

    function invoice ()
    {
        return View()->make( 'web.invoice' );
    }

    function profile ()
    {
        return View()->make( 'web.profile' );
    }

    function console() {
        return LaravelWebConsole::show();
    }
}