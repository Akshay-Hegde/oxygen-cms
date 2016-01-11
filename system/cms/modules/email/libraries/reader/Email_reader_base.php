<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Email_reader_base 
{

    // imap server connection
    protected $conn;
    // inbox storage and inbox message count
    protected $inbox;
    protected $msg_cnt;
    
    // email login credentials
    protected $server           = '';
    protected $user             = '';
    protected $pass             = '';
    protected $port             = 993; // adjust according to server settings
    protected $con_flags        = '/imap/ssl';
    protected $headers_only     = true;
    protected $limit_per_page   = 10;
    protected $current_folder   = 'INBOX';
    protected $connect_string;

    /**
     * Connect to server and read inbox
     */
    function __construct() 
    {

    }



 
    /**
     * Close Imap/Server connection
     */
    public function close() 
    {
        $this->inbox = [];
        $this->msg_cnt = 0;
        imap_close($this->conn);
    }

    /**
     * Get status of the current mailbox
     */
    public function status()
    {
        return imap_status( $this->conn , $this->connect_string, SA_ALL );
    }

 
    /**
     * the imap_open function parameters will need to be changed for the particular server
     * these are laid out to connect to a Dreamhost IMAP server
     */
    public function connect() 
    {
        $this->connect_string = '{'.$this->server.':'.$this->port.$this->con_flags.'}'.$this->current_folder;

        try
        {
            if($this->conn = @imap_open($this->connect_string, $this->user, $this->pass))
            {

                return imap_check ( $this->conn );
            }

        }
        catch(Exception $er)
        {

        }
        
        // clear the error stack
        imap_errors();
        imap_alerts();

        return false;

        //imap_reopen($this->conn, '{'.$this->server.':'.$this->port.$this->con_flags.'}INBOX/Clients/Jacinta');
    }

    public function has_connection() 
    {
        if($this->conn)
        {
            return true;
        }

        return false;
    }

    /**
     * Move a message to another folder
     */
    public function move($msg_index, $folder='INBOX.Processed') 
    {
        // move on server
        imap_mail_move($this->conn, $msg_index, $folder);
        imap_expunge($this->conn);
    
        // re-read the inbox
        $this->inbox();
    }
    

    // get a specific message (1 = first email, 2 = second email, etc.)
    protected function get($uid=NULL,$fetch_body=true) 
    {

        // Fetch the mail item
        $fetcher = new Oxygen_Email_Fetcher($this->conn);

        // Get the specific mail by id and true/false if we 
        // should also get the body content
        $mail_message = $fetcher->fetch($uid,$fetch_body);

        // return
        return $mail_message;  
    }

    /**
     * \Seen, \Answered, \Flagged, \Deleted, and \Draft
     */
    protected function flag( $uid, array $flags = [])
    {

        $email = new Oxygen_Email_Message($uid);

        foreach($flags as $flag)
        {
             $email->setFlag($flag);
        }

        dump(imap_setflag_full( $this->conn , (string) $uid , $email->getFlags() , ST_UID ));die;
    }

    public function download_headers($from_uid, $get_next = 50)   
    {
        $check = imap_check($this->conn);
        $status = $this->status();

        $most_recent_uid = $status->uidnext - 1;

        //get status of maibox to get the top most uid
        $end_to = ($from_uid + $get_next);
        $end_to = ( $most_recent_uid < $end_to )? $most_recent_uid : $end_to ;

        $results = @imap_fetch_overview ( $this->conn , "{$from_uid}:{$end_to}", FT_UID );

        return ['results'=>$results,'mcount'=>$check->Nmsgs,'current'=>$end_to,'last_server_uid'=>$most_recent_uid];      
    }

    public function search($search_criteria)   
    {
        return @imap_search( $this->conn, $search_criteria,SE_UID);
    }

    // read the inbox
    protected function inbox($page=1,$full=false) 
    {
        $this->msg_cnt = imap_num_msg($this->conn);

        $start_from = $this->pager($page)['start'];
        $end_to = $this->pager($page)['end'];

        $in = [];
        for($i = $start_from; $i <= $end_to; $i++) 
        {
            $uid = $this->getUID($i);
            if($h = @imap_headerinfo($this->conn, $i))
            {

                $iii = [];
                $iii['index']   = $i;
                $iii['uid']     = $uid;
                $iii['header']  = imap_headerinfo($this->conn, $i);
                if(!$this->headers_only)
                {
                    $iii['body']        = imap_body($this->conn, $uid,FT_UID );
                    $iii['structure']   = imap_fetchstructure($this->conn, $uid,FT_UID );
                }

                $in[] = $iii;
            }
        }
    
        $this->inbox = $in;
    }

    protected function pager($page=1)
    {
        $return = [];

        //2020 - (10 * 1)
        //2020 - 20 = 2010 
        $return['end'] = $this->msg_cnt - ($this->limit_per_page * $page); // - $this->msg_cnt;

        //2020 + 10 = 10
        $return['start'] = $return['end'] - $this->limit_per_page; 

        return $return;
    }


    public function pull_folders()
    {

        $ref = '{'.$this->server.':'.$this->port.$this->con_flags.'}';
        $folders =  imap_getmailboxes( $this->conn , $ref , "INBOX" ); 

        //$folders = imap_listmailbox($this->conn, $ref, "INBOX");

        //dump($folders);die;


        $return=[];

        if (is_array($folders)) 
        {
            foreach ($folders as $key => $val) 
            {
                $r=[];
                $r['key'] = $key;
                $r['raw'] = $val->name;
                $r['name'] =  str_replace($ref,'',imap_utf7_decode($val->name));
                $r['clean'] =  str_replace(' ','%20',imap_utf7_decode($r['name']));
                $r['delimiter'] =   $val->delimiter;
                $attr = $this->getAttribute($val->attributes);
                $r['count'] = ''; // 

                if('LATT_NOSELECT'==$attr)
                {
                    //just a container, not a box
                }
                else
                {
                    $return[] = $r;
                }
                
            }
        }

        return ['folders'=> $return];
    }

    protected function getAttribute($code)
    {

        switch($code)
        {
            case 1:
                return 'LATT_NOINFERIORS';
                break;
            case 2:
                return 'LATT_NOSELECT';
                break;
            case 4:
                return 'LATT_MARKED';
                break;
            case 8:
                return 'LATT_UNMARKED';
                break;
            case 16:
                return 'LATT_REFERRAL';
                break;   
            case 32:
                return 'LATT_HASCHILDREN';
                break;
            case 64:
                return 'LATT_HASNOCHILDREN';
                break;                                                                             
        }
    }

    /**
     * Get the uid of a message
     */
    protected function getUID($msg_number)
    {
        return imap_uid( $this->conn , $msg_number );
    }

    /**
     * Convert uid to mid, call to server is required
     */
    protected function getMID($uid)
    {
        return imap_msgno( $this->conn , $uid );
    }

    /**
     * Delete a message either by session mes_id or uid
     * Default its uid for delete
     */
    public function delete_message($num,$by='uid')
    {
        //otherwise its message id
        if($by=='mid') {
            $num = $this->getUID($num);
        }

        //$check = imap_mailboxmsginfo($this->conn);

        //$before = $check->Nmsgs;

        //imap_delete($this->conn, $num ); 
        imap_delete($this->conn, $num, FT_UID );
        
        //$check = imap_mailboxmsginfo($this->conn);

        return true;
        
        $after = $check->Nmsgs ;
        
        if( $before > $after )
        {
            return true;
        }

        return false;
    }

}
