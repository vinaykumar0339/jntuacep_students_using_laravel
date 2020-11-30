@extends('./base')

@section('content')
    <div class="container mt-3 mb-3 border pt-2">
        <div class="row">
            <div class="col-md-6">
                <div>
                    <h3 class="text-center">Student Login</h3>
                </div>
                    
                @if (session()->get('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session()->get('success') }}
                    </div>
                @endif

                @if (session()->get('loginFirst'))
                    <div class="alert alert-danger" role="alert">
                        {{ session()->get('loginFirst') }}
                    </div>
                @endif

                @if (session()->get('loginError'))
                    <div class="alert alert-danger" role="alert">
                        {{ session()->get('loginError') }}
                    </div>
                @endif
                    
                <form class="mt-1" method="POST" action="">
                    @csrf
                    <div class="form-group">
                        <label for="rollno">Roll no</label>
                        <input type="text" class="form-control mb-1" name='rollno' id="rollno" placeholder="Enter rollno">
                        @error('rollno')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control mb-1" name='password' id="password" placeholder="Password">
                        @error('password')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="extra">
                        <span>
                            Don't Have An Account <a href="/students/create">Register Here</a>
                        </span>
                        <span>
                            <a href="/">forgot password?</a>
                        </span>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </form>
                <br>
            </div>

            <div class="col-md-6">
                <div>
                    <h3 class="text-center">Admin Login</h3>
                </div>
                    
                @if (session()->get('adminloginFirst'))
                    <div class="alert alert-danger" role="alert">
                        {{ session()->get('adminloginFirst') }}
                    </div>
                @endif

                @if (session()->get('adminloginError'))
                    <div class="alert alert-danger" role="alert">
                        {{ session()->get('adminloginError') }}
                    </div>
                @endif

                
                    
                <form class="mt-1" method="POST" action="/admin-login">
                    @csrf
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control mb-1" name='username' id="username" placeholder="Enter username">
                        @error('username')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="adminpassword">Password</label>
                        <input type="password" class="form-control mb-1" name='adminpassword' id="adminpassword" placeholder="Password">
                        @error('adminpassword')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </form>
            </div>
        </div>
    </div>
@endsection('content')