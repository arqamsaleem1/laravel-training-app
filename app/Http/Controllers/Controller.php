<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Training App API Documentation",
 *      description="This documentation describes all of the API endpoints for the Training App",
 *      @OA\Contact(
 *          email="arqamsaleem@gmail.com"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 */
class Controller extends BaseController
{
    /**
     * @OA\Server(
     *      url=L5_SWAGGER_CONST_HOST,
     *      description="Demo API Server"
     * )

     * @OA\Tag(
     *     name="courses",
     *     description="API Endpoints of Projects"
     * )
     */
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
