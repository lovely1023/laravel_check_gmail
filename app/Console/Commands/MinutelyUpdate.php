<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;
use Illuminate\Support\Str;

class MinutelyUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert_gmail:minutely';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'New emails from the inbox of Gmail enter into the database minutely.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // return 0;
//  $str = Str::random(10);
//          $curDateTime = date("Y-m-d H:i:s");
//         DB::table('gmails')->insert(
//             ['address' => $str.'@123.com', 'title' => $str.'_title', 'content' => $str, 'addin_file' => $str.'.txt', 'received_at'=>$curDateTime,'created_at' => $curDateTime ]
//         );
$curDateTime = date("Y-m-d H:i:s");

        $connection = imap_open('{imap.gmail.com:993/imap/ssl}INBOX', 'yaroslavgaponenko04041996@gmail.com', 'Ufgjytyrjzhjckfd04041996') or die('Cannot connect to Gmail: ' . imap_last_error());

        /* Search Emails having the specified keyword in the email subject */
        $emailData = imap_search($connection, 'ALL');
        
        if (! empty($emailData)) {
            foreach ($emailData as $emailIdent) {

                $overview = imap_fetch_overview($connection, $emailIdent, 0);
                $message = imap_fetchbody($connection, $emailIdent, '1.1');
                $messageExcerpt = substr($message, 0, 150);
                $partialMessage = trim(quoted_printable_decode($messageExcerpt)); 
                $date = date("Y-m-d H:i:s", strtotime($overview[0]->date));
                $from = $overview[0]->from;
                $subject = $overview[0]->subject;
                      
                        DB::table('gmails')->insert(
                            ['address' => $from, 'title' => $subject, 'content' => $subject, 'addin_file' => $date, 'received_at'=>$date,'created_at' => $curDateTime ]
                        );
            } // End foreach
        } // end if
        
        imap_close($connection);




    	$this->info('New gmails enter into gmails table Successfully!');
    }
}
