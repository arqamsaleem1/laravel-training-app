<?php

namespace App\Http\Controllers;

use App\Models\Category;

class HomeController extends Controller
{
    public function renderHomePage()
    {
        $category = new Category;

        $development_courses = $category->find(1)->courses()->get();
        $business_courses = $category->find(2)->courses()->get();
        $web_development_courses = $category->where('slug', '=', 'web-development')->first()->courses()->get();
        //dd($web_development_courses);
        return view('homepage', [
            'development_courses' => (object) $development_courses,
            'business_courses' => (object) $business_courses,
            'web_development_courses' => (object) $web_development_courses,
        ]);
        //return view('welcome');
    }
}
