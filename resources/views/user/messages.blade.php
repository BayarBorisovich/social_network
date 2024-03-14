@extends('layouts.user.messages')

@section('content')
    <div class="container p-0">
        <h1 class="h3 mb-3">Messages</h1>
        <div class="text-right">
        </div>
        <div class="card">
            <messages-component :messages="{{ $messages }}" :sender="{{ $sender }}"
                                :receiver="{{ $receiver }}"></messages-component>
        </div>
    </div>
@endsection

