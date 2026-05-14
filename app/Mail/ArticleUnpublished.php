<?php

namespace App\Mail;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ArticleUnpublished extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Article $article,
        public string $reason
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Article Has Been Unpublished — ' . $this->article->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.articles.unpublished',
        );
    }
}