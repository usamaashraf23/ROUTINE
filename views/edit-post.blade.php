<x-layout>
    <div class="container py-md-5 container--narrow">
        <form action="/post/{{$post->id}}" method="POST">
            <p><small><strong><a href="/post/{{$post->id}}">&laquo; Back to Post Permalink</a></strong></small></p>
            @csrf
            @method('PUT')
          <div class="form-group">
            <label for="post-title" class="text-muted mb-1"><small>Title</small></label>
            <input value="{{old('title',$post->title)}}" name="title" id="post-title" class="form-control form-control-lg form-control-title" type="text" placeholder="" autocomplete="off" />
          </div>
        @error('title')
          <p class="alert alert-danger m-0">{{$message}}</p>
          @enderror
          <div class="form-group">
            <label for="post-body" class="text-muted mb-1"><small>Body Content</small></label>
            <textarea  name="body" id="post-body" class="body-content tall-textarea form-control" type="text">{{old('body',$post->body)}}</textarea>
          </div>
          @error('body')
          <p class="alert alert-danger m-0">{{$message}}</p>
          @enderror
          <button class="btn btn-primary">Save Changes</button>
        </form>
      </div>
</x-layout>