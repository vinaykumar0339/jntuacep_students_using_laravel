<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="/">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
      @unless(Auth::guard('staff')->check() || Auth::guard('student')->check())
        <li class="nav-item active">
          <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
        </li>
      @endunless

      @auth('student')
        <li class="nav-item">
          <a class="nav-link" href="{{ route('students.show', Auth::guard('student')->user()->rollno) }}">Profile</a>
        </li>
      @endauth

      @auth('staff')
        <li class="nav-item">
          <a class="nav-link" href="{{ route('admin.show', Auth::guard('staff')->user()->username) }}">Staff</a>
        </li>
      @endauth

      <li class="nav-item">
        <a class="nav-link" href="/about">About</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/contactus">Contact Us</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/gallery">Gallery</a>
      </li>
      @auth('student')
        <li class="nav-item">
          <a class="btn btn-danger" href="/logout">Logout</a>
        </li>
      @endauth

      @auth('staff')
        <li class="nav-item">
          <a class="btn btn-danger" href="/admin-logout">Logout</a>
        </li>
      @endauth
      
      @unless(Auth::guard('staff')->check() || Auth::guard('student')->check())
        <li class="nav-item">
          <a class="nav-link" href="/students/create">Register</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/login">Login</a>
        </li>
      @endunless

      
      
        
    </ul>
  </div>
</nav>