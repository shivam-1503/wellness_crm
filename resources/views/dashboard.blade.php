@extends('layouts.app')

@section('content')

<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' />

<style>

    .icon {
        width: 2.5rem;
        height: 2.5rem;
        box-shadow: 0 0 15px 5px rgba(128, 128, 128, 0.25) !important;
    }

    .icon i {
        font-size: 1.5rem;
    }

    .icon-shape {
        display: inline-flex;
        padding: 12px;
        text-align: center;
        border-radius: 50%;
        align-items: center;
        justify-content: center;
    }

    .card-footer {
        padding: 0.5rem 1rem !important;
    }

</style>

<!-- - PAGE-HEADER -->
<div class="page-header">
    <div>
        <h1 class="page-title">Dashboard</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </div>

</div>
<!-- PAGE-HEADER END -->

<div class="jumbotron mb-5">
    <div class="card">
        <div class="card-body">
            <h4 class="display-6">{{ $notice->title }}</h4>
            <p class="lead">{{ $notice->description }}</p>
        </div>
    </div>
</div>


<div class="row mb-4">
    <div class="col-sm-12">
        <h4 class="badge bg-primary">My KRA Stats (Current Month):</h4>
    </div>

    @foreach($emp_stats as $stats)
    <div class="col-xl-3 col-lg-6 mb-3">
        <div class="card card-stats mb-4 mb-xl-0">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-muted mb-2">{{ $stats['title'] }}</h5>
                        <span class="h2 font-weight-bold mb-0">{{ $stats['data'] }}</span>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                            <i class="{{ $stats['icon'] }}"></i>
                        </div>
                    </div>
                </div>
                <!-- <p class="mt-3 mb-0 text-muted text-sm">
                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                    <span class="text-nowrap">Since last month</span>
                </p> -->
            </div>
        </div>
    </div>
    @endforeach

</div>

@php

    $performers = ['Suryadev Singh', 'Amarjeet Kaur', 'Shivam Kashyap'];

    $under_performers = ['Abhikansh Gupta', 'Mohit Nihaliya', 'Tushar Chaudhary'];

    $no_performers = ['Ayushi Gautam', 'Sonam Gupta', 'Akshay Ratra', 'Varsha']

@endphp

<div class="row">
    <div class="col-sm-12">
        <h4 class="badge bg-primary">Leaderboard:</h4>
    </div>


    <div class="col-md-4">
        <h4>Key Performer</h4>
        @foreach($performers as $obj)
        <div class="card mt-2" data-bs-toggle="tooltip" title="Key Performer!">
                <div class="card-body text-center">
        <div class="people row">
            <div class="col-md-3">
                <img src="{{ asset('backend_assets/images/users/default.png') }}" alt="profile-user" class="avatar  profile-user brround cover-image">
            </div>
            <div class="col-md-9">
                {{$obj}}
            </div>
        </div>
        </div>
        </div>
        @endforeach
    </div>

    <div class="col-md-4">
        <h4>Under Performer</h4>
        @foreach($under_performers as $obj)
        <div class="card mt-2" data-bs-toggle="tooltip" title="Under Performer!">
                <div class="card-body text-center">
        <div class="people row">
            <div class="col-md-3">
                <img src="{{ asset('backend_assets/images/users/default.png') }}" alt="profile-user" class="avatar  profile-user brround cover-image">
            </div>
            <div class="col-md-9">
                {{$obj}}
            </div>
        </div>
        </div>
        </div>
        @endforeach
    </div>

    <div class="col-md-4">
        <h4>No Performance</h4>
        @foreach($no_performers as $obj)
        <div class="card mt-2" data-bs-toggle="tooltip" title="No Performance!">
                <div class="card-body text-center">
        <div class="people row">
            <div class="col-md-3">
                <img src="{{ asset('backend_assets/images/users/default.png') }}" alt="profile-user" class="avatar  profile-user brround cover-image">
            </div>
            <div class="col-md-9">
                {{$obj}}
            </div>
            </div>
        </div>
        </div>
        @endforeach
    </div>


</div>


<hr>


