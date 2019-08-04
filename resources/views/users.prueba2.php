@include('header')
  <div class="row mt-3">
    <div class="col-8">
      <h1>{{ $title }}</h1>

      <hr>

      @unless( empty($users) )
        <ul>
          @foreach ($users as $user)
            <li>{{ $user }}</li>
          @endforeach
        </ul>
      @else
        <p>No hay usuarios Registrados</p>
      @endunless
    </div>
    <div class="col-4">
      @include('sidebar')
    </div>
  </div>
  {{ time() }}
@include('footer')
