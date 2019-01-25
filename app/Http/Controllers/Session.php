<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\FirebaseController;

class Session extends Controller
{
    public function fire($name, $message){
        $_token = session()->get('_token');
        $db = new FirebaseController();
        $path = 'messages';
        $db->setReference($path);
        $result = $db->setData([
            'uid' => $_token,
            'user' => $name,
            'message' => $message,
            'iCreateTime' => time()
        ]);

        return $result;
    }

    public function refer($_token = null){
        $db = new FirebaseController();
        $path = 'messages';
        return $db->getReference($path);
    }
}
