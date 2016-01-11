<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Oxygen_Email_Fetcher 
{
    protected $conn;

    /**
     * Constructor
     */
    function __construct(&$conn)
    {
        $this->conn = $conn;
    }

    // get a specific message (1 = first email, 2 = second email, etc.)
    public function fetch($uid=NULL,$fetch_body) 
    {

        ///
        /// Prepare the array to return
        ///
        $mail_message = new Oxygen_Email_Message($uid);

        // we cant use uid for header info, so get the mid
        $mid = imap_msgno($this->conn , $uid );


        $mail_message->setHeader( imap_headerinfo($this->conn, $mid) );

    
        if($fetch_body)
        {
            // HEADER
            $h = imap_header($this->conn,$mid);
            // add code here to get date, from, to, cc, subject...

            // BODY
            $s = imap_fetchstructure($this->conn,$uid,FT_UID);

            //dump($s);die;

            // simple
            if ((!isset($s->parts)) OR (!$s->parts))   
            {
                $this->get_message_part($mail_message,$s,0);  // pass 0 as part-number
            }
            else 
            {  
                // multipart: cycle through each part
                foreach ($s->parts as $partno0=>$p) 
                {
                    $this->get_message_part($mail_message,$p,$partno0+1);
                }
            }
        }

        // return the MailMessage Object
        return $mail_message;  
    }



    protected function get_message_part($mail,$p,$partno) 
    {
        // $partno = '1', '2', '2.1', '2.1.3', etc for multipart, 0 if simple
        // DECODE DATA (from simople or multipart mail)
        $data = ($partno)?
            imap_fetchbody($this->conn, $mail->getUID() ,$partno,FT_UID):  // multipart
            imap_body($this->conn, $mail->getUID(), FT_UID );  // simple


        // Any part may be encoded, even plain text messages, so check everything.
        if ($p->encoding==4)
        {
            $data = quoted_printable_decode($data);
        }
        elseif ($p->encoding==3)
        {
            $data = base64_decode($data);
        }

        //
        // PARAMETERS
        // get all parameters, like charset, filenames of attachments, etc.
        //
        $params = [];
        if ($p->ifparameters) 
        {
            foreach ($p->parameters as $x)
            {
                $params[strtolower($x->attribute)] = $x->value;
            }
        }
        // Double check the type of param
        if ($p->ifdparameters)
        {
            foreach ($p->dparameters as $x)
            {
                $params[strtolower($x->attribute)] = $x->value;
            }
        }



        //if(($p->type!=0) && ($p->type!=1))
        {

            // ATTACHMENT
            // Any part with a filename is an attachment,
            // so an attached text file (type 0) is not mistaken as the message.
            if (isset($params['filename']) || isset($params['name']))
            {
                // filename may be given as 'Filename' or 'Name' or both
                $filename = (isset($params['filename']))? $params['filename'] : $params['name'];
                // filename may be encoded, so see imap_mime_header_decode()
                $mail->addAttachments($filename,$data); 
            }
        }

        // TEXT
        if ( $p->type == 0 && $data ) 
        {
            // Messages may be split in different parts because of inline attachments,
            // so append parts together with blank row.
            if (strtolower($p->subtype)=='plain')
            {
                $mail->appendToPlainMessage(trim($data));
            }
            else
            {
                $mail->appendToHTMLMessage($data);
            }

            if(isset($params['charset'])) 
            {
                $mail->setCharSet($params['charset']);
            }
            

        }

        // EMBEDDED MESSAGE
        // Many bounce notifications embed the original message as type 2,
        // but AOL uses type 1 (multipart), which is not handled here.
        // There are no PHP functions to parse embedded messages,
        // so this just appends the raw source to the main message.
        elseif ($p->type==2 && $data) 
        {
            $mail->appendToPlainMessage($data);
        }

        // SUBPART RECURSION
        if (isset($p->parts) )
        {
            foreach ($p->parts as $partno0=>$p2) 
            {
                $this->get_message_part($mail,$p2,$partno.'.'.($partno0+1));  // 1.2, 1.2.1, etc.
            }
        }
    }
}
