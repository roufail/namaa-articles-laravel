<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Role') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="text-left bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                
                    <x-validation-pulk-error />


                    <!-- table --> 
                    <div class="w-full max-w-xs">
                        <div>{{  $role->id ? 'Edit role' : 'New role' }}</div>
                        <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" method="post" action="{{ $role->id ? route('admin.roles.update', ['role' => $role]) : route('admin.roles.store') }}" >
                            @csrf
                            @if($role->id)
                                @method('PATCH')
                            @endif
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                            Name
                            </label>
                            <input value="{{old('name') ? old('name') : $role->name}}" name="name" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="role" type="text" placeholder="role">
                            <x-validation-single-error input="name" />
                        </div>

                        <div class="mb-4">
                            Permissions
                             <fieldset>
                                <legend>Articles:</legend>
                                <ul>
                                    <li>
                                        <label>
                                            Show article <input type="checkbox" @if(in_array('show article',$permissions)) checked @endif name="permissions[show article]">
                                        </label>        
                                    </li>
                                    <li>
                                        <label>
                                            Create article <input type="checkbox" @if(in_array('create article',$permissions)) checked @endif name="permissions[create article]">
                                        </label>        
                                    </li>
                                    <li>
                                        <label>
                                            Edit article <input type="checkbox" @if(in_array('edit article',$permissions)) checked @endif name="permissions[edit article]">
                                        </label>        
                                    </li>
                                    <li>
                                        <label>
                                            Delete article <input type="checkbox" @if(in_array('delete article',$permissions)) checked @endif name="permissions[delete article]">
                                        </label>        
                                    </li>

                                    <li>
                                        <label>
                                            Approve article <input type="checkbox" @if(in_array('approve article',$permissions)) checked @endif name="permissions[approve article]">
                                        </label>        
                                    </li>

                                    <li>
                                        <label>
                                            Reject article <input type="checkbox" @if(in_array('reject article',$permissions)) checked @endif name="permissions[reject article]">
                                        </label>        
                                    </li>

                                    <li>
                                        <label>
                                            Show others articles <input type="checkbox" @if(in_array('show others articles',$permissions)) checked @endif name="permissions[show others articles]">
                                        </label>        
                                    </li>
                                    <li>
                                        <label>
                                            Edit others articles <input type="checkbox" @if(in_array('edit others articles',$permissions)) checked @endif name="permissions[edit others articles]">
                                        </label>        
                                    </li>
                                    <li>
                                        <label>
                                            Delete others articles <input type="checkbox" @if(in_array('delete others articles',$permissions)) checked @endif name="permissions[delete others articles]">
                                        </label>        
                                    </li>


                                    <li>
                                        <label>
                                            Approve others articles <input type="checkbox" @if(in_array('approve others articles',$permissions)) checked @endif name="permissions[approve others articles]">
                                        </label>        
                                    </li>

                                    <li>
                                        <label>
                                            Reject others articles <input type="checkbox" @if(in_array('reject others articles',$permissions)) checked @endif name="permissions[reject others articles]">
                                        </label>        
                                    </li>
                                </ul>
                             </fieldset>
                             <br />
                             <fieldset>
                                <legend>Comments:</legend>
                                <ul>
                                    <li>
                                        <label>
                                            Can comment <input type="checkbox" @if(in_array('can comment',$permissions)) checked @endif name="permissions[can comment]">
                                        </label>        
                                    </li>

                                    <li>
                                        <label>
                                            Show comment <input type="checkbox" @if(in_array('show comment',$permissions)) checked @endif name="permissions[show comment]">
                                        </label>        
                                    </li>

                                    <li>
                                        <label>
                                            Create comment <input type="checkbox" @if(in_array('create comment',$permissions)) checked @endif name="permissions[create comment]">
                                        </label>        
                                    </li>
                                    <li>
                                        <label>
                                            Edit comment <input type="checkbox" @if(in_array('edit comment',$permissions)) checked @endif name="permissions[edit comment]">
                                        </label>        
                                    </li>
                                    <li>
                                        <label>
                                            Delete comment <input type="checkbox" @if(in_array('delete comment',$permissions)) checked @endif name="permissions[delete comment]">
                                        </label>        
                                    </li>
                                    <li>
                                        <label>
                                            Approve comment <input type="checkbox" @if(in_array('approve comment',$permissions)) checked @endif name="permissions[approve comment]">
                                        </label>        
                                    </li>

                                    <li>
                                        <label>
                                            Reject comment <input type="checkbox" @if(in_array('reject comment',$permissions)) checked @endif name="permissions[reject comment]">
                                        </label>        
                                    </li>


                                    <li>
                                        <label>
                                            Show others comments <input type="checkbox" @if(in_array('show others comments',$permissions)) checked @endif name="permissions[show others comments]">
                                        </label>        
                                    </li>
                                    <li>
                                        <label>
                                            Edit others comments <input type="checkbox" @if(in_array('edit others comments',$permissions)) checked @endif name="permissions[edit others comments]">
                                        </label>        
                                    </li>
                                    <li>
                                        <label>
                                            Delete others comments <input type="checkbox" @if(in_array('delete others comments',$permissions)) checked @endif name="permissions[delete others comments]">
                                        </label>        
                                    </li>


                                    <li>
                                        <label>
                                            Approve others comments <input type="checkbox" @if(in_array('approve others comments',$permissions)) checked @endif name="permissions[approve others comments]">
                                        </label>        
                                    </li>

                                    <li>
                                        <label>
                                            Reject others comments <input type="checkbox" @if(in_array('reject others comments',$permissions)) checked @endif name="permissions[reject others comments]">
                                        </label>        
                                    </li>


                                </ul>
                             </fieldset>


                             <br />
                             <fieldset>
                                <legend>Users:</legend>
                                <ul>
                                    <li>
                                        <label>
                                            Show user <input type="checkbox" @if(in_array('show user',$permissions)) checked @endif name="permissions[show user]">
                                        </label>        
                                    </li>
                                    <li>
                                        <label>
                                            Create user <input type="checkbox" @if(in_array('create user',$permissions)) checked @endif name="permissions[create user]">
                                        </label>        
                                    </li>
                                    <li>
                                        <label>
                                            Edit user <input type="checkbox" @if(in_array('edit user',$permissions)) checked @endif name="permissions[edit user]">
                                        </label>        
                                    </li>
                                </ul>                             <ul>
                                    <li>
                                        <label>
                                            Delete user <input type="checkbox" @if(in_array('delete user',$permissions)) checked @endif name="permissions[delete user]">
                                        </label>        
                                    </li>
                                </ul>
                             </fieldset>


                             <br />
                             <fieldset>
                                <legend>Roles:</legend>
                                <ul>
                                    <li>
                                        <label>
                                            Show role <input type="checkbox" @if(in_array('show role',$permissions)) checked @endif name="permissions[show role]">
                                        </label>        
                                    </li>
                                    <li>
                                        <label>
                                            Create role <input type="checkbox" @if(in_array('create role',$permissions)) checked @endif name="permissions[create role]">
                                        </label>        
                                    </li>
                                    <li>
                                        <label>
                                            Edit role <input type="checkbox" @if(in_array('edit role',$permissions)) checked @endif name="permissions[edit role]">
                                        </label>        
                                    </li>
                                    <li>
                                        <label>
                                            Delete role <input type="checkbox" @if(in_array('delete role',$permissions)) checked @endif name="permissions[delete role]">
                                        </label>        
                                    </li>
                                    <li>
                                        <label>
                                            Change user role <input type="checkbox" @if(in_array('change user role',$permissions)) checked @endif name="permissions[change user role]">
                                        </label>        
                                    </li>

                                </ul>
                             </fieldset>




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