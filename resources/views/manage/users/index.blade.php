@extends('layouts.manage')

@section('content')
  <div class="flex-container">
    <div class="columns m-t-10">
      <div class="column">
        <h1 class="title">Manage Users</h1>
      </div>
      <div class="column">
        <a href="{{route('users.create')}}" class="button is-primary is-pulled-right"><i class="fa fa-user-plus m-r-10"></i> Create New User</a>
      </div>
    </div>
    <hr>

    <div class="card">
      <div class="card-content">
        <table class="table is-narrow m-b-0">
          <thead>
          <tr>
            <th>id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Date Created</th>
            <th>Actions</th>
          </tr>
          </thead>

          <tbody>
          @foreach ($users as $user)
            <tr>
              <th>{{$user->id}}</th>
              <td>{{$user->name}}</td>
              <td>{{$user->email}}</td>
              <td>{{$user->created_at->toFormattedDateString()}}</td>
              <td>
                <a href="{{route('users.show', $user->id)}}"><i class="fa fa-eye"></i></a>
                <a class="m-l-10" href="{{route('users.edit', $user->id)}}"><i class="fa fa-edit"></i></a>
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div> <!-- end of .card -->

    {{$users->links()}}
  </div>
@endsection