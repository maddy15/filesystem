<?php

namespace App\Mail\Files;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\File;

class FileUpdatesRejected extends Mailable
{
    use Queueable, SerializesModels;

    /**F
     * Create a new message instance.
     *
     * @return void
     */
    public $file;

    public $user;

    public function __construct(File $file)
    {
        $this->file = $file;
        $this->user = $file->user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your file updates has been rejected.')->view('emails.files.updated.rejected');
    }
}
