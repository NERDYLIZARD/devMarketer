@extends('layouts.manage')

@section('content')
  <div class="flex-container">
    <div class="columns m-t-10">
      <div class="column">
        <h1 class="title">Create New User</h1>
      </div>
    </div>
    <hr>
    <div class="columns">
      <div class="column">
        <form action="{{route('users.store')}}" method="POST">
          {{csrf_field()}}
          <div class="field">
            <label for="name" class="label">Name</label>
            <p class="control">
              <input type="text" class="input" name="name" id="name" required>
            </p>
          </div>
          <div class="field">
            <label for="email" class="label">Email:</label>
            <p class="control">
              <input type="text" class="input" name="email" id="email" required>
            </p>
          </div>

          <div class="columns">
            <div class="column">
              <div class="field">
                <label for="password" class="label">Password</label>
                <p class="control">
                  <input type="password" class="input m-b-15" name="password" id="password" v-if="!auto_password" placeholder="Manually give a password to this user" required>
                  <b-checkbox name="auto_generate" v-model="auto_password">Auto Generate Password</b-checkbox>
                </p>
              </div>
            </div>
            <div class="column">
              <div class="field">
                <label class="label">Roles:</label>
                @foreach($roles as $role)
                  <div class="field">
                    <b-checkbox v-model="roles" :native-value="{{$role->id}}">{{$role->display_name}}</b-checkbox>
                  </div>
                @endforeach
              </div>
            </div>
            <input type="hidden" name="roles" :value="roles">
          </div>

          <button class="button is-primary is-outlined">Create User</button>
        </form>
      </div>
    </div>

  </div> <!-- end of .flex-container -->
@endsection

@section('scripts')
  <script>
    var app = new Vue({
      el: '#app',
      data: {
        auto_password: true,
        roles: [{!! old('roles') ? old('roles') : '' !!}],
      }
    });
  </script>
@endsection