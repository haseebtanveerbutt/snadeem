@extends('adminpanel.layout.default')
@section('content')
    <div class="container">

        <div class="col-lg-12 col-md-12 p-4">
            <!-- start info box -->
            <div class="row mt-0">
                <div class="col-md-12 pl-3 " style="margin: auto;">
                    <div class="d-flex justify-content-between mb-4">
                        <h5 style="margin-bottom: 0 !important;">Questions</h5>
                        <button type="button" data-toggle="modal" data-target="#AddQuestionModal"
                                class="btn btn-sm btn-primary">Add Question
                        </button>
                    </div>
                    <div class="card" style="width: 100%">

                            {{--                              Modal--}}
                            <div aria-hidden="true" class="modal fade" id="AddQuestionModal" role="dialog"
                                 tabindex="-1">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Add Question</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <form action="{{Route('question-save')}}" method="post">
                                            @csrf

                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label class="text-left"
                                                           for="#">Label</label>
                                                    <input required name="label" type="text" class="form-control name">
                                                </div>
                                                <div class="form-group">
                                                    <label class="text-left"
                                                           for="#">Placeholder</label>
                                                    <input name="placeholder"  type="text" class="form-control name">
                                                </div>
                                                <div class="form-group">
                                                    <label class="text-left" for="#">Type</label>
                                                    <select name="type" class="form-control">
                                                        <option value="Input Text" selected>Input Text</option>
                                                        <option value="Input Email">Input Email</option>
                                                        <option value="Textarea">Textarea</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
                                                    Close
                                                </button>
                                                <button type="submit" class="SaveRule btn btn-primary btn-sm">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{--                              Modal End--}}



                        <div class="card-body">
                            <div id="product_append">
                                <div class="row px-3" style="overflow-x:auto;margin-top: 0;margin-bottom: 0;">

                                    <table id="datatabled" class="table table-borderless  table-hover  table-class ">
                                        <thead class="border-0 ">

                                        <tr class="th-tr table-tr text-center">
                                            <th class="font-weight-bold ">Label</th>
                                            <th class="font-weight-bold ">Placeholder</th>
                                            <th class="font-weight-bold ">Type</th>
                                            <th class="font-weight-bold " style="width: 10%">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        {{--                                        @dd($users_data)--}}
                                        @if($questions->count())
                                            @foreach($questions as $key=>$question)

                                                <tr class="td-text-center">
                                                    <td>
                                                        {{$question->label}}
                                                    </td>
                                                    <td>
                                                        {{$question->placeholder}}
                                                    </td>
                                                    <td>
                                                        {{ $question->type }}
                                                    </td>
                                                    <td>
                                                        <div class="btn-group btn-group-sm float-right" role="group"
                                                             aria-label="Basic example">
                                                            <button type="button"
                                                                    class="btn  w-100 btn-sm btn-primary edit-package"
                                                                    data-toggle="modal"
                                                                    data-target="#EditQuestionModal{{$key}}">Edit
                                                            </button>
                                                            {{--                              Modal--}}
                                                            <div aria-hidden="true" class="modal fade edit-package"
                                                                 id="EditQuestionModal{{$key}}" role="dialog"
                                                                 tabindex="-1">
                                                                <div class="modal-dialog modal-lg" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"
                                                                                id="exampleModalLabel">
                                                                                Edit Question</h5>
                                                                            <button type="button" class="close"
                                                                                    data-dismiss="modal"
                                                                                    aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>

                                                                        <form
                                                                            action="{{Route('edit-question-save', $question->id)}}"
                                                                            method="post">
                                                                            @csrf
                                                                            <div class="modal-body">
                                                                                <div class="form-group">
                                                                                    <label class="text-left"
                                                                                           for="#">Label</label>
                                                                                    <input name="label" required value="{{isset($question->label)?$question->label:null}}" type="text" class="form-control name">
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label class="text-left"
                                                                                           for="#">Placeholder</label>
                                                                                    <input name="placeholder"  value="{{isset($question->placeholder)?$question->placeholder:null}}" type="text" class="form-control name">
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label class="text-left" for="#">Type</label>
                                                                                    <select name="type"
                                                                                            class="form-control">
                                                                                        <option
                                                                                            @if(isset($question->type) && $question->type == "Input Text") selected
                                                                                            @endif value="Input Text">
                                                                                            Input Text
                                                                                        </option>
                                                                                        <option
                                                                                            @if(isset($question->type) && $question->type == "Input Email") selected
                                                                                            @endif  value="Input Email">
                                                                                            Input Email
                                                                                        </option>
                                                                                        <option
                                                                                            @if(isset($question->type) && $question->type == "Textarea") selected
                                                                                            @endif  value="Textarea">
                                                                                            Textarea
                                                                                        </option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                        class="btn btn-danger btn-sm"
                                                                                        data-dismiss="modal">Close
                                                                                </button>
                                                                                <button type="submit"
                                                                                        class="SaveRule btn btn-primary btn-sm">
                                                                                    Save
                                                                                </button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{--                              Modal End--}}

                                                            <button type="submit" data-toggle="modal"
                                                                    data-target="#delete_question{{$key}}"
                                                                    class="btn btn-sm btn-danger w-100 DeleteBtn">Delete
                                                            </button>
                                                            <div class="modal fade" id="delete_question{{$key}}"
                                                                 style=" margin-top: 30px;" tabindex="-1"
                                                                 aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-scrollable ">
                                                                    <div class="modal-content">
                                                                        <form method="post"
                                                                              action="{{route('delete-question',$question->id)}}">
                                                                            @csrf
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">Delete
                                                                                    Question</h5>
                                                                                <button type="button" class="close"
                                                                                        data-dismiss="modal"
                                                                                        aria-label="Close">&times;
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="row my-3">
                                                                                    <div class="col-md-12">
                                                                                        <p style="font-size: 16px;">Are
                                                                                            you
                                                                                            sure you want to delete
                                                                                            question?</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                        class="btn btn-danger btn-sm"
                                                                                        data-dismiss="modal">Close
                                                                                </button>
                                                                                <button type="submit"
                                                                                        class="btn  btn-sm btn-primary">
                                                                                    Yes
                                                                                </button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        @else
                                            <tr>
                                                <td colspan="4" class="text-center">
                                                    -- No Questions Found
                                                </td>
                                            </tr>
                                        @endif
                                    </table>
                                    {{--                                {!!  $customers_data->links() !!}--}}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
