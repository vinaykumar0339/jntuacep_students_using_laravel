@extends('./base')

@section('content')
        <div class="container mt-1">
            @if (session()->get('loginSuccess'))
              <div class="alert alert-primary mt-1" role="alert">
                  {{ session()->get('loginSuccess') }}
              </div>
            @endif
            @if (session()->get('studentNotFonud'))
              <div class="alert alert-warning mt-1" role="alert">
                  {{ session()->get('studentNotFonud') }}
              </div>
            @endif
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
        </div>
@endsection('content')