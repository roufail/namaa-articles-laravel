<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="text-left bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                
                    <x-validation-pulk-error />


                    <!-- table --> 
                    <div class="w-full">
                        <div>{{  $article->id ? 'Edit article' : 'New article' }}</div>
                        <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" method="post" action="{{ $article->id ? route('admin.articles.update', ['article' => $article]) : route('admin.articles.store') }}" >
                            @csrf
                            @if($article->id)
                                @method('PATCH')
                            @endif
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                            title
                            </label>
                            <input name="title" value="{{old('title') ? old('title') : $article->title}}" title="title" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="title" type="text" placeholder="title">
                            <x-validation-single-error input="title" />
                        </div>


                        

                        <div id="container" class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                             Content
                            </label>
                            <textarea name="content">
                                {{ old('content') ? old('content') : $article->content }}
                            </textarea>
                        <x-validation-single-error input="content" />
                        </div>


                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="excerpt">
                            excerpt
                            </label>
                            <input name="excerpt" value="{{old('excerpt') ? old('excerpt') : $article->excerpt}}" excerpt="excerpt" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="excerpt" type="text" placeholder="excerpt">
                            <x-validation-single-error input="excerpt" />
                        </div>



                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="meta_data">
                                Meta data
                            </label>
                            <input name="meta_data" class=" appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="meta_data" type="meta_data" placeholder="meta data">
                            <x-validation-single-error input="meta_data" />


                        </div>

                        <div class="md:flex md:items-center">
                            <div class="md:w-2/3">
                              <button class="bg-purple-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-black font-bold py-2 px-4 rounded" type="submit">
                                Save
                              </button>
                              <button class="bg-purple-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-black font-bold py-2 px-4 rounded" type="reset">
                                Reset
                              </button>

                          

                          
                                    
                            </div>
                         </div>

                          
                        </form>


                    <div class="row">
                      <div class="col-1">
                        @if(!$article->approved)
                        @can('approve article')
                        <a href="{{ route('admin.articles.approve',['article' => $article])}}">
                            {{ __('Approve') }}
                        </a>
                        @endcan
                    @else
                        @can('reject article')
                        <a href="{{ route('admin.articles.reject',['article' => $article])}}">
                            {{ __('Reject') }}
                        </a>
                        @endcan
                    @endif


                      </div>  

                      <div class="col-1">
                        @can('delete article')
                        <form action="{{ route('admin.articles.destroy', $article->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <a href="#" class="ml-3"  title="Delete" data-toggle="tooltip" onclick="confirm_deletion(this)">
                                {{ __('Delete') }}
    
                            </a>
                        </form>
                        @endcan
    
                      </div>


                    </div>    
    
    

                    </div>  
                    <!-- end of table -->

                
                </div>
            </div>
        </div>
    </div>

    @push('javascript')
    <script src="https://cdn.tiny.cloud/1/f0uvypdsenpfgxee2okvevs5v434dh4c6s8fj9zljtq09pw2/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    @endpush


    @section('extra-js')
    <script>
        tinymce.init({
          selector: 'textarea',
          plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
          toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        });

        function confirm_deletion(e){
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                if (result.isConfirmed) {
                    e.closest('form').submit();return false;
                }
                });

        }


        
      </script>
    @endsection


    @section('extra-css')
    <style>
    .text-left {
        text-align: left !important;
    }


            #container {
                margin: 20px auto;
            }
            .ck-editor__editable[role="textbox"] {
                /* editing area */
                min-height: 200px;
            }
            .ck-content .image {
                /* block images */
                max-width: 80%;
                margin: 20px auto;
            }


     </style>

    @endsection

</x-app-layout>