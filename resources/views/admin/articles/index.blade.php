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
                    
                


<!-- table --> 
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">

    <div class="text-right m-2">
        <a href="{{ route('admin.articles.create')}}">
            {{ __('Create') }}
        </a>
    </div>
    <x-success-message />
    @if($articles->count())
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <tbody>
            <tr class="thead">
                <td scope="row" class="px-6 py-4">
                    <span class="sort ml-1">
                        <!-- function to generate sort url in helpers -->
                        {!! generateSortLink('admin.articles.index', 'title', 'Title') !!}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <span class="sort ml-1">
                        <!-- function to generate sort url in helpers -->
                        {!! generateSortLink('admin.articles.index', 'user','User') !!}
                    </span>

                </td>
                <td class="px-6 py-4 text-center">
                    {!! generateSortLink('admin.articles.index', 'approved','Approved') !!}
                </td>
                <td class="px-6 py-4">
                    {!! generateSortLink('admin.articles.index', 'created_at','Created') !!}
                </td>

                <td class="px-6 py-4 text-center">
                    Actions
                </td>

            </tr>

            @foreach($articles as $article)
                <tr>
                <td scope="row" class="px-6 py-4">
                    {{ $article->title }}
                </td>
                <td class="px-6 py-4">

                    <a href="{{ route('admin.user.articles',['user' => $article->user])}}">
                        {{ $article->user->name }}
                    </a>
                </td>

                <td class="px-6 py-4 text-center">
                    {{ $article->approved ? 'yes' : 'no' }}
                </td>
                <td class="px-6 py-4 bg-gray-50 dark:bg-gray-800">
                    {{ $article->created_at->format('M d Y') }}
                </td>
  
                <td class="px-6 py-4 flex justify-content-evenly">
                    <a target="_blank" href="{{ route('portal.article',['article' => $article])}}">
                        <i class="fa-regular fa-eye"></i>
                    </a>

                    @can('edit article')
                    <a href="{{ route('admin.articles.edit',['article' => $article])}}">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                    @endcan
                    @can('delete article')
                    <form action="{{ route('admin.articles.destroy', $article->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <a href="#"  title="Delete" data-toggle="tooltip" onclick="confirm_deletion(this)">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </form>
                    @endcan

             
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="p-5">
        {{ $articles->links() }}
    </div>
</div>
@else 
    <p class="p-5">No articles added yet  <a href="{{ route('admin.articles.create')}}">
        {{ __('create new article') }}
    </a>
</p>
@endif
<!-- end of table -->



                
                </div>
            </div>
        </div>
    </div>

    @section('extra-css')
    <style>
    .text-left {
        text-align: left !important;
    }
     </style>
    @endsection
    
    @section('extra-js')
     <script>
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

</x-app-layout>