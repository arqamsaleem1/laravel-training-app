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
                        <div class="tab-content w-full md:w-5/6">
                            <div>
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
                                <form action="{{route('courses.update')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="flex">
                                        <div class="addCourseform md:w-3/4">
                                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                                            <div class="heading font-bold text-2xl m-5 text-gray-800">Edit Course</div>
                                            <div class="editor mx-auto flex flex-col text-gray-800 border border-gray-300 p-4 shadow-lg max-w-2xl">
                                                <input type="text" name="title" class="title bg-gray-100 border border-gray-300 p-2 outline-none" spellcheck="false" placeholder="Title" value="{{ $course->title }}">
                                                @error('title')
                                                    <p class="text-red-700 font-light">{{ $message }}</p>
                                                @enderror
                                                <textarea name="description" class="description bg-gray-100 sec p-3 h-60 border border-gray-300 outline-none mt-4" spellcheck="false" placeholder="Describe everything about this course here">{{ $course->description }}</textarea>
                                                @error('description')
                                                    <p class="text-red-700 font-light">{{ $message }}</p>
                                                @enderror
                                                <input name="price" class="price bg-gray-100 border border-gray-300 p-2 mt-4 outline-none" spellcheck="false" placeholder="Price" type="text" value="{{ $course->price }}">
                                                @error('price')
                                                    <p class="text-red-700 font-light">{{ $message }}</p>
                                                @enderror
                                                <label for="author" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white mt-4">Select author</label>
                                                <select name="author" id="author" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ $course->author }}">
                                                    @foreach ($users as $user)
                                                        <option value="{{$user->id}}" 
                                                        @if ( $course->teacher == $user->id ) 
                                                            selected
                                                        @endif 
                                                        >
                                                        {{$user->name}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="buttons flex">
                                                    <div class="btn border border-indigo-500 p-1 px-4 font-semibold cursor-pointer text-gray-200 mt-4 ml-1 bg-indigo-500">
                                                        <input type="submit" name="course-submit" class="cursor-pointer" value="Update">
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
                                                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span></p>
                                                            <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG or GIF (MAX. 800x400px)</p>
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
                                                <select name="category" id="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mt-4" value="{{ $course->category_id }}">
                                                    @foreach ($cats as $cat)
                                                        <option value="{{$cat->id}}" 
                                                        @if ( $course->category_id == $cat->id ) 
                                                            selected
                                                        @endif 
                                                        >
                                                        {{$cat->name}}
                                                        </option>
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
    jQuery(function(){
        $('.course-form-sidebar .featured-image-input .file-not-selected').hide();
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
        });
    });
</script>