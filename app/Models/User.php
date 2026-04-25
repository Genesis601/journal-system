<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $avatar
 * @property string|null $bio
 * @property string|null $institution
 * @property string|null $country
 * @property string|null $phone
 * @method \Illuminate\Database\Eloquent\Collection articles()
 * @method \Illuminate\Database\Eloquent\Collection reviews()
 * @method \Illuminate\Database\Eloquent\Collection sentMessages()
 * @method \Illuminate\Database\Eloquent\Collection receivedMessages()
 * @method \Illuminate\Database\Eloquent\Collection unreadMessages()
 * @method bool hasRole(string $role)
 * @method void assignRole(string $role)
 * @method void syncRoles(array $roles)
 * @method \Illuminate\Database\Eloquent\Collection getRoleNames()
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'bio',
        'institution',
        'country',
        'phone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function articles()
    {
        return $this->hasMany(Article::class, 'author_id');
    }

    public function reviews()
    {
        return $this->hasMany(ArticleReview::class, 'editor_id');
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function unreadMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id')
                    ->whereNull('read_at');
    }
}