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
                        <div>{{  $user->id ? 'Edit user' : 'New user' }}</div>
                        <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" method="post" action="{{ $user->id ? route('admin.users.update', ['user' => $user]) : route('admin.users.store') }}" >
                            @csrf
                            @if($user->id)
                                @method('PATCH')
                            @endif
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                            Name
                            </label>
                            <input value="{{old('name') ? old('name') : $user->name}}" name="name" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" placeholder="name">
                            <x-validation-single-error input="name" />
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                            Email
                            </label>
                            <input  value="{{ old('email') ? old('email') : $user->email }}" name="email" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="text" placeholder="email">
                            <x-validation-single-error input="email" />
                        </div>

                        @can('change user role')
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="role">
                                Role
                            </label>
                            <select name="role" id="role" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected value="">Select Role</option>
                                @foreach ($roles as $role)
                                    <option @if(!empty($user->roles->pluck('name')[0]) && $user->roles->pluck('name')[0] == $role) selected @endif value="{{$role}}">{{ $role }}</option>
                                @endforeach
                              </select>
                              

                            {{-- <input  value="{{ old('role') ? old('role') : $user->role }}" name="role" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="role" type="text" placeholder="role"> --}}
                            <x-validation-single-error input="role" />
                        </div>
                        @endcan

                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                            Password
                            </label>
                            <input name="password" class=" appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="******************">
                            <x-validation-single-error input="password" />
                        </div>

                        <div class="md:flex md:items-center">
                            <div class="md:w-2/3">
                              <button class="bg-gray-500 focus:shadow-outline focus:outline-none text-black font-bold py-2 px-4 rounded" type="submit">
                                Save
                              </button>
                              <button class="bg-gray-500 focus:shadow-outline focus:outline-none text-black font-bold py-2 px-4 rounded" type="reset">
                                Reset
                              </button>
                            </div>
                         </div>

                          
                        </form>
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

</x-app-layout>