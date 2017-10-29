@extends('layouts.manage')

@section('content')
  <div class="flex-container">
    <div class="columns m-t-10">
      <div class="column">
        <h1 class="title">Create New Role</h1>
      </div>
    </div>
    <hr>
    <div class="columns">
      <div class="column">
        <form action="{{route('roles.store')}}" method="POST">
          {{csrf_field()}}
          <div class="field">
            <label for="display_name" class="label">Name:</label>
            <p class="control">
              <input type="text" class="input" name="display_name" id="display_name" value="{{old('display_name')}}" required>
            </p>
          </div>
          <div class="field">
            <label for="name" class="label">Slug:</label>
            <p class="control">
              <input type="text" class="input" name="name" id="name" value="{{old('name')}}" required>
            </p>
          </div>
          <div class="field">
            <label for="description" class="label">Description:</label>
            <p class="control">
              <input type="text" class="input" name="description" id="description" value="{{old('description')}}">
            </p>
          </div>
          <div class="field">
            <label for="permissions" class="label">Permissions:</label>
            @foreach($permissions as $permission)
              <div class="field">
                <b-checkbox v-model="permissionsSelected" :native-value="{{$permission->id}}">{{$permission->display_name}} <em>{{$permission->name}}</em></b-checkbox>
              </div>
            @endforeach
          </div>
          <input type="hidden" name="permissions" :value="permissionsSelected"/>
          <button class="button is-primary is-outlined m-t-0">Create Role</button>
        </form>
      </div>
    </div>
  </div> <!-- end of .flex-container -->
@endsection

@section('scripts')
  <script>
    const app = new Vue({
      el: '#app',
      data: {
        permissionsSelected: [],
      },
    });
  </script>
@endsection