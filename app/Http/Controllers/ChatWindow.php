<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class ChatWindow extends Controller
{
    public function chat ()
    {
        $view = View()->make( 'chat' );

        return $view;
    }

    public function chat_log ()
    {
        $DaoMessage = new Message();
        $messages = $DaoMessage->getList();
        $data = [];
        foreach ($messages as $message) {
            array_push( $data, collect( $message ) );
        }
        $rtndata['status'] = 1;
        $rtndata['aaData'] = $data;

        return response()->json( $rtndata );
    }

    public function chat_message ( Request $request )
    {
        $DaoMessage = new Message();
        $request->merge( [ 'author' => session()->getId() ] );
        $DaoMessage->fire( $request->all() );

        $rtndata['status'] = 1;
        $rtndata['aaData'] = [];
        $rtndata['id'] = session()->getId();

        return response()->json( $rtndata );
    }
}
