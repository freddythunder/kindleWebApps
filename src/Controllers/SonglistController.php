<?php

class Songlist
{

    private $db;
    protected $initials;
    protected $songlist;
    protected $songdata;

    public function __construct(PDO $db, IndexController $index) {
        $this->db = $db;
        if ($_REQUEST['list'] ?? '') {
            // letter coming in
            $this->songlist = $this->getSonglist($_REQUEST['list']);
        } else if ($_REQUEST['song'] ?? '') {
            $this->songdata = $this->getSongData($_REQUEST['song']);
        } else {
            $this->initials = $this->getInitials();
        }

        $path = $index->serverPath . 'src/Views/' . $index->page. '.php';
        if (file_exists($path)) {
            require_once($path);
        } else {
            /** No view found */
            error_log('No view found for ' . $path);
        }
    }

    private function getInitials() {
        $query = "select upper(substring(title, 1, 1)) as letter
            from songlist group by upper(substring(title, 1, 1)) order by title";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $results = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $results[] = $row['letter'];
        };
        return $results;
    }

    private function getSongData($song = null) {
        if ($song) {
            $query = "select * from songlist where id=?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$song]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }

    private function getSonglist($initial = null) {
        if ($initial) {
            $query = "select id, title, artist 
                from songlist where title like ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$initial . '%']);
            $results = [];
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $results[] = $row;
            };
            return $results;
        }
    }


}