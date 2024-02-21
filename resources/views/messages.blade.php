<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">


    <title>white chat - Bootdey.com</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
        body {
            margin-top: 20px;
        }

        .chat-online {
            color: #34ce57
        }

        .chat-offline {
            color: #e4606d
        }

        .chat-messages {
            display: flex;
            flex-direction: column;
            max-height: 800px;
            overflow-y: scroll
        }

        .chat-message-left,
        .chat-message-right {
            display: flex;
            flex-shrink: 0
        }

        .chat-message-left {
            margin-right: auto
        }

        .chat-message-right {
            flex-direction: row-reverse;
            margin-left: auto
        }

        .py-3 {
            padding-top: 1rem !important;
            padding-bottom: 1rem !important;
        }

        .px-4 {
            padding-right: 1.5rem !important;
            padding-left: 1.5rem !important;
        }

        .flex-grow-0 {
            flex-grow: 0 !important;
        }

        .border-top {
            border-top: 1px solid #dee2e6 !important;
        }
    </style>
</head>
<body>
<main class="content">
    <form action="{{ route('messages', $userId) }}" method="post">
        @method('get')
        <div class="container p-0">
            <h1 class="h3 mb-3">Messages</h1>
            <div class="card">
                <div class="row g-0">
                    <div class="col-12 col-lg-7 col-xl-9">
                        <div class="py-2 px-4 border-bottom d-none d-lg-block">
                            <div class="d-flex align-items-center py-1">
                                <div class="position-relative">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar3.png"
                                         class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
                                </div>
                                <div class="flex-grow-1 pl-3">
                                    <strong>{{ $receiver->name }}</strong>
                                    <div class="text-muted small"><em> </em></div>
                                </div>
                            </div>
                        </div>
                        <div class="position-relative">
                            <div class="chat-messages p-4">
                                @if(isset($messages))
                                @foreach($messages as $message)
                                    @if($message->sender_id === $sender->id)
                                    <div class="chat-message-right pb-4">
                                        <div>
                                            <img src="https://bootdey.com/img/Content/avatar/avatar1.png"
                                                 class="rounded-circle mr-1" alt="Chris Wood" width="40"
                                                 height="40">
                                            <div
                                                class="text-muted small text-nowrap mt-2">{{ $message ? $message->created_at->diffForHumans() : '' }}</div>
                                        </div>
                                        <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
                                            <div class="font-weight-bold mb-1">{{ $sender->name }}</div>
                                            {{ $message['content'] }}
                                        </div>
                                    </div>
                                    @else
                                    <div class="chat-message-left pb-4">
                                        <div>
                                            <img src="https://bootdey.com/img/Content/avatar/avatar3.png"
                                                 class="rounded-circle mr-1" alt="Sharon Lessman" width="40"
                                                 height="40">
                                            <div
                                                class="text-muted small text-nowrap mt-2">{{ $message ? $message->created_at->diffForHumans() : '' }}</div>
                                        </div>
                                        <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">
                                            <div class="font-weight-bold mb-1">{{ $receiver->name }}</div>
                                            {{ $message['content'] }}
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                                @else

                                @endif
                            </div>
                        </div>
                        <div class="flex-grow-0 py-3 px-4 border-top">
                            <div class="input-group">
                                <form action="{{ route('messages', $receiver->id) }}" method="post">
                                    @csrf
                                    <input type="text" class="form-control" name="textMessage"
                                           placeholder="Type your message">
                                    <input type="text" id="receiver_id" class="form-control"
                                           name="receiver_id"
                                           placeholder="receiver_id" hidden=""
                                           value="{{ $receiver->id }}">
                                    <input type="submit"
                                           class="btn btn-primary"
                                           value="Send">
                                    {{--                                    <button type="submit" name=_method" value="post" id="save-task">Send</button>--}}

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</main>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript">

</script>
</body>
</html>
