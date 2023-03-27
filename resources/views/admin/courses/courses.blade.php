<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Courses') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-start">
                        <ul class="nav nav-tabs flex flex-col flex-wrap w-full md:w-1/6 list-none border-b-0 pl-0 mr-4" 
                            id="tabs-tabVertical"
                            role="tablist"
                            data-te-nav-ref>
                            <li role="presentation" class="nav-item flex-grow">
                            <a href="#tabs-allCoursesVertical" class="
                                nav-link
                                block
                                font-medium
                                text-xs
                                leading-tight
                                uppercase
                                border-x-0 border-t-0 border-b-2 border-transparent
                                px-6
                                py-3
                                my-2
                                hover:border-transparent hover:bg-gray-100
                                focus:border-transparent
                                active
                                " id="tabs-allCourses-tabVertical" 
                                data-te-toggle="pill" 
                                data-te-target="#tabs-allCoursesVertical" 
                                role="tab"
                                aria-controls="tabs-allCoursesVertical" 
                                aria-selected="true">All Courses</a>
                            </li>
                            <li class="nav-item flex-grow" role="presentation">
                            <a href="#tabs-addNewVertical" class="
                                nav-link
                                block
                                font-medium
                                text-xs
                                leading-tight
                                uppercase
                                border-x-0 border-t-0 border-b-2 border-transparent
                                px-6
                                py-3
                                my-2
                                hover:border-transparent hover:bg-gray-100
                                focus:border-transparent
                                " id="tabs-addNew-tabVertical" 
                                data-te-toggle="pill" 
                                data-te-target="#tabs-addNewVertical" role="tab"
                                aria-controls="tabs-addNewVertical" 
                                aria-selected="false">Add New</a>
                            </li>
                        </ul>
                        <div class="tab-content w-full md:w-5/6" id="tabs-tabContentVertical">
                            <div class="tab-pane fade show active" id="tabs-allCoursesVertical" role="tabpanel"
                            aria-labelledby="tabs-allCourses-tabVertical">
                                <div class="all-courses-listing"> 
                                    <div class="heading font-bold text-2xl m-5 text-gray-800">All Courses</div>
                                        
                                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                <tr>
                                                    <th scope="col" class="p-4">
                                                        <div class="flex items-center">
                                                            <input id="checkbox-all-search" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                            <label for="checkbox-all-search" class="sr-only">checkbox</label>
                                                        </div>
                                                    </th>
                                                    <th scope="col" class="px-6 py-3">
                                                        Course name
                                                    </th>
                                                    <th scope="col" class="px-6 py-3">
                                                        Author
                                                    </th>
                                                    <th scope="col" class="px-6 py-3">
                                                        Category
                                                    </th>
                                                    <th scope="col" class="px-6 py-3">
                                                        Price
                                                    </th>
                                                    <th scope="col" class="px-6 py-3">
                                                        Action
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                                @foreach ($courses as $course)
                                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                    <td class="w-4 p-4">
                                                        <div class="flex items-center">
                                                            <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                            <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                                        </div>
                                                    </td>
                                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                        {{ $course['title']}}
                                                    </th>
                                                    <td class="px-6 py-4">
                                                        {{ $course['teacher']}}
                                                        <?php 
                                                            //print_r(array_search($course['teacher, $users)']);
                                                            //print_r($users);
                                                        ?>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $course['category_id']}}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $course['price']}}
                                                    </td>
                                                    <td class="flex items-center px-6 py-4 space-x-3">
                                                        <a href="{{ route('admin.courses.edit', ['course_slug'=> $course['slug'] ]) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                                        <a href="{{ route('courses.delete', ['course_id'=> $course->id ]) }}" class="font-medium text-red-600 dark:text-red-500 hover:underline">Remove</a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="items-center pt-4 m-4">
                                            {{$courses->links()}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tabs-addNewVertical" role="tabpanel" aria-labelledby="tabs-addNew-tabVertical">
                            @if (Session::has('success'))
                                <div class="w-full max-w-lg m-5 alert alert-success alert alert-success bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md">
                                    <p>{{ Session::get('success') }}</p>
                                    {{Session::forget('success');}}
                                </div>
                            @endif
                            @if (Session::has('error'))
                                <div class=" m-5 bg-red-500 text-white font-bold rounded-t px-4 py-2">
                                    <p>{{ Session::get('error') }}</p>
                                    {{Session::forget('error');}}
                                </div>
                            @endif
                                <form action="/course" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="flex">
                                        <div class="addCourseform md:w-3/4">
                                            <div class="heading font-bold text-2xl m-5 text-gray-800">Add New Course</div>
                                            <div class="editor mx-auto flex flex-col text-gray-800 border border-gray-300 p-4 shadow-lg max-w-2xl">
                                                <input type="text" name="title" class="title bg-gray-100 border border-gray-300 p-2 outline-none" spellcheck="false" placeholder="Title" type="text" value="{{ old('title') }}">
                                                @error('title')
                                                    <p class="text-red-700 font-light">{{ $message }}</p>
                                                @enderror
                                                <textarea name="description" class="description bg-gray-100 sec p-3 h-60 border border-gray-300 outline-none mt-4" spellcheck="false" placeholder="Describe everything about this course here">{{ old('description') }}</textarea>
                                                @error('description')
                                                    <p class="text-red-700 font-light">{{ $message }}</p>
                                                @enderror
                                                <input name="price" class="price bg-gray-100 border border-gray-300 p-2 mt-4 outline-none" spellcheck="false" placeholder="Price" type="text" value="{{ old('price') }}">
                                                @error('price')
                                                    <p class="text-red-700 font-light">{{ $message }}</p>
                                                @enderror
                                                <label for="author" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white mt-4">Select author</label>
                                                <select name="author" id="author" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ old('author') }}">
                                                    @foreach ($users as $user)
                                                        <option value="{{$user->id}}" 
                                                        @if ( auth()->user()->id == $user->id ) 
                                                            selected
                                                        @endif 
                                                        >
                                                        {{$user->name}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <!-- icons -->
                                                <!-- <div class="icons flex text-gray-500 m-2">
                                                <svg class="mr-2 cursor-pointer hover:text-gray-700 border rounded-full p-1 h-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                                <svg class="mr-2 cursor-pointer hover:text-gray-700 border rounded-full p-1 h-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                <svg class="mr-2 cursor-pointer hover:text-gray-700 border rounded-full p-1 h-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg>
                                                <div class="count ml-auto text-gray-400 text-xs font-semibold">0/300</div>
                                                </div> -->
                                                <!-- buttons -->
                                                <div class="buttons flex">
                                                    <div class="btn border border-indigo-500 p-1 px-4 font-semibold cursor-pointer text-gray-200 mt-4 ml-1 bg-indigo-500">
                                                        <input type="submit" name="course-submit" class="cursor-pointer" value="Publish">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="course-form-sidebar md:w-1/4">
                                            <div class="featured-image-input mt-10">
                                                <div class="flex items-center justify-center w-full">
                                                    <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                            <svg aria-hidden="true" class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                                            <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                                                        </div>
                                                        <input name="dropzone-file" id="dropzone-file" type="file" class="hidden" />
                                                    </label>
                                                </div> 
                                                @error('dropzone-file')
                                                    <p class="text-red-700 font-light">{{ $message }}</p>
                                                @enderror
                                                <p class="text-red-700 font-light file-not-selected">Image not selected</p>
                                                <p class="text-green-700 font-light file-selected">Image is selected</p>
                                            </div>
                                            <div class="category-selector">
                                                <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white mt-4">Select category</label>
                                                <select name="category" id="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mt-4" value="{{ old('category') }}">
                                                    @foreach ($cats as $cat)
                                                        <option value="{{$cat->id}}">{{$cat->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    jQuery(function() {
        /* let tab = location.hash;
        if (tab) {
            jQuery(tab)[0].click();
        } */

        /* $('.course-form-sidebar .featured-image-input .file-not-selected').hide();
        $('.course-form-sidebar .featured-image-input .file-selected').hide();
        $('#dropzone-file').change(function( e ){
            if( document.getElementById("dropzone-file").files.length == 0 ){
                $('.course-form-sidebar .featured-image-input .file-not-selected').show();
                $('.course-form-sidebar .featured-image-input .file-selected').hide();
                console.log("no files selected");
            }
            else{
                $('.course-form-sidebar .featured-image-input .file-not-selected').hide();
                $('.course-form-sidebar .featured-image-input .file-selected').show();
            }
        }); */
    });
</script>
