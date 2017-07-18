@extends('layouts.manage')

@section('content')
  <div class="flex-container">
    <div class="columns m-t-10">
      <div class="column">
        <h1 class="title">Manage Permissions</h1>
      </div>
      <div class="column">
        <a href="{{route('permissions.create')}}" class="button is-primary is-pulled-right"><i class="fa fa-unlock-alt m-r-10"></i> Create New Permission</a>
      </div>
    </div>
    <hr>

    <div class="card">
      <div class="card-content">
        <table class="table is-narrow">
          <thead>
          <tr>
            <th>id</th>
            <th>Name</th>
            <th>Slug</th>
            <th>Date Created</th>
            <th>Actions</th>
          </tr>
          </thead>

          <tbody>
          @foreach ($permissions as $permission)
            <tr>
              <th>{{$permission->id}}</th>
              <td>{{$permission->display_name}}</td>
              <td>{{$permission->name}}</td>
              <td>{{$permission->created_at->toFormattedDateString()}}</td>
              <td>
                <a href="{{route('permissions.show', $permission->id)}}"><i class="fa fa-eye"></i></a>
                <a href="{{route('permissions.edit', $permission->id)}}" class="m-l-10"><i class="fa fa-edit"></i></a>
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div> <!-- end of .card -->

  </div>
@endsection