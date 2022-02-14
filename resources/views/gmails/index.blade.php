@extends('gmails.layout')
 
@section('content')
    <div class="row" style="margin-top:5rem;">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Show gmail list to receive me.</h2>
            </div>
           
        </div>
    </div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
   
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>gmail address</th>
            <th>title</th>
            <th>content</th>
            <th>addin file</th>
            <th>received time</th>
            <th>created time</th>
        </tr>
        @foreach ($gmails as $gmail)
        <tr>
           <td>{{ $gmail->id }}</td>
            <td>{{ $gmail->address }}</td>
            <td>{{ $gmail->title }}</td>
            <td>{{ $gmail->content }}</td>
            <td>{{ $gmail->addin_file }}</td>
            <td>{{ $gmail->received_at }}</td>           
            <td>{{ $gmail->created_at }}</td>           
        </tr>
        @endforeach
    </table>
  
@endsection