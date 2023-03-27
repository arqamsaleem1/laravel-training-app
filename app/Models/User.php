<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Paddle\Billable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @OA\Schema(
 *
 *     title="User",
 *     description="User model",
 *     @OA\Xml(
 *         name="User"
 *     )
 * )
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use Billable;

    


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

    /**
     * @OA\Property(
     *     title="Id",
     *     description="Id of the user",
     *     format="int64",
     *     example=1
     * )
     *
     * @var int
     */
    //private $id;

    /**
     * @OA\Property(
     *      title="name",
     *      description="Name of the new user",
     *      example="A nice user"
     * )
     *
     * @var string
     */
    //public $name;

    /**
     * @OA\Property(
     *      title="email",
     *      description="Email of the new user",
     *      example="user@gmail.com"
     * )
     *
     * @var string
     */
    //public $email;

    /**
     * @OA\Property(
     *      title="email_verified_at",
     *      description="email_verified_at of the new user",
     *      format="datetime",
     *      type="string",
     *      example=1
     * )
     *
     * @var int
     */
    //public $email_verified_at;

    /**
     * @OA\Property(
     *      title="Password",
     *      description="Password of the new user",
     *      example=1
     * )
     *
     * @var int
     */

    //public $password;
    
    /**
     * @OA\Property(
     *      title="remember_token",
     *      description="remember_token of the new user",
     *      example=1
     * )
     *
     * @var int
     */

    //public $remember_token;

    /**
     * @OA\Property(
     *     title="Created at",
     *     description="Created at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    //private $created_at;

    /**
     * @OA\Property(
     *     title="Updated at",
     *     description="Updated at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    //private $updated_at;

    /**
     * @OA\Property(
     *      title="Role",
     *      description="Role's id of the new user",
     *      example=1
     * )
     *
     * @var int
     */
    //public $role;
}
