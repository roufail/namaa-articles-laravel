<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function checkUserPermissions($permissions,$object) {
        $result = false;
        if(gettype($permissions) == 'string') $permissions = [$permissions];
        if($object->user_id == auth()->user()->id && auth()->user()->can($permissions[0])) $result = true;
        if(isset($permissions[1]) && $object->user_id != auth()->user()->id && auth()->user()->can($permissions[1])) $result = true;
        return $result;
    }
}
