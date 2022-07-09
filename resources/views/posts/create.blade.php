@extends('layouts.app')

@section('content')
<div class="container">
   <form action="/p" enctype="multipart/form-data" method="post">
       @csrf
       <div class="col-8 offset-2">
           <div class="row">
               <h2>Add New Post</h2>
           </div>
           <div class="row">
               <label for="caption" class="col-form-label text-md-end">Post Caption</label>

               <input id="caption"
                      type="text"
                      class="form-control @error('caption') is-invalid @enderror"
                      name="caption"
                      value="{{ old('caption') }}"
                      autocomplete="caption" autofocus>

               @error('caption')
               <span class="invalid-feedback" role="alert">
                   <strong>{{ $message }}</strong>
               </span>
               @enderror
           </div>

           <div class="row">
               <label for="image" class="col-form-label text-md-end">Post Image</label>
               <input type="file" class="form-control" id="image" name="image">

               @error('image')
                    <strong>{{ $message }}</strong>
               @enderror
           </div>

           <div class="row pt-4">
               <button class="btn btn-primary">Add New Post</button>
           </div>
       </div>
   </form>
</div>
@endsection
