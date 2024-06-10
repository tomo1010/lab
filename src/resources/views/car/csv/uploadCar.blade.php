{{--@extends('layouts.app')

@section('content')
--}}
    <h1>アップロード</h1>


    <div class="row">
        <div class="col-6">
{{--            {!! Form::open(['route' => 'csv.importCar','files'=>true]) !!}--}}
            <form method="POST" action="https://localhost/car/csv/import" enctype="multipart/form-data">
            @csrf
                <div class="form-group">
                    {!! Form::label('csv', 'ｃｓｖ:') !!}
                    {!! Form::file('csv', null, ['class' => 'form-control']) !!}
{{--<input type=“text” name=“test”>--}}
                </div>

                @if (session('flash_message'))
                    <div class="alert alert-success">
                        {{ session('flash_message') }}
                    </div>
                @endif

                {!! Form::submit('アップロード', ['class' => 'btn btn-primary']) !!}
                <!--</form>-->
            {!! Form::close() !!}
        </div>
    </div>






{{--
@endsection
--}}