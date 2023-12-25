<x-portal-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Articles') }} 
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($articles->count())
            @foreach ($articles as $article)
            <div class="text-left bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="p-6 text-gray-900">

                        
                        <div class="row">
                            <div class="col-10">{{$article->title}}</div>
                            <div class="col-2">{{$article->created_at->format('d M Y')}}</div>
                            <div class="col-12">{{$article->excerpt}}</div>
                        </div>
                        <div class="row">
                            @if($article->user)
                            <div class="col-10">
                                <a class="link" href="{{ route('portal.author.articles',['user' => $article->user]) }}">{{ $article->user->name }}</a>
                            </div>
                            @endif
                            <div class="col-2"><a class="link" href="{{ route('portal.article',['article' => $article]) }}">Read More</a></div>
                        </div>
                    </div>
                </div>

                @endforeach
                {{ $articles->links() }}
            @else
            <div class="text-left bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="p-6 text-gray-900">
                        No articles added yet
                    </div>
                </div>
            @endif
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