<?php

class Sabre_Gopher_Server {

    private $hostname;
    private $port = 70;

    const G_TEXTFILE        = '0';
    const G_DIRECTORY       = '1';
    const G_CSO             = '2';
    const G_ERROR           = '3';
    const G_MACFILE         = '4';
    const G_DOSFILE         = '5';
    const G_UUENCODED       = '6';
    const G_SEARCH          = '7';
    const G_TELNET          = '8';
    const G_BINARY          = '9';
    const G_REDUNDANTSERVER = '+';
    const G_TN3270          = 'T';
    const G_GIF             = 'g';
    const G_IMAGE           = 'I';
    const G_TEXT            = 'i';
    const G_HTML            = 'h';        

    public function exec() {

        $request = fgets(STDIN);
        $data = $this->processRequest($request);
        echo $this->encodeResponse($data);

    }

    public function setHostName($hostname) {

        $this->hostname = $hostname;

    }

    public function processRequest($request) {

        return array(
            array(self::G_TEXT,'Welcome to my gopher server. This server has been written in PHP'),
            array(self::G_IMAGE,'This is a file'),
            array(self::G_HTML,'To my website','URL:http://www.rooftopsolutions.nl'),
        );

    }

    public function encodeResponse($data) {

        $raw = '';
        foreach($data as $item) {

            $type     = $item[0];
            $title    = $item[1];
            $location = isset($item[2])?$item[2]:$title;
            $server   = isset($item[3])?$item[3]:$this->hostname;
            $port     = isset($item[4])?$item[4]:$this->port;

            switch($type) {
                case self::G_TEXT : 
                    $location = '';
                    $server = '';
                    $port = '';
                    break;
            }
            
            $raw.=$type . $title . "\t" . $location . "\t" . $server . "\t" . $port . "\n";

        }
        $raw.=".";
        return $raw;

    }

}

?>
