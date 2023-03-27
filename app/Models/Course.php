<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *
 *     title="Course",
 *     description="Course model",
 *     @OA\Xml(
 *         name="Course"
 *     )
 * )
 */
class Course extends Model
{
    use HasFactory;

    /**
     * @OA\Property(
     *     title="Id",
     *     description="Id of the course",
     *     format="int64",
     *     example=1
     * )
     *
     * @var int
     */
    //private $id;

    /**
     * @OA\Property(
     *      title="title",
     *      description="title of the new course",
     *      example="A nice course"
     * )
     *
     * @var string
     */
    //public $title;

    /**
     * @OA\Property(
     *      title="Slug",
     *      description="Slug of the new course",
     *      example="a-nice-course"
     * )
     *
     * @var string
     */
    //public $slug;

    /**
     * @OA\Property(
     *      title="Category ID",
     *      description="Category's id of the new course",
     *      format="int64",
     *      example=1
     * )
     *
     * @var int
     */
    //public $category_id;

    /**
     * @OA\Property(
     *      title="Price",
     *      description="Price of the new course",
     *      format="int64",
     *      example=1
     * )
     *
     * @var int
     */
    //public $price;

    /**
     * @OA\Property(
     *      title="Description",
     *      description="Description of the new course",
     *      example="This is new course's description"
     * )
     *
     * @var string
     */
    //public $description;

    /**
     * @OA\Property(
     *      title="Picture",
     *      description="Picture of the course",
     *      example=""
     * )
     *
     * @var string
     */
    //public $picture;

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
     *      title="Teacher",
     *      description="Teacher's id of the new course",
     *      format="int64",
     *      example=1
     * )
     *
     * @var int
     */
    //public $teacher;
    
    protected $fillable = [
        'title', 'slug', 'description', 'price', 'picture', 'category_id', 'role', 'teacher'
    ];
    public function teacher()
    {
        return $this->belongsTo("App\Models\User", 'id');
    }

    public function category()
    {
        return $this->belongsTo("App\Models\Category");
    }

    public function lessons()
    {
        return $this->hasMany("App\Models\Lesson");
    }

    public function lessonsSections()
    {
        return $this->hasMany("App\Models\LessonSection");
    }
}
