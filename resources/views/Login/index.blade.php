@extends('layouts.main')

@section('container')
<div class="row justify-content-center">
        <div class="col-lg-4">
            <main class="form-signin">
                <form>
                    <img class="mb-4 mx-auto d-block" src="../img/simlab.png" alt="" width="30%">
                    <h1 class="h5 mb-3 fw-normal">Please Login</h1>

                    <div class="form-floating">
                      <input type="text" name="username" class="form-control" id="name" placeholder="username">
                      <label for="floatingInput">username</label>
                    </div>
                    <div class="form-floating">
                      <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
                      <label for="floatingPassword">Password</label>
                    </div>


                    <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button>
                  </form>
                  <small class="d-block text-center mt-3">&copy; simlab-2022</small>
                </main>
        </div>
</div>

@endsection
