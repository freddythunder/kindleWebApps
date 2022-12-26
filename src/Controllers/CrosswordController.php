<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
class Crossword
{

    private $db;
    private $crosswordPath;
    protected $kindleEmail;
    protected $successMsg;

    public function __construct(PDO $db, IndexController $index) {
        $this->db = $db;
        $path = $index->serverPath . 'src/Views/' . $index->page. '.php';
        $this->crosswordPath = $index->serverPath . 'files/';
        $this->kindleEmail = $_COOKIE['kindleEmail'] ?? '';
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $this->kindleEmail = $_REQUEST['kindleEmail'];
            if (!preg_match("/.*@kindle\.com$/", strtolower($this->kindleEmail))) {
                die('This is not a kindle email address.');
            }
            $this->getCrossword();
            $this->successMsg = 'Your crossword should be on the way!';
            // TODO delete crossword
        }
        if (file_exists($path)) {
            require_once($path);
        } else {
            /** No view found */
            error_log('No view found for ' . $path);
        }
    }

    private function getCrossword() {
        // cookie email address
        setCookie('kindleEmail', $this->kindleEmail, time()+(86400*30));
        // get PDF crossword
        $datetime = new DateTime($_REQUEST['date']);
        $date = $datetime->format('ymd');
        $xtra = '1'; // 1=puzzle, 2=solution
        $url = "http://www.brainsonly.com/servlets-newsday-crossword/newsdaycrosswordPDF?pm=pdf&puzzle=" . $date . $xtra;
        $url .= "&data=%3CNAME%3E" . $date . "%3C%2FNAME%3E%3CTYPE%3E" . $xtra . "%3C%2FTYPE%3E";
        $this->crosswordPath .= 'Newsday ' . $datetime->format('m-d-Y') . '.pdf';
        if (!file_exists($this->crosswordPath)) {
            $pdf = file_get_contents($url);
            file_put_contents($this->crosswordPath, $pdf) or die ('did not put ' . $this->crosswordPath);
        }
        // email to kindle
        $this->sendMail();
    }

    private function sendMail() {
        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
        try {
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host = $_SERVER['MAILHOST'];
            $mail->SMTPAuth = true;
            $mail->Username = $_SERVER['MAILUSER'];
            $mail->Password = $_SERVER['MAILPW'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;
            /** mailuser is the same as my from address, this may be different at your STMP */
            $mail->setFrom($_SERVER['MAILUSER'], 'KindleWebApp');
            $mail->addAddress($this->kindleEmail);
            $mail->isHTML(true);
            $mail->Subject = '';
            $mail->Body = 'Crossword puzzle for kindle';
            $mail->AltBody = '';
            $mail->addAttachment($this->crosswordPath);

            $mail->send();
        } catch (Exception $e) {
            die('Mail was not sent because: ' . $e->getMessage());
        }
    }


}