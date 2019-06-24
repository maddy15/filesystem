@extends('admin.layouts.default')

@section('admin.content')
   <h1 class="title">Users List</h1>

   <table class="table is-fullwidth">
       <thead>
           <tr>
               <th>Id</th>
               <th>Name</th>
               <th>Email</th>
               <th></th>
           </tr>
       </thead>
       <tbody>
           @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td><a href="{{ route('permissions.index',$user->id) }}">Edit Permission</a></td>
                </tr>
           @endforeach
       </tbody>
   </table>
@endsection