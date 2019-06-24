@extends('admin.layouts.default')

@section('admin.content')
  
<form action="{{ route('permissions.store',$user) }}" method="POST" id="form1">
    @csrf
    <div class="container">
        <h1 class="title">Users Permission</h1>
        <hr>
        <br>
        <div class="columns">

            <div class="column">
                <h3 class="title">Files Permission</h3>
                <div class="field">
                    <p class="control">
                        <label for="all" class="checkbox">
                            <input 
                            type="checkbox"  id="all" >All
                        </label>
                    </p>
                </div>
                @foreach($permissions as $permission)
                    <div class="field">
                        <p class="control">
                            <label for="{{ $permission->name }}" class="checkbox">
                                <input 
                                type="checkbox" 
                                name="permission[]" 
                                id="{{ $permission->name }}"
                                value={{ $permission->id }}
                                class="permission_check"
                                {{ in_array($permission->id,$users_permission) ? 'checked' : '' }}>
                                    {{ strtoupper($permission->name) }}
                            </label>
                        </p>
                    </div>
                @endforeach
            </div>

            <div class="column">
                <h3 class="title">Roles</h3>
                @foreach($roles as $role)
                    <div class="field">
                        <p class="control">
                            <label for="{{ $role->name }}" class="checkbox">
                                <input 
                                type="checkbox" 
                                name="role" 
                                id="{{ $role->name }}"
                                value={{ $role->id }}
                                {{ in_array($role->id,$users_role) ? 'checked' : '' }}>
                                    {{ strtoupper($role->name) }}
                            </label>
                        </p>
                    </div>
                @endforeach
            </div>

        </div>

        <button class="button is-primary" type="submit">Add Permission</button>
    </div>
</form>
   
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            $('#all').click(()=>{
                let check = $('#all').val();

                window.alert(check);
            });
            
        });
    </script>
@endsection