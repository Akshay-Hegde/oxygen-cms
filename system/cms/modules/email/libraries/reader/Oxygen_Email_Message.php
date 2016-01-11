<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Oxygen_Email_Message 
{
    protected $mail_UID;
    protected $charset;
    protected $htmlmsg;
    protected $plainmsg;
    protected $attachments;
    protected $header;
    protected $flags;

    /**
     * Constructor
     */
    function __construct($uid=null) 
    {
        $this->setUID($uid);
        $this->attachments = [];
        $this->charset = '';
        $this->htmlmsg = '';
        $this->plainmsg = '';  

        //flags
        $this->flags = [];
    }


    /**
     * Getters
     */
    public function getUID()            { return $this->mail_UID;       }
    public function getCharSet()        { return $this->charset;        }
    public function getHtmlMessage()    { return $this->htmlmsg;        }
    public function getPlainMessage()   { return $this->plainmsg;       }
    public function getAttachments()    { return $this->attachments;    }
    public function getHeader()         { return $this->header;         }   

    /**
     * Setters
     */
    public function setUID($uid) 
    {
        $this->mail_UID = $uid;
    }

    /**
     * SDet mail char set
     */
    public function setCharSet($charset) 
    {
        $this->charset = $charset;
    }

    /**
     * This overrites any existing message
     */
    public function setHtmlMessage($html) 
    {
        $this->htmlmsg = $html;
    }

    /**
     * This overrites any existing message
     */
    public function setPlainMessage($message) 
    {
        $this->plainmsg = $message; 
    }

    /**
     * Add a file to the message
     */
    public function addAttachments($filename,$attatch_data) 
    {
        $this->attachments[] = ['filename'=>$filename,'content'=>$attatch_data];
    }    

    /**
     * Add some html data
     */
    public function appendToHTMLMessage($html)
    {
        $this->htmlmsg .= $html . '<br><hr><br>';
    }

    public function appendToPlainMessage($text)
    {
        $this->plainmsg .= $text . "\n\n------ PART ------\n\n";
    }

    public function setHeader($header) 
    {
        $this->header = $header;
    }

    /**
     * @return int (0 = ivalid flag, 1 is already exist, 2 is success)
     */
    public function setFlag($flag = 'Seen')
    {
        switch($flag)
        {
            case 'Seen':
            case 'Answered':
            case 'Flagged':
            case 'Deleted':
            case 'Draft':
                //ok
                break;
            default:
                return 0;
        }

        if(isset($this->flags[$flag]))
        {
            return 1;
        }
        else
        {
            $this->flags[$flag] = $flag;
        }

        return 2;
    }

    public function getFlags()
    {
        $flag_string = '';

        foreach($this->flags as $key=>$flag)
        {
            $flag_string .= "\\{$flag} ";
        }

        return $flag_string;
    }

 
}