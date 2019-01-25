<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class FirebaseController extends Controller
{
    protected $firebase;
    protected $reference = 'blog';
    protected $reference_root = 'blog';

    public function __construct()
    {
        $serviceAccount = ServiceAccount::fromJsonFile(base_path() . '/firebase.json');
        $this->firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->create();
    }

    public function index(){
        return 1;
    }

    public function getDatabase(){
		return $this->firebase->getDatabase();
	}

    public function getReference(string $path) {
        $database = $this->getDatabase();
        return $database->getReference($this->reference_root . '/' . $path);
    }

    public function setReference(string $path){
        return $this->reference = $this->reference_root . '/' . $path;
    }

	public function setData(array $data) {
        $database = $this->getDatabase();
        return $database->getReference($this->reference)->push($data);
    }
}
