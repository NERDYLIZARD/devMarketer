@extends('layouts.manage')

@section('content')
  <div class="flex-container">
    <div class="columns m-t-10">
      <div class="column">
        <h1 class="title">Create New Permission</h1>
      </div>
    </div>
    <hr>
    <div class="columns">
      <div class="column">
        <form action="{{route('permissions.store')}}" method="POST">
          {{csrf_field()}}

          {{--radio buttons for basic/crud--}}
          <div class="block">
            <b-radio v-model="permissionType" name="permission_type" native-value="basic">Basic Permission</b-radio>
            <b-radio v-model="permissionType" name="permission_type" native-value="crud">CRUD Permission</b-radio>
          </div>

          {{--basic--}}
          <div v-if="permissionType === 'basic'">
            <div class="field">
              <label for="display_name" class="label">Name:</label>
              <p class="control">
                <input type="text" class="input" name="display_name" id="display_name" required>
              </p>
            </div>
            <div class="field">
              <label for="name" class="label">Slug:</label>
              <p class="control">
                <input type="text" class="input" name="name" id="name" required>
              </p>
            </div>
            <div class="field">
              <label for="description" class="label">Description:</label>
              <p class="control">
                <input type="text" class="input" name="description" id="description">
              </p>
            </div>
          </div>

          {{--crud--}}
          <div v-if="permissionType === 'crud'">
            <div class="field">
              <label for="resource" class="label">Resource:</label>
              <p class="control">
                <input v-model="resource" type="text" class="input" name="resource" id="resource" placeholder="posts" required>
              </p>
            </div>
            <div class="columns m-t-10">
              <div class="column is-one-quarter">
                  <div class="field">
                    <b-checkbox v-model="crudSelected" native-value="create">Create</b-checkbox>
                  </div>
                  <div class="field">
                    <b-checkbox v-model="crudSelected" native-value="read">Read</b-checkbox>
                  </div>
                  <div class="field">
                    <b-checkbox v-model="crudSelected" native-value="update">Update</b-checkbox>
                  </div>
                  <div class="field">
                    <b-checkbox v-model="crudSelected" native-value="delete">Delete</b-checkbox>
                  </div>
              </div>
              {{--hidden checkbox input--}}
              <input type="hidden" name="crud_selected" :value="crudSelected"/>
              {{--display--}}
              <div class="column" v-if="resource.length >= 3 && crudSelected.length > 0">
                <table class="table">
                  <thead>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Description</th>
                  </thead>
                  <tbody>
                    <tr v-for="crudOperator in crudSelected">
                      <td v-text="crudName(crudOperator)"></td>
                      <td v-text="crudSlug(crudOperator)"></td>
                      <td v-text="crudDescription(crudOperator)"></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <button class="button is-primary is-outlined m-t-20">Create Permission</button>
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
        resource: '',
        permissionType: 'basic',
        crudSelected: ['create', 'read', 'update', 'delete'],
      },
      methods: {
        crudName(crudOperator) {
          return crudOperator.substr(0, 1).toUpperCase() + crudOperator.substr(1) + " " + this.resource.substr(0, 1).toUpperCase() + this.resource.substr(1);
        },
        crudSlug(crudOperator) {
          return crudOperator.toLowerCase() + "-" + this.resource.toLowerCase();
        },
        crudDescription(crudOperator) {
          return "Allow a User to " + crudOperator.toUpperCase() + " " + this.resource.substr(0, 1).toUpperCase() + this.resource.substr(1);
        }
      }
    });
  </script>
@endsection