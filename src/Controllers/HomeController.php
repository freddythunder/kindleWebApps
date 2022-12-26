<?php

class Home
{

    private $db;

    public function __construct(PDO $db, IndexController $index) {
        $this->db = $db;
        $path = $index->serverPath . 'src/Views/' . $index->page. '.php';
        if (file_exists($path)) {
            require_once($path);
        } else {
            /** No view found */
            error_log('No view found for ' . $path);
        }
    }


}