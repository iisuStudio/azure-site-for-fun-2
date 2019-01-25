<?php

namespace App\Http\Controllers;

class MessageModal extends Modal
{
    private $name;

    public function setName($name){
        return $this->name = $name;
    }

    public function fire_message($message){
        return $this->session->fire($this->name, $message);
    }

    public function get_message(){
        $refer = $this->session->refer();
        return $refer->getValue();
    }
}