<div class="row">
    <div class="col-sm-12">
        <h4 class="badge bg-primary">Leads Statistics:</h4>
    </div>
    


    @foreach($stages as $stage)
    
        {{-- <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
            <div class="card" data-bs-toggle="tooltip" title="Total Leads in {{$stage->name}} Stage!">
                <div class="card-body text-center">
                    <i class="far fa-bullhorn text-info fa-3x"></i>
                    <h6 class="mt-4 mb-2">{{$stage->name}}</h6>
                    <h4 class="mb-2 number-font">{{ $stage->lead_count }}</h4>

                </div>
            </div>
        </div>--}}


        @php $icon = $stage->icon ? $stage->icon : 'fas fa-chart-bar'; @endphp
        
        <div class="col-xl-3 col-lg-6 mb-3">
            <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-muted mb-2">{{$stage->name}}</h5>
                            <span class="h2 font-weight-bold mb-0">{{ $stage->lead_count }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                <i class="{{ $icon }}"></i>
                            </div>
                        </div>
                    </div>
                    <!-- <p class="mt-3 mb-0 text-muted text-sm">
                        <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                        <span class="text-nowrap">Since last month</span>
                    </p> -->
                </div>

                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="text-primary stretched-link" href="{{ url('leads?s='.$stage->id) }}">View Details</a>
                    <div class="text-primary">
                        <i class="fas fa-angle-right"></i>
                    </div>
                </div>
            </div>
        </div>
    
    @endforeach

</div>


<div class="row mt-5">

    <div class="col-sm-12">
        <h4 class="badge bg-primary">Business Statistics:</h4>
    </div>
        

    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
        <div class="card">
            <div class="card-body text-center">

                <i class="far fa-users text-primary fa-3x"></i>
                <h6 class="mt-4 mb-2">Total Customers</h6>
                <h4 class="mb-2 number-font">834</h4>

            </div>
        </div>
    </div><!-- COL END -->
    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-wallet text-success fa-3x"></i>
                <h6 class="mt-4 mb-2">Payments Received</h6>
                <h4 class="mb-2  number-font">20</h4>

            </div>
        </div>
    </div><!-- COL END -->
    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
        <div class="card">
            <div class="card-body text-center">
                <i class="far fa-money-bill text-secondary fa-3x"></i>
                <h6 class="mt-4 mb-2">Orders</h6>
                <h4 class="mb-2 number-font">20</h4>

            </div>
        </div>
    </div><!-- COL END -->
    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
        <div class="card">
            <div class="card-body text-center">
                <i class="far fa-list-ol text-info fa-3x"></i>
                <h6 class="mt-4 mb-2">Users</h6>
                <h4 class="mb-2  number-font">7</h4>

            </div>
        </div>
    </div><!-- COL END -->
</div>



<div class="row mt-5">

    <div class="col-sm-12">
        <h4 class="badge bg-primary">Leads Chart:</h4>
    </div>
        

    <div class="col-sm-12">
    
        <div class="card">
            <div class="card-body text-center">
                
                <div id="chart">

                </div>

            </div>
        </div>
    </div><!-- COL END -->
</div>

@endsection


@section('scripting')

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script type="text/javascript">

    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });



        var options = {
          series: [{
          // data: [21, 22, 10, 28, 16, 21, 13, 30]
          data: [],
        }],
          chart: {
          height: 350,
          type: 'bar',
          events: {
            click: function(chart, w, e) {
              // console.log(chart, w, e)
            }
          }
        },
        // colors: colors,
        plotOptions: {
          bar: {
            columnWidth: '45%',
            distributed: true,
          }
        },
        dataLabels: {
          enabled: false
        },
        legend: {
          show: false
        },
        xaxis: {
        //   categories: [
        //     ['John', 'Doe'],
        //     ['Joe', 'Smith'],
        //     ['Jake', 'Williams'],
        //     'Amber',
        //     ['Peter Brown'],
        //     ['Mary', 'Evans'],
        //     ['David', 'Wilson'],
        //     ['Lily', 'Roberts'], 
        //   ],
        categories: [],
          labels: {
            style: {
              // colors: colors,
              fontSize: '12px'
            }
          }
        }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();


        // var options = {
        //   series: [],
        //   chart: {
        //   height: 350,
        //   type: 'bar',
        // },
        // dataLabels: {
        //   enabled: false
        // },
        // title: {
        //   text: 'Ajax Example',
        // },
        // noData: {
        //   text: 'Loading...'
        // },
        // xaxis: {
        //   type: 'category',
        //   tickPlacement: 'on',
        //   labels: {
        //     rotate: -45,
        //     rotateAlways: true
        //   }
        // }
        // };

        // var chart = new ApexCharts(document.querySelector("#chart"), options);
        // chart.render();
    
        $.getJSON("{{ url('getStats') }}", function(response) {
            console.log(response.leads);
            // chart.updateSeries([
            //     {
            // name: 'Funnel',
            // data: response.leads,
            // categories: response.names
            // }
            // ])

            chart.updateOptions({
   xaxis: {
      categories: response.names
   },
   series: [{
      data: response.leads
   }],
});
        });

    });

</script>

@endsection