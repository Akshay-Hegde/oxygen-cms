<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once dirname(__FILE__).'/reader/Oxygen_Email_Message.php';
require_once dirname(__FILE__).'/reader/Oxygen_Email_Fetcher.php';
require_once dirname(__FILE__).'/reader/Email_reader_base.php';

class Email_reader extends Email_reader_base
{


    /**
     * Connect to inbox
     */
    function __construct() 
    {
        parent::__construct();
    }


    public function setAccount($srv='',$user='',$pass='***',$port=993,$per_page=10,$con_flags='/imap/ssl')
    {
        // email login credentials
        $this->server           = $srv;
        $this->user             = $user;
        $this->pass             = $pass;
        $this->port             = $port; // adjust according to server settings
        $this->con_flags        = $con_flags;

        $this->limit_per_page   = $per_page;
        $this->current_folder   = 'INBOX'; 
        $this->headers_only     = true;        
    }

    public function openConnection()
    {
        if($status = $this->connect()){
            $this->inbox(); 
            return $this->getStatus();
        }
        return false;
    }

    public function closeConnection()
    {
        $this->close();
    }

    public function hasConnection() 
    {
        return $this->has_connection();
    }

    /**
     * Return the user of the mailbox
     */
    public function getUser()
    {
        return $this->user;
    }


    /**
     * Change folders
     */
    public function setFolder($folder)
    {

        $this->current_folder = $folder;

    }
    

    /**
     * Gets the list of folders in the mailbox
     */
    public function getFolders()
    {
        // Get a list of folders
        $folders = $this->pull_folders();

        //$folders =  imap_getmailboxes( $this->conn , $ref , "*" ); 

        return $folders['folders'];
    }


    
    /**
     * Get inbox data
     */
    public function getInbox($page = 1) 
    {
        
        $this->inbox($page);
        
        //return data
        return $this->inbox;
    }

    /**
     * Retrieve a specific message
     */
    public function getMessage($msg_uid=NULL, $fetch_body=true)
    {
        return $this->get($msg_uid,$fetch_body);
    }

    
    /**
     * Get the message count of the folder
     */
    public function getMessageCount()
    {
       return $this->msg_cnt;
    }

    public function getStatus()
    {
       return (array)$this->status();
    }

    public function deleteMessage($num)
    {
       return $this->delete_message($num);
    }

    public function downloadHeaders($from_uid, $get_next = 50)   
    {
        return $this->download_headers($from_uid, $get_next );
    }

    public function searchBy($criteria)
    {
        return $this->search($criteria);
    }

    public function setFlags( $uid, array $flags = [])
    {
        $this->flag($uid, $flags);
    }
    


}
