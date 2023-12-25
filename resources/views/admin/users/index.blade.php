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
        <a href="{{ route('admin.users.create')}}">
            {{ __('Create') }}
        </a>
    </div>
    <x-success-message />
    @if($users->count())
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <tbody>
            <tr class="thead">
                <td scope="row" class="px-6 py-4">
                    Name
                </td>
                <td class="px-6 py-4">
                    Email
                </td>
                <td class="px-6 py-4">
                    Role
                </td>

                <td class="px-6 py-4 bg-gray-50 dark:bg-gray-800">
                    Registration data
                </td>
                <td class="px-6 py-4 text-center">
                    Articles Count
                </td>

                <td class="px-6 py-4">
                    Actions
                </td>

            </tr>

            @foreach($users as $user)
                <tr>
                <td scope="row" class="px-6 py-4">
                    {{ $user->name }}
                </td>
                <td class="px-6 py-4">
                    {{ $user->email }}
                </td>
                <td class="px-6 py-4">
                    @if(isset($user->roles[0]))
                    <a href="{{ route('admin.role.users',['role' => $user->roles[0]->id])}}">
                        {{ $user->roles[0]->name }}
                      </a>
                    @else
                      ------
                    @endif
                </td>

                <td class="px-6 py-4 bg-gray-50 dark:bg-gray-800">
                    {{ $user->created_at->format('M d Y') }}
                </td>
                <td class="px-6 py-4 text-center">
                    @if($user->articles_count > 0)
                        <a href="{{ route('admin.user.articles',['user' => $user])}}">
                          {{ $user->articles_count }}
                        </a>
                    @else 
                          {{ $user->articles_count }}
                @endif
                </td>

                <td class="px-6 py-4 flex justify-content-evenly">
                    <a href="{{ route('admin.users.edit',['user' => $user])}}">
                        <i class="fa-solid fa-edit"></i>
                    </a>

                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <a href="#"  title="Delete" data-toggle="tooltip" onclick="confirm_deletion(this)">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </form>

             
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
<div class="p-5">
    {{ $users->links() }}
</div>

@else 
No users created yet
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
    </script>
    @endsection

</x-app-layout>