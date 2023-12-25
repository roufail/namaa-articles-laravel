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


    <x-success-message />
    @if($comments->count())
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <tbody>
            <tr class="thead">
                <td scope="row" class="px-6 py-4">
                    {!! generateSortLink('admin.comments.index', 'article','Article') !!}
                </td>
                <td class="px-6 py-4">
                    {!! generateSortLink('admin.comments.index', 'user','User') !!}
                </td>
                <td class="px-6 py-4 bg-gray-50 dark:bg-gray-800 text-center">
                    {!! generateSortLink('admin.comments.index', 'approved','Approved') !!}
                </td>
                <td class="px-6 py-4">
                    {!! generateSortLink('admin.comments.index', 'created_at','Created') !!}
                </td>
                <td class="px-6 py-4">
                    {!! generateSortLink('admin.comments.index', 'title','Title') !!}
                </td>
                <td class="px-6 py-4 text-center">
                    Actions
                </td>

            </tr>

            @foreach($comments as $comment)
                <tr>
                <td scope="row" class="px-6 py-4">
                    {{ $comment->article ? $comment->article->title : '---' }}
                </td>
                <td class="px-6 py-4">
                    {{ $comment->user->name  }}
                </td>
                <td class="px-6 py-4 text-center">
                    {{ $comment->approved ? 'Approved' : 'Rejected'  }}
                </td>
                <td class="px-6 py-4 bg-gray-50 dark:bg-gray-800">
                    {{ $comment->created_at->format('M d Y') }}
                </td>
                <td data-toggle="tooltip" data-placement="top" class="px-6 py-4 bg-gray-50 dark:bg-gray-800" title="{{ $comment->content }}">
                    {{ $comment->title }}
                </td>
                <td class="px-6 py-4 flex justify-content-evenly">
                    @if(!$comment->approved)
                        @can('approve comment')
                        <a title="approve" href="{{ route('admin.comments.approve',['comment' => $comment])}}">
                            <i class="fa-regular fa-thumbs-up"></i>
                        </a>
                        @endcan
                    @else
                        @can('reject comment')
                        <a title="reject" href="{{ route('admin.comments.reject',['comment' => $comment])}}">
                            <i class="fa-solid fa-thumbs-down"></i>
                        </a>
                        @endcan
                    @endif

                    @can('delete comment')
                    <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="post">
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
    {{ $comments->links() }}
</div>

@else 
<p class="p-4">
    No comments created yet
</p>
@endif
</div>


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

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })


    </script>
    @endsection

    @push('javascript')
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    @endpush

</x-app-layout>