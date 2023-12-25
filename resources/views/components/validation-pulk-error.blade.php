@if($errors->any())
<div role="alert">
    <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
        Validations Errors
    </div>
    @foreach ($errors->all() as $error)
    <div>
        <p>*{{ $error }}</p>
    </div>
    @endforeach
    </div>
@endif
