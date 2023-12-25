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
        <a href="{{ route('admin.roles.create')}}">
            {{ __('Create') }}
        </a>
    </div>
    <x-success-message />
    @if($roles->count())
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <tbody>
            <tr class="thead">
                <td scope="row" class="px-6 py-4">
                    Role
                </td>
                <td class="px-6 py-4 text-center">
                    Users count
                </td>
                <td class="px-6 py-4 text-center">
                    Actions
                </td>

            </tr>

            @foreach($roles as $role)
                <tr>
                <td scope="row" class="px-6 py-4">
                    {{ $role->name }}
                </td>
                <td class="px-6 py-4 text-center">
                    @if($role->users_count > 0)
                        <a href="{{ route('admin.role.users',['role' => $role])}}">
                          {{ $role->users_count }}
                        </a>
                    @else 
                        {{ $role->users_count }}
                    @endif
                </td>

                <td class="px-6 py-4 flex justify-content-evenly">
                    <a href="{{ route('admin.roles.edit',['role' => $role])}}">
                        <i class="fa-solid fa-edit"></i>
                    </a>

                    <form action="{{ route('admin.roles.destroy', $role->id) }}" method="post">
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
    {{ $roles->links() }}
</div>

@else 
<p class="p-4">
 No roles created yet  
 <a href="{{ route('admin.roles.create')}}">
    {{ __('create new role') }}
</a>

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
    </script>
    @endsection

</x-app-layout>