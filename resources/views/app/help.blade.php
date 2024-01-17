@extends('app.layout.default')
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
    <div class="container mt-4" style="max-width: 60% !important;min-height: 520px" >
        <div class="d-flex justify-content-between align-items-center"
             style="margin: 24px 0 17px -11px;">
            <h5 style="margin-bottom: 0 !important;">Help and Support</h5>
        </div>
        <div class="row pt-2">
            <div class="col-lg-6 col-md-6 px-0">
                <div class="card bg-transparent">
                    <div class="card-body position-relative" style="min-height: 250px;">

                        <img class="position-absolute" style="    max-width: 80px;
    right: -6px;
    top: 0px;" src="{{asset('bulb.png')}}">
                        <div class="position-absolute pr-2" style="    bottom: 25px;">
                            <h5>Learn</h5>
                            <p>Find helpful information about the app become an expert user.</p>
{{--                            https://webinopoly.zendesk.com/hc/en-us/articles/4408762264471-Shopify-Speed-Booster-App--}}
                            <a href="https://webinopoly.zendesk.com/hc/en-us/" target="_blank" class="btn btn-primary">Help center</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 px-0">
                <div class="card bg-transparent">
                    <div class="card-body position-relative" style="min-height: 250px;">
                        <img class="position-absolute" style="   max-width: 80px;
    right: 5px;
    top: -6px;" src="{{asset('message.png')}}">
                        <div class="position-absolute pr-3" style="    bottom: 25px;">
                            <h5>Get Support</h5>
                            <p>Having trouble? We're here to point you in the right direction and ensure Customer Fields is running smoothly on your store.</p>
                            <div class="btn-group">
{{--                                mailto:support@webinopoly.com--}}
                                <a href="mailto:support@webinopoly.com" target="_blank" class="btn btn-primary">Email</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-lg-12 col-md-12 px-0">
                <div class="card">
                    <div class="card-body">
                        <h5>WORK WITH US</h5>
                        <p>Customer Fields is a robust platform and with a little custom development, we can accomplish nearly anything you can dream up.</p>
                        <a target="_blank" href="https://webinopoly.com/" class="btn btn-primary">View services</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
<style>
    .min-max-w-220 {
        min-width: 220px !important;
        max-width: 220px !important;
    }

</style>
@section('js_after')
    <script>
        $(document).ready(function () {
        });
    </script>
@endsection
