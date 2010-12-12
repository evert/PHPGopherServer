<?php

/**
 * Gopher server
 * 
 * This is part of an article hosted at http://www.rooftopsolutions.nl/article/100
 * 
 * @package Gopher
 * @version $Id$
 * @copyright 2006 Rooftop Solutions
 * @author Evert Pot <evert@rooftopsolutions.nl> 
 * @licence http://www.freebsd.org/copyright/license.html  BSD License (4 Clause) 
 */

/**
 * Our gopher-server class
 */
class Gopher_Server {

    /**
     * hostname of this server
     * 
     * @var string 
     */
    private $hostname;


    /**
     * default port 
     * 
     * @var int 
     */
    private $port = 70;

    /**
     * ASCII based textfile
     */
    const G_TEXTFILE        = '0';

    /**
     * Directory
     */
    const G_DIRECTORY       = '1';

    /**
     * CSO phonebook (old and unsupported protocol)
     */
    const G_CSO             = '2';

    /**
     * Error message (unsupported)
     */
    const G_ERROR           = '3';

    /**
     * Macintosh binhex file
     */
    const G_MACFILE         = '4';

    /**
     * MS-DOS binary
     */
    const G_DOSFILE         = '5';

    /**
     * Unix UUEncoded file
     */
    const G_UUENCODED       = '6';

    /**
     * Link to a search service
     */
    const G_SEARCH          = '7';

    /**
     * Link to a telnet server
     */
    const G_TELNET          = '8';

    /**
     * Unix binary file
     */
    const G_BINARY          = '9';

    /**
     * Redundant server (unsupported)
     */
    const G_REDUNDANTSERVER = '+';

    /**
     * Link to a TN3270 terminal (unsupported)
     */
    const G_TN3270          = 'T';

    /**
     * Link to a GIF image
     */
    const G_GIF             = 'g';

    /**
     * Link to any other image
     */
    const G_IMAGE           = 'I';

    /**
     * In-line informational text
     */
    const G_TEXT            = 'i';

    /**
     * HTML file
     */
    const G_HTML            = 'h';

    /**
     * Start the server 
     * 
     * @return void
     */
    public function exec() {

        // Read the request from standard input
        $request = fgets(STDIN);
        // Strip off the last character (which is a linebreak)
        $request = substr($request,0,strlen($request)-1);

        $data = $this->processRequest($request);
        echo $this->encodeResponse($data);

    }

    /**
     * Set the hostname (required!) 
     * 
     * @param string $hostname 
     * @return void
     */
    public function setHostName($hostname) {

        $this->hostname = $hostname;

    }

    /**
     * Process a request and return the results
     *
     * <p>
     * This function will return directory listings as a multi-dimensional array, as shown below
     * The items in the subarrays are:
     *
     * * ITEM type (use one of the constants)
     * * Item description
     * * Item location (if not supplied, it will use the description instead)
     * * Servername (if not supplied it will use this servers' hostname)
     * * Port (if not supplied it will use the default gopher port (70)
     * </p> 
     * @param string $request 
     * @return array 
     */
    public function processRequest($request) {

        return array(
            array(self::G_TEXT,     'Welcome to ' . $this->hostname . '. This server has been written in PHP'),
            array(self::G_TEXT,     'The item you requested was: '. $request),
            array(self::G_DIRECTORY,'This is a directory','testdirectory'),
            array(self::G_TEXTFILE, 'This is a textfile','textfile'),
        );
    }

    /**
     * encode the response in a gopher format
     * 
     * @param array $data 
     * @return string 
     */
    public function encodeResponse($data) {

        $raw = '';
        foreach($data as $item) {

            // here we gather information about an item and fill in the missing fields
            $type     = $item[0];
            $title    = $item[1];
            $location = isset($item[2])?$item[2]:$title;
            $server   = isset($item[3])?$item[3]:$this->hostname;
            $port     = isset($item[4])?$item[4]:$this->port;

            switch($type) {
                // If the type is text, we will leave the other items empty
                case self::G_TEXT :
                    $location = 'fake';
                    $server = '(NULL)';
                    $port = 0;
                    break;
            }

            // The tab-seperated directory item
            $raw.=$type . $title . "\t" . $location . "\t" . $server . "\t" . $port . "\n";

        }

        // A dot on the end of the request
        $raw.=".";
        return $raw;

    }

  }

?>
