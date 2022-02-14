<?php

namespace App\Http\Controllers;

use App\Models\GetGmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ddeboer\Imap\Server;
use Ddeboer\Imap\SearchExpression;
//use Ddeboer\Imap\Search\Email\To;
use Ddeboer\Imap\Search\Text\Body;
use Ddeboer\Imap\Message\EmailAddress;
use Ddeboer\Imap\Message\Attachment;

class GetGmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $connection = imap_open('{imap.gmail.com:993/imap/ssl}INBOX', 'yaroslavgaponenko04041996@gmail.com', 'Ufgjytyrjzhjckfd04041996') or die('Cannot connect to Gmail: ' . imap_last_error());

        $hostname = 'imap.gmail.com';
        $flags = '/imap/ssl/validate-cert';
        $parameters = [];
        $port = 993;
        $server = new Server(
            $hostname, // required
            $port,     // defaults to '993'
            $flags,    // defaults to '/imap/ssl/validate-cert'
            $parameters
        );
        // $connection is instance of \Ddeboer\Imap\Connection
        $connection = $server->authenticate('yaroslavgaponenko04041996@gmail.com', 'Ufgjytyrjzhjckfd04041996');
       

        //  Mailboxes
        // $mailboxes = $connection->getMailboxes();

        // foreach ($mailboxes as $mailbox) {
        //     // Skip container-only mailboxes
        //     // @see https://secure.php.net/manual/en/function.imap-getmailboxes.php
        //     if ($mailbox->getAttributes() & \LATT_NOSELECT) {
        //         continue;
        //     }

        //      // $mailbox is instance of \Ddeboer\Imap\Mailbox
        //     printf('Mailbox "%s" has %s messages', $mailbox->getName(), $mailbox->count());
        // }
            
        $mailbox = $connection->getMailbox('INBOX');    //$connection->deleteMailbox($mailbox);

        //  Messages
        $messages = $mailbox->getMessages();
        foreach ($messages as $message) {
            if ($message->isSeen() || $message->isDeleted()) {
                 continue;
            }

            $message->getNumber();
            $message->getId();

            $subject = $message->getSubject();
            $date = $message->getDate();
            $datetime =  date("Y-m-d H:i:s", $date->getTimestamp());
            echo($datetime.'<br/>');
            $header = $message->getHeaders();
            $text   = $message->getBodyText();
            $html   = $message->getBodyHtml();

            // echo($header.'===');
            echo($subject.'<br/>');
            echo($html.'<br/>');

            // $from_hostname = $message->getFrom()->gethostname();//gmail.com
            // $from_hostname = $message->getFrom()->getFullAddress();
            // $from_hostname = $message->getFrom()->getFullAddress();
            $from_address= $message->getFrom()->getAddress();
            echo($from_address.'<br/>');

            $from_name= $message->getFrom()->getName();
            echo($from_name.'<br/>');

            $attachments = $message->getAttachments();
            foreach ($attachments as $attachment) {
                file_put_contents(
                    'C:\\Users\\Myr\\Documents\\leoPython\\' . $attachment->getFilename(),
                    $attachment->getDecodedContent()
                );
                // $attachment is instance of \Ddeboer\Imap\Message\Attachment
                printf('"%s"', $attachment->getFilename());
            }

            // printf('"%s"', $message->getFrom()->getFullAddress());
            // printf("\r\n");
           
            // $message->markAsSeen();
        }
        // $mailbox is instance of \Ddeboer\Imap\Mailbox
    

        $gmails = DB::select('SELECT * FROM gmails LIMIT 100;');
        return view('gmails.index', ['gmails' => $gmails]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\GetGmail  $getGmail
     * @return \Illuminate\Http\Response
     */
    public function show(GetGmail $getGmail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\GetGmail  $getGmail
     * @return \Illuminate\Http\Response
     */
    public function edit(GetGmail $getGmail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\GetGmail  $getGmail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GetGmail $getGmail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\GetGmail  $getGmail
     * @return \Illuminate\Http\Response
     */
    public function destroy(GetGmail $getGmail)
    {
        //
    }
}
