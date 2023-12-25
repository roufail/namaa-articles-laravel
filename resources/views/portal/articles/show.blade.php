<x-portal-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Articles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="text-left bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">



                @if(auth()->user()->can('edit others articles') || ( auth()->user()->can('edit article') && $article->user->id === auth()->user()->id))
                <div class="float-end edit-button">
                    <a class="link" href="{{ route('admin.articles.edit',['article' => $article])}}">
                        {{ __('Edit') }}
                    </a>
                </div>
                @endif
        
                <div class="p-6 text-gray-900">
                    <div class="mb-5">
                        <x-success-message />
                        <x-validation-pulk-error />
                    </div>
            
                        <div class="row">
                            <div class="col-10">{{$article->title}}</div>
                            <div class="col-2">{{$article->created_at->format('d M Y')}}</div>
                        </div>
                        <div class="row">
                            @if($article->user)
                                <div class="col-12">
                                    <a class='link' href="{{ route('portal.author.articles',['user' => $article->user]) }}">{{ $article->user->name }}</a>
                                </div>
                            @endif
                        </div>

                        <div class="row article">
                            <div class="col-12">
                                {!! html_entity_decode($article->content) !!}
                            </div>
                        </div>    

                    </div>
                    <div class="m-4">
                        @if(auth()->check())
                        <div>leave comment:</div>
                        <div class="leave_comment">


                            <form action="{{ route('portal.article.comment', $article) }}" method="post">
                                @csrf
                                <div class="mb-3">
                                  <label for="comment_title" class="form-label">Comment title</label>
                                  <input value="{{ old('title') }}" type="text" name="title" class="form-control" id="title" aria-describedby="emailHelp">
                                </div>
                                <div class="mb-3">
                                  <label for="comment" class="form-label">Comment</label>
                                  <textarea  name="content" class="w-100">{{ old('content') }}</textarea>
                                </div>
                                <button type="submit" class="btn">Submit</button>
                              </form>
                            </div>
                        @endif
                        @if($article->approvedcomments->count())    
                        <section class="comments">
                            <div class="container my-5 py-5">
                              <div class>
                                <div>
                                  <div class="card text-dark">
                                    <div class="card-body p-4">
                                      <h4 class="mb-0">Recent comments</h4>
                                      <p class="fw-light mb-4 pb-2">Latest Comments section by users</p>
                          
                                      @foreach ($article->approvedcomments as $comment)

                                      <div class="d-flex flex-start">
                                        <div>
                                          <h6 class="fw-bold mb-1">{{ $comment->user->name }}</h6>
                                          <div class="d-flex align-items-center mb-3">
                                            <p class="mb-0">
                                                {{ $comment->created_at->format('M d, Y') }}
                                            </p>
                                            <a href="#!" class="link-muted"><i class="fas fa-pencil-alt ms-2"></i></a>
                                            <a href="#!" class="link-muted"><i class="fas fa-redo-alt ms-2"></i></a>
                                            <a href="#!" class="link-muted"><i class="fas fa-heart ms-2"></i></a>
                                          </div>
                                          <p class="mb-0">
                                            {!!$comment->content !!}                                          
                                        </p>
                                        </div>
                                      </div>

                                      <hr class="mb-1 mt-1" />
                                      @endforeach
                                    </div>
                          
                              
                                  </div>
                                </div>
                              </div>
                            </div>
                          </section>


                        @else
                          No comments added yet
                        @endif

                    </div>
                </div>
        </div>
    </div>

    @section('extra-css')
    <style>
      .text-left {
          text-align: left !important;
      }
      .edit-button {
          padding: 20px;
      }
      .link {
          color: brown;
      }
     </style>
    @endsection
    
    @section('extra-js')

    @endsection

</x-app-layout>