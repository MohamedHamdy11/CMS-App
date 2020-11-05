@extends('layouts.app')

@section('stylesheets')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.0/trix.css" rel="stylesheet">
@endsection

@section('content')
    <div class="card card-default">
        <div class="card-header">
            {{ isset($post) ? "Update Post" : "Add a new Post" }}
        </div>
        <div class="card-body">
           <form action="{{ isset($post) ? route('posts.update', $post->id) : route('posts.store') }}" method="POST" enctype="multipart/form-data">
               @csrf
               @if(isset($post))
                @method('PUT')
               @endif
               <div class="form-group">
                   <label for="post title">Title:</label>
                   <input type="text" class="form-control" name="title" placeholder="Add a new post"
                   value="{{ isset($post) ? $post->title : "" }}">
               </div>
               <div class="form-group">
                    <label for="post description">Description:</label>
                    <textarea class="form-control" rows="2" name="description" placeholder="Add a description">{{ isset($post) ? $post->description : "" }}</textarea>
                </div>
                <div class="form-group">
                    <label for="post content">Content:</label>
                    {{-- <textareaclass="form-control"row="3"name="content"placeholder="Addacontent"></textarea> --}}
                    <input id="x" type="hidden" name="content" value="{{ isset($post) ? $post->content : "" }}" >
                    <trix-editor input="x"></trix-editor>
                </div>
                @if(isset($post))
                    <div class="form-group">
                        <img src="{{ asset('storage/'. $post->image) }}" style="width: 100%" />
                    </div>
                @endif
                <div class="form-group">
                    <label for="post content">Image:</label>
                    <input type="file" class="form-control" name="image">
                </div>
               <div class="form-group">
                   <button type="submit" class="btn btn-success">
                       {{ isset($post) ? "Update" : "Add" }}
                   </button>
               </div>
           </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.0/trix.js"></script>
@endsection
