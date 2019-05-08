<?php

class WincacheSessionHandler extends SessionHandler {
    public function read($session_id) {
        $data = parent::read($session_id);
    }
}

// Initialize the storage
$handler = new WincacheSessionHandler();
session_set_save_handler($handler, true);

session_start();

print "<html><body>WORKS</body></html>";