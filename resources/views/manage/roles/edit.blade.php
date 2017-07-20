@extends('layouts.manage')

@section('content')
  <div class="flex-container">
    <div class="columns m-t-10">
      <div class="column">
        <h1 class="title">Edit Role</h1>
      </div>
    </div>
    <hr>
    <div class="columns">
      <div class="column">
        <form action="{{route('roles.update', $role->id)}}" method="POST">
          {{csrf_field()}}
          {{method_field('PUT')}}
          <div class="field">
            <label for="display_name" class="label">Name:</label>
            <p class="control">
              <input type="text" class="input" name="display_name" id="display_name" value="{{$role->display_name}}" required>
            </p>
          </div>
          <div class="field">
            <label for="name" class="label">Slug (Can not be edited)</label>
            <p class="control">
              <input type="text" class="input" name="name" id="name" value="{{$role->name}}" disabled>
            </p>
          </div>
          <div class="field">
            <label for="description" class="label">Description:</label>
            <p class="control">
              <input type="text" class="input" name="description" id="description" value="{{$role->description}}">
            </p>
          </div>
          <div class="field">
            <label for="permissions" class="label">Permissions:</label>
            <b-checkbox-group id="permissions" v-model="permissionsSelected">
              @foreach($permissions as $permission)
                <div class="field">
                  <b-checkbox :custom-value="{{$permission->id}}">{{$permission->display_name}} <em>{{$permission->name}}</em></b-checkbox>
                </div>
              @endforeach
            </b-checkbox-group>
          </div>
          <input type="hidden" name="permissions" :value="permissionsSelected"/>
          <button class="button is-primary is-outlined">Edit Role</button>
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
        permissionsSelected: {!!$role->permissions->pluck('id')!!},
      },
    });
  </script>
@endsection