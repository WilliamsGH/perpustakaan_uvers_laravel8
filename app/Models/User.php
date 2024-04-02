<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Major;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'institution_id',
        'name',
        'email',
        'username',
        'password',
        'gender',
        'active',
        'major_id',
        'phone',
        'generation',
        'join_date',
        'address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    public function wish_lists()
    {
        return $this->hasMany(WishList::class);
    }

    public function borrowed_book()
    {
        return $this->belongsToMany(Book::class, 'book_moves')->whereNull('book_moves.return_date')->withPivot('borrow_date', 'return_date');
    }

    public function borrowed_history()
    {
        return $this->hasMany(BookMove::class);
    }

    public function generateToken()
    {


        $accessToken = $this->createToken('accessToken', ['*'])->plainTextToken;
        $refreshToken = $this->createToken('refreshToken', ['get_token'])->plainTextToken;

        return ['access_token' => $accessToken, 'refresh_token' => $refreshToken];
        
    }

}
