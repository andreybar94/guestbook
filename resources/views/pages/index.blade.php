@extends('index')

    @section('content')
    <form action="{{ route('messages.store') }}" method="POST" id="id-form_messages">
        
    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if (session('sessionMessage'))
    <div class="alert alert-success" role="alert">
        {{ session('sessionMessage') }}
    </div>
    @endif


    @csrf
        <div class="form-group">
            <label for="message">Сообщение: *</label>
            <textarea class="form-control" rows="5" placeholder="Текст сообщения" name="message" cols="50"
                      id="message">{{ old('message') }}</textarea>
        </div>

        <div class="form-group">
            <input class="btn btn-primary" type="submit" value="Добавить">
        </div>
    </form>
        <div class="messages">
            @if( ! $messages->isEmpty())
                @foreach ($messages as $message)    
                    <div class="card  mb-3">
                      <div class="card-header d-flex justify-content-between flex-wrap">
                        <span>{{ $message->username }}</span>
                        <span>{{ $message->created_at }}</span>
                      </div>
                      <div class="card-body">
                        <p class="card-text">
                            {{ $message->message }}</p>
                        @include('pages.parts.deleteButtonConfirmation')
                      </div>
                    </div>
                @endforeach
            @endif
        </div>
    @stop