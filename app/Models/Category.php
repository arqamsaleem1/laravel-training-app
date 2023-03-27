<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *
 *     title="Category",
 *     description="Category model",
 *     @OA\Xml(
 *         name="Category"
 *     )
 * )
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent',
    ];

    /**
     * @OA\Property(
     *     title="Id",
     *     description="Id of the category",
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
     *      description="name of the new category",
     *      example="A nice category"
     * )
     *
     * @var string
     */
    //public $name;

    /**
     * @OA\Property(
     *      title="Slug",
     *      description="Slug of the new category",
     *      example="a-nice-category"
     * )
     *
     * @var string
     */
    //public $slug;

    /**
     * @OA\Property(
     *      title="Parent",
     *      description="Parent of the new category",
     *      format="int64",
     *      example=1
     * )
     *
     * @var int
     */
    //public $parent;

    /**
     * @OA\Property(
     *      title="Description",
     *      description="Description of the new category",
     *      example="This is new category's description"
     * )
     *
     * @var string
     */
    //public $description;

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

    public function courses()
    {
        return $this->hasMany("App\Models\Course");
    }
}
