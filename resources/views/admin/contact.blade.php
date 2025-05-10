@extends('layout.back.master')
@section('title','Contact-table')
@section('content')

<div class="col-md-12">
    <div class="card">
     
      <div class="card-body">
        <!-- Modal -->
    

        <div class="table-responsive">
            <table id="add-row" class="display table table-striped table-hover">
                <thead>
                     
                    <tr>
                       
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th style="width: 10%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contacts as $contact)
                        <tr>
                            <td>{{ ++$count }}</td> 
                            <td>{{ $contact->name }}</td>    
                            <td>{{ $contact->email }}</td>
                            <td>{{ $contact->message }}</td>
                            <td>
                                <div class="form-button-action">
                                    <a href="{{ route('contact.show', $contact->id) }}" class="btn btn-link btn-info btn-lg" title="View">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                      {{-- <button type="button" class="btn btn-link btn-primary btn-lg" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </button> --}}
                                    <form action="{{ url('/contact_list/' . $contact->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link btn-danger btn-lg" title="Delete" onclick="return confirm('Are you sure?')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>
      </div>
    </div>
  </div>
@endsection