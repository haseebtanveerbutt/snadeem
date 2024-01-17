@extends('app.layout.default')
<link rel="stylesheet" type="text/css" href="{{asset('coloris/dist/coloris.min.css')}}">
<style>
    .btn-position {
        @if(isset($setting->widget_position) && $setting->widget_position == "upper right")
                top: 10px;
        right: 10px;
        @elseif(isset($setting->widget_position) && $setting->widget_position == "upper left")
                top: 10px;
        left: 10px;
        {{--        @elseif(isset($setting->widget_position) && $setting->widget_position == "upper center")--}}
        {{--            top:10px;right:152px;--}}
                @elseif(isset($setting->widget_position) && $setting->widget_position == "lower right")
    bottom: 10px;
        right: 10px;
        @elseif(isset($setting->widget_position) && $setting->widget_position == "lower left")
                bottom: 10px;
        left: 10px;
        {{--        @elseif(isset($setting->widget_position) && $setting->widget_position == "lower center")--}}
        {{--            bottom:10px;center:152px;--}}
        {{--        @elseif(isset($setting->widget_position) && $setting->widget_position == "middle right")--}}
        {{--            top:60px;right:10px;--}}
        {{--        @elseif(isset($setting->widget_position) && $setting->widget_position == "middle left")--}}
        {{--            top:60px;left:10px;--}}
        {{--        @elseif(isset($setting->widget_position) && $setting->widget_position == "middle center")--}}
        {{--             top:60px;right:152px;--}}
                @else
    bottom: 10px;
        right: 10px;
        @endif
            font-family: {{isset($setting->font_family)?$setting->font_family:''}};
    }

    .support-btn, .support-btn svg, .custom-head, .custom-head-p, .custom-head-p b, .send-btn {
        font-family: {{isset($setting->font_family)?$setting->font_family:''}} ;
    }

    .custom-body, .custom-body p, .custom-body span, .custom-body b, .custom-footer {
        {{--background: {{isset($setting->body_bg_color)?$setting->body_bg_color:'white'}} !important;--}}
        {{--color: {{isset($setting->body_text_color)?$setting->body_text_color:'black'}} ;--}}
            font-family: {{isset($setting->font_family)?$setting->font_family:''}} ;
    }

    .widget-view-form p {
        font-size: 15px !important;
        margin-bottom: 9px !important;
    }

    .clr-field {
        width: 100% !important;
    }

    .clr-field button {
        /*width: 93% !important;*/
        /*height: 20px !important;*/
        /*right: 3% !important;*/
    }

    input.form-control:hover, textarea.form-control:hover {
        border-color: rgb(104, 115, 125) !important;
    }

    input.form-control:focus {
        border-color: rgb(104, 115, 125) !important;
        outline: none !important;
    }

    .widget-left-div input.form-control, .widget-left-div input.form-control:focus {
        /*border-radius: 20px;*/
        /*padding-left: 23px;*/
        outline: none !important;
    }

    select.form-control:hover {
        border-color: rgb(104, 115, 125) !important;
    }

    select.form-control:focus {
        border-color: rgb(104, 115, 125) !important;
        outline: none !important;
    }

    .widget-left-div select.form-control, .widget-left-div select.form-control:focus {
        /*border-radius: 20px;*/
        /*padding-left: 23px;*/
        outline: none !important;
    }

    button#dropzone-input:focus {
        outline: none !important;
    }

    .kEOBdL {
        border-width: 1px !important;
        border-color: rgb(216, 220, 222);
        border-style: dashed;
        border-radius: 0.357143rem;
        background-color: rgb(255, 255, 255);
        opacity: 0.9;
        display: block;
        width: 100%;
        padding: 14px !important;
        color: rgb(47, 57, 65);
        cursor: pointer !important;
    }

    .kEOBdL:hover {
        background-color: rgb(248, 249, 249) !important;
    }

    .eiBYcC {
        text-align: center !important;
    }

    .gVBZh {
        max-width: 100%;
        margin-right: 0.357143rem;
        color: rgb(23, 73, 77);
        min-width: 1.28571rem;
        min-height: 1.28571rem;
        height: 1.28571rem;
        width: 1.28571rem;
    }

    svg:not(:root) {
        overflow: hidden;
    }

    .blfOQk {
        max-width: 100%;
        font-size: 14px !important;
        color: rgb(104, 115, 125);
        display: inline-block !important;
        vertical-align: top !important;
    }

    .iquIjP {
        display: none;
    }
