
@php $statuses = [1=>'Active', 0=>'Inactive']; @endphp

<div class="modal fade" id="detailsModel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-primary text-center">
                        
                        <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true"><i class="fas fa-times"></i></button>

                        <h4 class="card-title" id="modelHeading_data"></h4>
                    </div>
                </div>

                <div class="modal-body">

                    <div class="row form-group">
                        <div class="col-sm-12">
                            <h4>Content:</h2>
                            <div id="content_data"></div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-12 mt-5">
                            <h4>Description:</h2>
                            <div id="description_data"></div>
                        </div>
                    </div>

                </div>

  				<div class="modal-footer">
                    <button type="button" id="status_bar" class="btn me-auto">Status: <span id="status_data"></span></button>
                    
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            	</div>

        </div>
    </div>
    </div>
</div>
