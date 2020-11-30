@extends('./base')

@section('content')
    <div class="container mt-3 mb-3 border pt-2">
        <div>
            <h3 class="text-center">Student Registration</h3>
        </div>
        <form action="/students" method="post">
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
                <label for="username">Username</label>
                <input type="text" class="form-control mb-1" name='username' id="usernmae" placeholder="Enter username">
                @error('username')
                    <div class="alert alert-danger" role="alert">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control mb-1" name='email' id="email" placeholder="Enter email">
                @error('email')
                    <div class="alert alert-danger" role="alert">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="phone_number">Phone</label>
                <input type="number" class="form-control mb-1" name='phone_number' id="Phone_number" placeholder="Enter Phonr number">
                @error('phone_number')
                    <div class="alert alert-danger" role="alert">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="home_address">Home address</label>
                <textarea class="form-control mb-1" rows="5" name='home_address' placeholder="Enter Home Address" id="home_address"></textarea>
                @error('home_address')
                    <div class="alert alert-danger" role="alert">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="work_address">Work address</label>
                <textarea class="form-control mb-1" rows="5" name='work_address' placeholder="Enter Work Address" id="work_address"></textarea>
                @error('work_address')
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
            <div class="form-group">
                <label for="confPassword">Confirm Password</label>
                <input type="password" class="form-control mb-1" name='confirmPassword' id="confPassword" placeholder="Confirm Password">
                @error('confirmPassword')
                    <div class="alert alert-danger" role="alert">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="extra">
                <span>
                    Already Have An Account <a href="/login">Login Here</a>
                </span>
            </div>
            <button id='submitButton' type="submit" class="btn btn-primary btn-block">Register</button>
        </form>
    </div>
    <script>
        const button = document.querySelector('#submitButton');
        button.addEventListener('click', () => {
            button.classList.add('disabled');
        })
    </script>
@endsection('content')