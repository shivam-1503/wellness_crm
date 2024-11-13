    <!-- Invoice Modal Starts -->

    <style>
        .timeline {
            list-style: none;
            padding: 10px 0 10px;
            position: relative;
        }

        .timeline:before {
            top: 0;
            bottom: 0;
            position: absolute;
            content: " ";
            width: 3px;
            background-color: #eeeeee;
            left: 50%;
            margin-left: -1.5px;
        }

        .timeline>li {
            margin-bottom: 0x;
            position: relative;
        }

        .timeline>li:before,
        .timeline>li:after {
            content: " ";
            display: table;
        }

        .timeline>li:after {
            clear: both;
        }

        .timeline>li>.timeline-panel {
            width: 44%;
            float: left;
            border: 1px solid #d4d4d4;
            border-radius: 2px;
            padding: 10px;
            position: relative;
            -webkit-box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
            box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
        }

        .timeline>li>.timeline-panel:before {
            position: absolute;
            top: 26px;
            right: -15px;
            display: inline-block;
            border-top: 15px solid transparent;
            border-left: 15px solid #ccc;
            border-right: 0 solid #ccc;
            border-bottom: 15px solid transparent;
            content: " ";
        }

        .timeline>li>.timeline-panel:after {
            position: absolute;
            top: 27px;
            right: -14px;
            display: inline-block;
            border-top: 14px solid transparent;
            border-left: 14px solid #fff;
            border-right: 0 solid #fff;
            border-bottom: 14px solid transparent;
            content: " ";
        }

        .timeline>li>.timeline-badge {
            color: #fff;
            width: 50px;
            height: 50px;
            line-height: 50px;
            font-size: 1.4em;
            text-align: center;
            position: absolute;
            top: 16px;
            left: 50%;
            margin-left: -25px;
            background-color: #999999;
            z-index: 100;
            border-top-right-radius: 50%;
            border-top-left-radius: 50%;
            border-bottom-right-radius: 50%;
            border-bottom-left-radius: 50%;
        }

        .timeline>li.timeline-inverted>.timeline-panel {
            float: right;
        }

        .timeline>li.timeline-inverted>.timeline-panel:before {
            border-left-width: 0;
            border-right-width: 15px;
            left: -15px;
            right: auto;
        }

        .timeline>li.timeline-inverted>.timeline-panel:after {
            border-left-width: 0;
            border-right-width: 14px;
            left: -14px;
            right: auto;
        }

        .timeline-badge.primary {
            background-color: #008CBA !important;
        }

        .timeline-badge.success {
            background-color: #43AC6A !important;
        }

        .timeline-badge.warning {
            background-color: #E99002 !important;
        }

        .timeline-badge.danger {
            background-color: #F04124 !important;
        }

        .timeline-badge.info {
            background-color: #5BC0DE !important;
        }

        .timeline-title {
            margin-top: 0;
            color: inherit;
        }

        .timeline-body>p,
        .timeline-body>ul {
            margin-bottom: 0;
        }

        .timeline-body>p+p {
            margin-top: 5px;
        }


        cite {
            font-size: 0.8em;
            font-weight: 700;
            color: #bdbec0;
            float: right;
        }

        cite:before {
            content: '\2015'' ';
        }
    </style>

    <div class="modal fade" tabindex="-1" role="dialog" id="activityModal" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Activities</h5>
                    <div class="text-right">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
                <div class="modal-body">
                    <p>One fine body&hellip;</p>
                    
                    <div class="container">
                        <div class="page-header">
                            <h3 id="timeline" class="text-primary"></h3>
                            <small>
                                1200 Ridgecrest Blvd.<br />
                                Fayetteville, AR 72704
                            </small>
                        </div>
                        <ul class="timeline" id="timeline-content"></ul>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <!-- Invoice Modal Ends -->