@extends('layouts.post.post')

@section('content')

    <div class="container">
        <component-posts></component-posts>
        <div class="row">
            <div class="col-md-12">
                <div class="text-right">
                    <a class="btn btn-success" href="{{ url()->previous() }}" role="button">Back</a>
                </div>
                <div id="content" class="content content-full-width">

                    <div class="profile">
                        <div class="profile-header">

                            <div class="profile-header-cover"></div>

                            <div class="profile-header-content">

                                <div class="profile-header-img">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar6.png" alt>
                                </div>


                                <div class="profile-header-info">
                                    <h4 class="m-t-10 m-b-5">{{ $user->name }}</h4>
                                    <p class="m-b-10">{{ $user->about_of_me }}</p>
                                    <a href="{{ route('main') }}" class="btn btn-sm btn-info mb-2">In Profile</a>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="profile-content">

                        <div class="tab-content p-0">

                            <div class="tab-pane fade active show" id="profile-post">

                                <ul class="timeline">
                                    @if(empty($friendPosts))
                                        <p> Ваши друзья не опубликовали посты</p>
                                    @else
                                        @foreach($friendPosts as $post)
                                            <li>
                                                <div class="timeline-time">
                                                <span
                                                    class="date">{{ $post->created_at->diffForHumans() }}</span>
                                                </div>
                                                <div class="timeline-icon">
                                                    <a href="javascript:;">&nbsp;</a>
                                                </div>
                                                <div class="timeline-body">
                                                    <div class="timeline-header">
                                                    <span class="userimage"><img
                                                            src="https://bootdey.com/img/Content/avatar/avatar3.png"
                                                            alt>
                                                    </span>
                                                        <span class="username">{{ $post->author->name }}</span>
                                                    </div>
                                                    <div class="timeline-content">
                                                        <p>{{ $post->content }}</p>
                                                    </div>
                                                    <div class="timeline-footer">
                                                        {{--                                                    {{'id ' . $post->id}}--}}
                                                        <form action="{{ route('post.like') }}" method="post"
                                                              id="formLike">
                                                            @csrf
                                                            <a href="javascript:;"
                                                               class="m-r-15 text-inverse-lighter">
                                                                <input type="hidden" id="id"
                                                                       class="fa fa-thumbs-up fa-fw fa-lg m-r-3"
                                                                       name="post_id"
                                                                       placeholder="id"
                                                                       value="{{ $post->id }}">

                                                                <button type="submit"
                                                                        class="border-0 bg-transparent mb-3">
                                                                    {{ $post->like_count }}
                                                                    @if($user->likeIt->contains($post->id))
                                                                        <i class="fa fa-heart"
                                                                           aria-hidden="true"
                                                                           id="disLike"></i>
                                                                    @else
                                                                        <i class="fa fa-heart-o"
                                                                           aria-hidden="true" id="like"></i>
                                                                    @endif
                                                                </button>
                                                            </a>
                                                        </form>
                                                        <div class="chat-messages p-8">
                                                            @if (isset($post->comment))
                                                                @foreach($post->comment as $comment)
                                                                    <div class="chat-message-left">
                                                                        <div>
                                                                            <img
                                                                                src="https://bootdey.com/img/Content/avatar/avatar3.png"
                                                                                class="rounded-circle mr-1"
                                                                                alt="Sharon Lessman" width="25"
                                                                                height="25">
                                                                            <div
                                                                                class="text-muted small text-nowrap mt-2">

                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3 ">
                                                                            <div
                                                                                class="font-weight-bold mb-1">
                                                                                {{ $comment->author->name }}
                                                                            </div>
                                                                            {{ $comment->comment }}
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                        </div>

                                                        <form action="{{ route('post.comment') }}" method="post">
                                                            @csrf
                                                            <div class="text-right">
                                                                <input type="hidden" id="id"
                                                                       class="fa fa-thumbs-up fa-fw fa-lg m-r-3"
                                                                       name="post_id"
                                                                       placeholder="id"
                                                                       value="{{ $post->id }}">
                                                                <div class="form-floating">
                                                                    <textarea class="form-control mb-3"
                                                                              name="comment"
                                                                              placeholder="Leave a comment here"
                                                                              id="floatingTextarea"></textarea>
                                                                    <label for="floatingTextarea">Comments</label>
                                                                    <input type="submit"
                                                                           class="btn btn-sm btn-outline-primary md-3"
                                                                           value="send">
                                                                </div>
                                                            </div>
                                                        </form>

                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
