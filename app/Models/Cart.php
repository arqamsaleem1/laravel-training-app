<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *
 *     title="Cart",
 *     description="Cart model",
 *     @OA\Xml(
 *         name="Cart"
 *     )
 * )
 */
class Cart extends Model
{
    use HasFactory;

    /**
     * @OA\Property(
     *     title="Id",
     *     description="Id of the cart item",
     *     format="int64",
     *     example=1
     * )
     *
     * @var int
     */
    //private $id;
    
    /**
     * @OA\Property(
     *     title="course_id",
     *     description="course_id of the cart item",
     *     format="int64",
     *     example=1
     * )
     *
     * @var int
     */
    //private $course_id;
    
    /**
     * @OA\Property(
     *     title="user_id",
     *     description="user_id of the cart item",
     *     format="int64",
     *     example=1
     * )
     *
     * @var int
     */
    //private $user_id;

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

    public function getCourse()
    {
        //return 'hello';
        return $this->hasMany("App\Models\Course", 'id');
    }
}
