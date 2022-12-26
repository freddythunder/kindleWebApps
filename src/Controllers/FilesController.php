<?php

class Files
{

    private $db;
    protected $filepath;
    protected $filelist;

    public function __construct(PDO $db, IndexController $index) {
        $this->db = $db;
        $path = $index->serverPath . 'src/Views/' . $index->page. '.php';
        $this->filepath = $index->serverPath . 'files/';
        $this->filelist = $this->getFilelist();
        if (file_exists($path)) {
            require_once($path);
        } else {
            /** No view found */
            error_log('No view found for ' . $path);
        }
    }

    private function getFilelist() {
        return glob($this->filepath . '*.{txt,jpg,png}', GLOB_BRACE);
    }

    protected function humanFilesize($bytes, $dec = 2)
    {
        $size   = array('B', 'kB', 'MB', 'GB', 'TB');
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$dec}f", $bytes / pow(1024, $factor)) . @$size[$factor];
    }


}