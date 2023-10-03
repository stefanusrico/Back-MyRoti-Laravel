@extends('layout/main')


@section('container')
<main class="form-signin w-100 m-auto">
  <form action="/login" method="post">
    @csrf
    <h1 class="h3 mb-3 fw-normal">Please login</h1>

    <div class="form-floating">
      <input type="name" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="name">
      <label for="name">Nama</label>
    </div>
    @if(session()->has('loginError'))
      <div class="error">
        {{ session('loginError') }}
        <h1>error</h1>
      </div>
    @endif
    <div class="form-floating">
      <input name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password">
      <label for="password">Password</label>
    </div>

    <div class="form-check text-start my-3">
      <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
      <label class="form-check-label" for="flexCheckDefault">
        Remember me
      </label>
    </div>
    <button class="btn btn-primary w-100 py-2" type="submit">Sign in</button>
    <p class="mt-5 mb-3 text-body-secondary">&copy; 2017–2023</p>
  </form>
</main>
@endsection