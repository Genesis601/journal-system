<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ArticleDeleted extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $authorName,
        public string $articleTitle,
        public string $reason
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Notice: Your Article Has Been Removed — ' . $this->articleTitle,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.articles.deleted',
        );
    }
}