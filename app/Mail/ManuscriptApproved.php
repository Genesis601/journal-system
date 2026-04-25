<?php

namespace App\Mail;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ManuscriptApproved extends Mailable
{
    use Queueable, SerializesModels;

    public string $comments;

    public function __construct(public Article $article, string $comments = '')
    {
        $this->comments = $comments;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🎉 Your Article Has Been Published — ' . $this->article->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.manuscripts.approved',
        );
    }
}