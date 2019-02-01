<?php

namespace App\Models;

use App\Services\FirebaseService;

class Message
{
    static protected $reference = 'messages';

    private $db;

    public function __construct ()
    {
        $this->db = new FirebaseService();
        $this->db->setReference(static::$reference);
    }

    public function getList (): array
    {
        return $this->refer()->getValue() ?: [];
    }

    public function fire($message){
        return $this->db->setData($message);
    }

    public function refer($_token = null){
        return $this->db->getReference(static::$reference);
    }
}
