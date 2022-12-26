<?php
class IndexController
{
    private $db;
    protected $stylesheet;
    public $navigation;
    public $page;
    public $localPath;
    public $serverPath;

    public function __construct()
    {
        try {
            $this->localPath = '/';
            /** I used this vs. DOCUMENT_ROOT because I'm using a symlink to a different drive */
            $this->serverPath = str_replace("/src/Controllers", "", __DIR__) . '/';
            /** page is defined via .htaccess */
            $this->page = ($_REQUEST['page'] ?? '') ? ucwords($_REQUEST['page']) : 'Home';

            $this->autoload();
            $this->dbConnect();

            require_once($this->serverPath . 'src/Views/header.html');
            $this->handleController();
            require_once($this->serverPath . 'src/Views/footer.html');
        } catch(Exception $e) {
            $this->handleError($e->getMessage());
        }
    }

    /**
     * Created 12/21/22 freddygiordano
     * Returns void
     * Autoload any controllers so we can just add a controller to add a page
     */
    private function autoload() {
        require_once('config.php');
        require_once($this->serverPath . 'vendor/autoload.php');
        $this->stylesheet = file_get_contents($this->serverPath . 'assets/css/kindle.css');
        $controllers = glob(__DIR__ . '/*');
        foreach ($controllers as $controller) {
             require_once($controller);
        }
    }
    /**
     * Created 12/21/22 freddygiordano
     * Returns void
     * Local database credentials are put in virtual host for apache to pick up and send to PHP
     */
    private function dbConnect() {
        try {
            $this->db = new \PDO('mysql:home=' . $_SERVER['DBHOST'] . ';dbname=' . $_SERVER['DBNAME'], $_SERVER['DBUSER'], $_SERVER['DBPW']);
        } catch (Exception $e) {
            die('Failed to connect to database because: ' . $e->getMessage());
        }
    }


    private function handleController() {
        if (class_exists($this->page)) {
            // pass database into controller
            $Obj = new $this->page($this->db, $this);
        }
    }

}