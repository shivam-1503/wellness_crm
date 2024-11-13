<div class="modal fade" id="socialDetailsModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="card card-signup card-plain">


                {{ Form::open(['id' => 'socialForm', 'name' => 'socialForm', 'class' => 'form-horizontal']) }}
                {{ csrf_field() }}
                

                <div class="modal-header">
                    <div class="card-header card-header-primary text-center" style="margin-top: -30px;">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                                class="fa fa-close"></i></button>
                        <h4 class="card-title" id="socialDetailModalHeading"></h4>
                    </div>
                </div>

                <div class="modal-body">

                    <!-- <p class="lead"> Project Details:</p> -->
                    <div class="row">

                        <div class="col-md-12">
                            <label for="facebook" class="col-form-label">Facebook <k>*</k></label>
                            {{ Form::text('facebook', '', ['class' => 'form-control', 'id' => 'facebook']) }}
                            <span class="text-danger" id="facebook-error"></span>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-12">
                            <label for="google_plus" class="col-form-label">Google+ <k>*</k></label>
                            {{ Form::text('google_plus', '', ['class' => 'form-control', 'id' => 'google_plus']) }}
                            <span class="text-danger" id="google_plus-error"></span>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-12">
                            <label for="instagram" class="col-form-label">Instagram <k>*</k></label>
                            {{ Form::text('instagram', '', ['class' => 'form-control', 'id' => 'instagram']) }}
                            <span class="text-danger" id="instagram-error"></span>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-12">
                            <label for="youtube" class="col-form-label">Youtube <k>*</k></label>
                            {{ Form::text('youtube', '', ['class' => 'form-control', 'id' => 'youtube']) }}
                            <span class="text-danger" id="youtube-error"></span>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-12">
                            <label for="linkedin" class="col-form-label">LinkedIn <k>*</k></label>
                            {{ Form::text('linkedin', '', ['class' => 'form-control', 'id' => 'linkedin']) }}
                            <span class="text-danger" id="linkedin-error"></span>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-12">
                            <label for="twitter" class="col-form-label">Twitter <k>*</k></label>
                            {{ Form::text('twitter', '', ['class' => 'form-control', 'id' => 'twitter']) }}
                            <span class="text-danger" id="twitter-error"></span>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-12">
                            <label for="google_business" class="col-form-label">Google Business <k>*</k></label>
                            {{ Form::text('google_business', '', ['class' => 'form-control', 'id' => 'google_business']) }}
                            <span class="text-danger" id="google_business-error"></span>
                        </div>

                    </div>


                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="modal">Close</button>
                    {!! Form::submit('Submit', ['class' => 'btn btn-primary', 'id' => 'BasicDetailsSaveBtn']) !!}

                </div>

                {!! Form::close() !!}

            </div>
        </div>
    </div>
</div>
