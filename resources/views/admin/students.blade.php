@extends('./base')

@section('content')
    <div class="container mt-1">
      <div class="row justify-content-md-center justify-content-sm-center">
        <form class="form-inline" method="POST" action="/admin/students">
          @csrf
          <div class="form-group ml-5">
              <input class="form-check-input" type="radio" name="typeOfSearch" id="byyear" value="byyear" required>
              <label class="form-check-label" for="byyear">By year</label>
          </div>
            <div class="form-group ml-5">
              <input class="form-check-input" type="radio" name="typeOfSearch" id="byrollno" value="byrollno" required>
              <label class="form-check-label" for="byrollno">By roll number</label>
            </div>
          <div class="form-group mx-sm-3 mb-2 ml-4">
            <input type="text" class="form-control" name='search' placeholder="Search" required>
          </div>
          <button type="submit" class="btn btn-primary mb-2 ml-auto mr-auto">Search</button>
        </form>
      </div>
      <div class="row">
        @foreach ($students as $student)
          <div class="col-md-4">
            <div class="card mt-2 mr-auto ml-auto" style="width: 18rem;">
              @if ($student->imageUrl)
                  <img id='preview' src="{{$student->imageUrl}}" alt="Admin" class="rounded-circle align-self-center mt-2" width="150">
              @else
                  <img id='preview' src="/static/images/placeholder.png" alt="Admin" class="rounded-circle align-self-center mt-2" width="150">
              @endif
              <div class="card-body">
                <h5 class="card-title">{{Str::upper($student->rollno)}}</h5>
                <p class="card-text">{{$student->phone_number}}</p>
                <a href="/admin/student/{{$student->rollno}}" class="btn btn-primary">Full Details</a>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
@endsection('content')