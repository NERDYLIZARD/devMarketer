<form id="logout-form" action="{{ route('logout') }}" method="POST">
  {{ csrf_field() }}
</form>