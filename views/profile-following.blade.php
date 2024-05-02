<x-profile :sharedData="$sharedData">
    <div class="list-group" >
      @foreach ($posts as $post)
      <a href="/post/{{$post->id}}" class="list-group-item list-group-item-action">
        <img class="avatar-tiny" src="https://gravatar.com/avatar/b9408a09298632b5151200f3449434ef?s=128" />
        <strong>{{$post->title}}</strong> on {{$post->created_at->format('n/j/Y')}}
      </a>              
      @endforeach
    </div>
  </x-profile>