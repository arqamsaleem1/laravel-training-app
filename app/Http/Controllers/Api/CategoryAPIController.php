<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class CategoryAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *      path="/api/categories",
     *      operationId="getCategoriesList",
     *      tags={"Categories"},
     *      summary="Get list of categories",
     *      description="Returns list of categories",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Category")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function index()
    {
        $cats = Category::paginate(10);

        return response()->json($cats);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Post(
     *      path="/api/categories",
     *      operationId="storeCategory",
     *      tags={"Categories"},
     *      summary="Store new category",
     *      description="Returns category data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Category")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Category")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories',
            'description' => 'required',
        ]);

        $category = new Category;
        $data = $request->all();
        $data['slug'] = str_slug($data['name']);
        $is_exists = Category::where('slug', $data['slug'])->exists();
        if (! $is_exists) {
            // code...
            /* $category->name = $data['name'];
            $category->slug = $data['slug'];
            $category->description = $data['description'];
            $category->parent = ($data['parent']) ? $data['parent'] : null; */
            //return $category->description;

            //$saveCategory = $category->save();
            $saveCategory = $category->create($data);

            return response()->json($saveCategory);
        } else {
            return response()->json(['error' => 'Category slug already exists!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *      path="/api/categories/{id}",
     *      operationId="getCategoryById",
     *      tags={"Categories"},
     *      summary="Get category information",
     *      description="Returns category data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Category id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Category")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function show($id)
    {
        $category = new Category;
        $current_cat = $category->find($id);

        return response()->json($current_cat);
    }

      /**
       * Update the specified resource in storage.
       *
       * @param  \Illuminate\Http\Request  $request
       * @param  \App\Models\Category  $category
       * @return \Illuminate\Http\Response
       */
      /**
       * @OA\Put(
       *      path="/api/categories/{id}",
       *      operationId="updateCategory",
       *      tags={"Categories"},
       *      summary="Update existing Category",
       *      description="Returns updated Category data",
       *      @OA\Parameter(
       *          name="id",
       *          description="Category id",
       *          required=true,
       *          in="path",
       *          @OA\Schema(
       *              type="integer"
       *          )
       *      ),
       *      @OA\RequestBody(
       *          required=true,
       *          @OA\JsonContent(ref="#/components/schemas/Category")
       *      ),
       *      @OA\Response(
       *          response=202,
       *          description="Successful operation",
       *          @OA\JsonContent(ref="#/components/schemas/Category")
       *       ),
       *      @OA\Response(
       *          response=400,
       *          description="Bad Request"
       *      ),
       *      @OA\Response(
       *          response=401,
       *          description="Unauthenticated",
       *      ),
       *      @OA\Response(
       *          response=403,
       *          description="Forbidden"
       *      ),
       *      @OA\Response(
       *          response=404,
       *          description="Resource Not Found"
       *      )
       * )
       */
      public function update(Request $request, $id)
      {
          $request->validate([
              'name' => 'required',
              'description' => 'required',
          ]);

          $Category = new Category;
          $data = $request->all();
          $data['slug'] = str_slug($data['name']);
          $current_category = Category::find($id);
          $is_exists = Category::where('slug', $data['slug'])->exists();
          
          if ($is_exists) {
            return response()->json(['error' => 'Category slug already exists!']);
          }

          if ($current_category) {
              // code...
              $saveCategory = $current_category->update($data);
              return response()->json($saveCategory);
              
          } else {
              return response()->json(['error' => 'Course not exists!']);
          }
      }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Delete(
     *      path="/api/categories/{id}",
     *      operationId="deleteCategory",
     *      tags={"Categories"},
     *      summary="Delete existing category",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Category id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function destroy($category_id)
    {
        $category = Category::find($category_id);

        if (! is_null($category)) {
            $deleted_category = $category->delete();

            return response()->json($deleted_category);
        } else {
            return false;
        }
    }
}
