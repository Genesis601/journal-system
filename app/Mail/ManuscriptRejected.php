<?php

namespace App\Mail;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ManuscriptRejected extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Article $article,
        public string $comments
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Update on Your Manuscript — ' . $this->article->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.manuscripts.rejected',
        );
    }
}