</style>
<style>
    .modal-content{

    }
    @if(($wizard->count() <= 0) && $questions->count() > 0)
    div#wizard {
    background: white !important;
    overflow: scroll !important;
}
    @endif
</style>
@section('content')
    @if(($wizard->count() <= 0) && $questions->count() > 0)
        {{--                              Modal--}}
        <div aria-hidden="true" class="modal fade show" id="wizard" style="display: block;" aria-modal="true" role="dialog"
             tabindex="-1">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Important Questions</h5>
                    </div>

                    <form action="{{route('wizard.save')}}" method="post">
                        @sessionToken

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    @if($questions->count())
                                        @foreach($questions as $question)
                                            @if($question->type == 'Input Text')
                                                <div class="form-group" style="margin-top: 20px !important;">
                                                    <label style="font-weight: 500;">{{$question->label}}</label>
                                                    <textarea class="form-control" name="question[{{$question->id}}]" placeholder="{{$question->placeholder}}" type="text" required></textarea>
                                                </div>
                                            @elseif($question->type == 'Input Email')
                                                <div class="form-group">
                                                    <label style="font-weight: 500;">{{$question->label}}</label>
                                                    <input class="form-control" name="question[{{$question->id}}]" type="email" required placeholder="{{$question->placeholder}}">
                                                </div>
                                            @elseif($question->type == 'Textarea')
                                                <div class="form-group" style="margin-top: 20px !important;">
                                                    <label style="font-weight: 500;">{{$question->label}}</label>
                                                    <textarea class="form-control" name="question[{{$question->id}}]" placeholder="{{$question->placeholder}}" type="text"
                                                              required></textarea>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="SaveRule btn btn-primary ">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{--                              Modal End--}}
    @endif
    <div class="container" style="min-height: 510px;">
        <form action="{{route('widget.settings.save')}}" method="post">
            @sessionToken

            <div class="row ">
                <div class="col-md-12 padding-0 my-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 style="margin-bottom: 0 !important;">Widget Settings</h5>
                        <div>
                            <button type="submit" class="btn  btn-primary text-white">Save</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row ">
                <div class="col-md-8 widget-left-div">
                    <div class="row " style="margin-top: 0 !important;">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="#">Button & Header Background Color</label>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control header_button_bg_color"
                                                   name="header_button_bg_color"
                                                   value="{{isset($setting->header_button_bg_color)?$setting->header_button_bg_color:'#20494D'}}"
                                                   data-coloris>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="#">Launcher Text Color</label>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control header_button_text_color"
                                                   name="header_button_text_color"
                                                   value="{{isset($setting->header_button_text_color)?$setting->header_button_text_color:'#ffffff'}}"
                                                   data-coloris>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="#">Widget Position</label>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <select name="widget_position" class="form-control widget_position">
                                                <option
                                                    @if(isset($setting->widget_position) && $setting->widget_position == "lower right") selected
                                                    @endif value="lower right">Lower Right
                                                </option>
                                                <option
                                                    @if(isset($setting->widget_position) && $setting->widget_position == "lower left") selected
                                                    @endif value="lower left">Lower Left
                                                </option>
                                                {{--                                                    <option @if(isset($setting->widget_position) && $setting->widget_position == "lower center") selected @endif value="lower center">Lower Center</option>--}}
                                                <option
                                                    @if(isset($setting->widget_position) && $setting->widget_position == "upper left") selected
                                                    @endif value="upper left">Upper Left
                                                </option>
                                                <option
                                                    @if(isset($setting->widget_position) && $setting->widget_position == "upper right") selected
                                                    @endif value="upper right">Upper Right
                                                </option>
                                                {{--                                                    <option @if(isset($setting->widget_position) && $setting->widget_position == "upper center") selected @endif value="upper center">Upper Center</option>--}}
                                                {{--                                                    <option @if(isset($setting->widget_position) && $setting->widget_position == "middle left") selected @endif value="middle left">Middle Left</option>--}}
                                                {{--                                                    <option @if(isset($setting->widget_position) && $setting->widget_position == "middle right") selected @endif value="middle right">Middle Right</option>--}}
                                                {{--                                                    <option @if(isset($setting->widget_position) && $setting->widget_position == "middle center") selected @endif value="middle center">Middle Center</option>--}}
                                            </select>
                                        </div>

                                    </div>
                                    <div class="row d-none">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Contact Button Text</label>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="form-control contact_button" name="contact_button"
                                                   value="{{isset($setting->contact_button)?$setting->contact_button:'Contact us'}}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Launcher Button Text</label>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="form-control launcher_label" name="launcher_label"
                                                   value="{{isset($setting->launcher_label)?$setting->launcher_label:'Need Help?'}}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Form Title Text</label>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="form-control contact_form_title" name="contact_form_title"
                                                   value="{{isset($setting->contact_form_title)?$setting->contact_form_title:'Feedback'}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 pl-0">
                    <div class="card">
                        <div class="card-body widget-view-button-div">
                            <div style="min-height: 120px;border-radius: 20px;background-color: white;">
                                <div class="position-absolute widget-button-parent-div btn-position" style="">
                                    <button class="btn py-3 support-btn"
                                            style="border-radius: 20px; color: {{isset($setting->header_button_text_color)?$setting->header_button_text_color:'white'}} ; background: {{isset($setting->header_button_bg_color)?$setting->header_button_bg_color:'rgb(23, 73, 77)'}} ;"
                                            type="button">
                                    <span style="margin-right: 8px;" data-testid="Icon" class="" type="Icon"><svg
                                            class="widget-svg"
                                            width="20"
                                            fill="{{isset($setting->header_button_text_color)?$setting->header_button_text_color:'white'}}"
                                            height="20" viewBox="0 0 20 20" aria-hidden="true"><g
                                                id="Layer_4"><path
                                                    d="M11,12.3V13c0,0-1.8,0-2,0v-0.6c0-0.6,0.1-1.4,0.8-2.1c0.7-0.7,1.6-1.2,1.6-2.1c0-0.9-0.7-1.4-1.4-1.4 c-1.3,0-1.4,1.4-1.5,1.7H6.6C6.6,7.1,7.2,5,10,5c2.4,0,3.4,1.6,3.4,3C13.4,10.4,11,10.8,11,12.3z"></path><circle
                                                    cx="10" cy="15" r="1"></circle><path
                                                    d="M10,2c4.4,0,8,3.6,8,8s-3.6,8-8,8s-8-3.6-8-8S5.6,2,10,2 M10,0C4.5,0,0,4.5,0,10s4.5,10,10,10s10-4.5,10-10S15.5,0,10,0 L10,0z"></path></g></svg></span>
                                        <b class="launcher_label_text">{{isset($setting->launcher_label)?$setting->launcher_label:'Need Help?'}}</b>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-3">

                        <div class="card-body">
                            <div style="min-height: 120px;background-color: white;">
                                <div class="card widget-view-form" style="border-radius: 10px;">
                                    <div class="card-header custom-head"
                                         style="border-radius:10px 10px 0 0;background: {{isset($setting->header_button_bg_color)?$setting->header_button_bg_color:'rgb(23, 73, 77)'}} ;">
                                        <p class="text-center custom-head-p">
{{--                                           style="color: {{isset($setting->header_button_text_color)?$setting->header_button_text_color:'white'}} ;">--}}
                                            <b class="contact_form_title_text">{{isset($setting->contact_form_title)?$setting->contact_form_title:'Feedback'}}</b>
                                        </p>
                                    </div>
                                    <div class="card-body custom-body"
                                         style="min-height: 120px;background: {{isset($setting->body_bg_color)?$setting->body_bg_color:'white'}};">
                                        <div class="form-group">

                                            {{--    color: {{isset($setting->body_text_color)?$setting->body_text_color:'black'}} !important;--}}
                                            <p style=""><b>Your name </b><span>(optional)</span></p>
                                            <input class="form-control mt-4">
                                        </div>
                                        <div class="form-group mt-4">
                                            {{--                                            color: {{isset($setting->body_text_color)?$setting->body_text_color:'black'}} !important;--}}
                                            <p style=""><b>Email address</b></p>
                                            <input class="form-control mt-4">
                                        </div>
                                        <div class="form-group mt-4">
                                            {{--                                            color: {{isset($setting->body_text_color)?$setting->body_text_color:'black'}} !important;--}}
                                            <p style=""><b>How can we help you?</b></p>
                                            <textarea rows="5" class="form-control mt-4"></textarea>
                                        </div>
                                        <div class="form-group mt-4">
                                            {{--                                            color: {{isset($setting->body_text_color)?$setting->body_text_color:'black'}} !important;--}}
                                            <p style=""><b>Attachments</b></p>
                                            <button type="button" id="dropzone-input" role="button"
                                                    aria-label="Attachments"
                                                    aria-describedby="attachmentButtonDescription"
                                                    class="styles__AttachmentButton-sc-o76a7f-0 kEOBdL">
                                                <div class="styles__Description-sc-o76a7f-1 eiBYcC">
                                                    <svg style="margin-top: 3px;" width="16" height="16"
                                                         viewBox="0 0 16 16"
                                                         class="styles__Icon-sc-o76a7f-3 gVBZh">
                                                        <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                              d="M9.5 4v7.7c0 .8-.7 1.5-1.5 1.5s-1.5-.7-1.5-1.5V3C6.5 1.6 7.6.5 9 .5s2.5 1.1 2.5 2.5v9c0 1.9-1.6 3.5-3.5 3.5S4.5 13.9 4.5 12V4"></path>
                                                    </svg>
                                                    <div id="attachmentButtonDescription"
                                                         class="styles__Label-sc-o76a7f-2 blfOQk">Add up to 5 files
                                                    </div>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                    <div
                                        class="card-footer custom-footer d-flex p-4 align-items-end justify-content-end"
                                        style="background: {{isset($setting->body_bg_color)?$setting->body_bg_color:'white'}} !important; border-radius: 0 0 10px 10px !important;">
                                        <button
{{--                                            color: {{isset($setting->header_button_text_color)?$setting->header_button_text_color:'white'}} ;--}}
                                            style="background: {{isset($setting->header_button_bg_color)?$setting->header_button_bg_color:'rgb(23, 73, 77)'}} ;"
                                            class="btn send-btn contact-btton">Send
{{--                                            {{isset($setting->contact_button)?$setting->contact_button:'Send'}}--}}
                                        </button>
                                        <input type="file" multiple="" data-testid="dropzone-input"
                                               class="styles__HiddenInput-sc-ty3c29-0 iquIjP">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

<style>
    td {
        vertical-align: middle !important;
    }

</style>
{{--    datepicker js--}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script src="{{asset('custom_assets/js/app_custom.js')}}"></script>
@section('script')
    <script type="text/javascript" src="{{asset('coloris/dist/coloris.min.js')}}"></script>
    <script type="text/javascript">

        Coloris({
            el: '.coloris',
            swatches: [
                '#264653',
                '#2a9d8f',
                '#e9c46a',
                '#f4a261',
                '#e76f51',
                '#d62828',
                '#023e8a',
                '#0077b6',
                '#0096c7',
                '#00b4d8',
                '#48cae4'
            ]
        });

    </script>
    <script>
        $(document).ready(function () {

        });
    </script>
@endsection
