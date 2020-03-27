@extends('layouts.main')

@section('content')

<div class="row" style="margin-top: 30px;">

                    <div class="col-md-12">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption font-dark">
                                    <i class="icon-settings font-dark"></i>
                                    <span class="caption-subject bold uppercase">{{trans('messages.details')}}</span>
                                </div>

                            </div>
                            <div class="portlet-body">
                        <div class="inbox">
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="inbox-body">
                             <div class="inbox-content" style=""><div class="inbox-header inbox-view-header">
    <h1 class="pull-left">{{$message->title}}
    </h1>

</div>
<div class="inbox-view-info">
    <div class="row">
        <div class="col-md-12">

            <span class="sbold">{{$message->sender->name}} </span>
             {{$message->created_at}}</div>

    </div>
</div>
<div class="inbox-view">
   {{$message->message}}
</div>
<hr>
<ul class="chats">
    @foreach($message->replies as $reply)
    @if($reply->sender_id == Auth::user()->id)
    <li class="out">
        <span class='avatar' style="width:100px">
     {{$reply->sender->name}}
    </span>
    <div class="message" style="margin-right:120px">

                <span class="arrow"> </span>

                <span class="datetime"> {{$reply->created_at}} </span>
                <span class="body">{{$reply->message}}</span>
            </div>
        </li>
        @else
        <li class="in">
            <span class='avatar' style="width:100px">
     {{$reply->sender->name}}
    </span>
    <div class="message" style="margin-left:120px">

                <span class="arrow"> </span>

                <span class="datetime"> {{$reply->created_at}} </span>
                <span class="body">{{$reply->message}}</span>
            </div>
        </li>
    @endif

    @endforeach

                                                </ul>
<form class="form-horizontal" id='message-form' action="{{url('messages/customer_message_store_reply/'.$message->id)}}" method="post">
{{csrf_field()}}
<div class="chat-form">
        <div class="input-cont">
            <input class="form-control" type="text" name='message' placeholder="{{trans('messages.type_in')}}">
        </div>
        <div class="btn-cont">
            <span class="arrow"> </span>
            <button type="submit" class="btn blue icn-only">
                <i class="fa fa-check icon-white"></i>
            </button>
        </div>
    </div>
</form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                            </div>
                        </div>
                    </div>

                </div>
@endsection
@push('css')
 <link href="{{url('')}}/assets/apps/css/inbox.min.css" rel="stylesheet" type="text/css" />
@endpush
@push('js')
 <script>
$(document).ready(function () {

    $('#message-form').validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "",
        rules: {
            message: {
                required: true
            },

        },
        messages: {
//name: "blabla",
        },

        invalidHandler: function (event, validator) { //display error alert on form submit

        },
        highlight: function (element) { // hightlight error inputs
            $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
        },
        success: function (label) {
            label.closest('.form-group').removeClass('has-error');
            label.remove();
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "tnc") { // insert checkbox errors after the container
                error.insertAfter($('#register_tnc_error'));
            } else if (element.closest('.input-icon').size() === 1) {
                error.insertAfter(element.closest('.input-icon'));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            form.submit();
        }
    });


});
                </script>

 @endpush

