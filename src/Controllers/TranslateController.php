<?php

class TranslateController
{

    private $db;
    protected $italian;
    protected $spanish;
    protected $english;

    public function __construct(PDO $db, IndexController $index) {
        $this->db = $db;
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $this->doTranslation();
        }
        $path = $index->serverPath . 'src/Views/' . $index->page. '.php';
        if (file_exists($path)) {
            require_once($path);
        } else {
            /** No view found */
            error_log('No view found for ' . $path);
        }
    }

    private function doTranslation() {
        $this->italian = $_REQUEST['italian'];
        $this->spanish = $_REQUEST['spanish'];
        $this->english = $_REQUEST['english'];
        /** google translate URL avail has disappeared
         *  actual API looks constly and difficult
         *  I need to find a translator
         */

    }


}