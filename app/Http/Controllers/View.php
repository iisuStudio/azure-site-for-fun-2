<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class View extends Controller
{
    public function chat(){
        $view = View()->make('chat');

        return $view;
    }

    public function chat_log(){
        $modal = new MessageModal();
        $messages = $modal->get_message();
        $data = [];
        foreach($messages as $message) {
            array_push($data, collect($message));
        }
        $rtndata['status'] = 1;
        $rtndata['aaData'] = $data;

        return $data;
    }

    public function chat_message(Request $request){
        $name = $request->exists('user') ? $request->input('user') : null;
        $message = $request->exists('message') ? $request->input('message') : null;

        $modal = new MessageModal();
        $modal->setName($name);
        $result = $modal->fire_message($message);

        $rtndata['status'] = 1;
        $rtndata['aaData'] = $result;

        return $result;
    }
}
