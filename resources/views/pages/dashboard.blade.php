@extends('layout.master')

@section('content')
<body class="g-sidenav-show  bg-gray-200">

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dashboard</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">Dashboard</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            {{-- <div class="input-group input-group-outline">
              <label class="form-label">Type here...</label>
              <input type="text" class="form-control">
            </div> --}}
          </div>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">weekend</i>
              </div>
              @php
                  $user = \Auth::user();
              @endphp
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">@if($user->type == "admin") Total Sale @else Total <br>Discounted Amount @endif</p>
                @php
                  $totalSale = 0;
                @endphp
                <h4 class="mb-0">{{ "Rs. ". $totalSale }}</h4>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">point_of_sales</i>
              </div>
              <div class="text-end pt-1">
                @php
                  $todaySale = 0;
                @endphp
                <p class="text-sm mb-0 text-capitalize"><br>Today's Sale</p>
                <h4 class="mb-0">{{ "Rs. ". $todaySale}}</h4>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">person</i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize"><br>Customers</p>
                <h4 class="mb-0">  10 </h4>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">pending</i>
              </div>
              @php
              $pendingAmount = 0;
              @endphp
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize"> @if($user->type == "admin") Account Receivable @else Today's <br>Discounted Amount @endif</p>
                <h4 class="mb-0">{{"Rs. ". $pendingAmount}}</h4>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col-lg-4 col-md-6 mt-4 mb-4">
          <div class="card z-index-2 ">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
              <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                <div class="chart">
                  <canvas id="chart-bars" class="chart-canvas" height="170"></canvas>
                </div>
              </div>
            </div>
            <div class="card-body">
              <h6 class="mb-0 ">Favourite Products</h6>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 mt-4 mb-4">
          <div class="card z-index-2  ">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
              <div class="bg-gradient-success shadow-success border-radius-lg py-3 pe-1">
                <div class="chart">
                  <canvas id="chart-orders" class="chart-canvas" height="170"></canvas>
                </div>
              </div>
            </div>
            <div class="card-body">
              <h6 class="mb-0 "> Last 5 Days Sale </h6>
            </div>
          </div>
        </div>
        <div class="col-lg-4 mt-4 mb-3">
          <div class="card z-index-2 ">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
              <div class="bg-gradient-dark shadow-dark border-radius-lg py-3 pe-1">
                <div class="chart">
                  <canvas id="chart-year" class="chart-canvas" height="170"></canvas>
                </div>
              </div>
            </div>
            <div class="card-body">
              <h6 class="mb-0 ">Year Sales</h6>
            </div>
          </div>
        </div>
      </div>
      @include('layout.footer')
    </div>
  </main>
 

  @endsection
  @section('js')

  <script src="{{asset('assets/js/plugins/chartjs.min.js')}}"></script>
  <script>
    var ctx = document.getElementById("chart-bars").getContext("2d");

    // new Chart(ctx, {
    //   type: "bar",
    //   data: {
    //     labels: ,
    //     datasets: [{
    //       label: "Sales",
    //       tension: 0.4,
    //       borderWidth: 0,
    //       borderRadius: 4,
    //       borderSkipped: false,
    //       backgroundColor: "rgba(255, 255, 255, .8)",
    //       data: ,
    //       maxBarThickness: 6
    //     }, ],
    //   },
    //   options: {
    //     responsive: true,
    //     maintainAspectRatio: false,
    //     plugins: {
    //       legend: {
    //         display: false,
    //       }
    //     },
    //     interaction: {
    //       intersect: false,
    //       mode: 'index',
    //     },
    //     scales: {
    //       y: {
    //         grid: {
    //           drawBorder: false,
    //           display: true,
    //           drawOnChartArea: true,
    //           drawTicks: false,
    //           borderDash: [5, 5],
    //           color: 'rgba(255, 255, 255, .2)'
    //         },
    //         ticks: {
    //           suggestedMin: 0,
    //           suggestedMax: 500,
    //           beginAtZero: true,
    //           padding: 10,
    //           font: {
    //             size: 14,
    //             weight: 300,
    //             family: "Roboto",
    //             style: 'normal',
    //             lineHeight: 2
    //           },
    //           color: "#fff"
    //         },
    //       },
    //       x: {
    //         grid: {
    //           drawBorder: false,
    //           display: true,
    //           drawOnChartArea: true,
    //           drawTicks: false,
    //           borderDash: [5, 5],
    //           color: 'rgba(255, 255, 255, .2)'
    //         },
    //         ticks: {
    //           display: true,
    //           color: '#f8f9fa',
    //           padding: 10,
    //           font: {
    //             size: 14,
    //             weight: 300,
    //             family: "Roboto",
    //             style: 'normal',
    //             lineHeight: 2
    //           },
    //         }
    //       },
    //     },
    //   },
    // });

    var ctx2 = document.getElementById("chart-orders").getContext("2d");

    // new Chart(ctx2, {
    //   type: "bar",
    //   data: {
    //     labels: ,
    //     datasets: [{
    //       label: "Sales",
    //       tension: 0.4,
    //       borderWidth: 0,
    //       borderRadius: 4,
    //       borderSkipped: false,
    //       backgroundColor: "rgba(255, 255, 255, .8)",
    //       data: ,
    //       maxBarThickness: 6
    //     }, ],
    //   },
    //   options: {
    //     responsive: true,
    //     maintainAspectRatio: false,
    //     plugins: {
    //       legend: {
    //         display: false,
    //       }
    //     },
    //     interaction: {
    //       intersect: false,
    //       mode: 'index',
    //     },
    //     scales: {
    //       y: {
    //         grid: {
    //           drawBorder: false,
    //           display: true,
    //           drawOnChartArea: true,
    //           drawTicks: false,
    //           borderDash: [5, 5],
    //           color: 'rgba(255, 255, 255, .2)'
    //         },
    //         ticks: {
    //           suggestedMin: 0,
    //           suggestedMax: 500,
    //           beginAtZero: true,
    //           padding: 10,
    //           font: {
    //             size: 14,
    //             weight: 300,
    //             family: "Roboto",
    //             style: 'normal',
    //             lineHeight: 2
    //           },
    //           color: "#fff"
    //         },
    //       },
    //       x: {
    //         grid: {
    //           drawBorder: false,
    //           display: true,
    //           drawOnChartArea: true,
    //           drawTicks: false,
    //           borderDash: [5, 5],
    //           color: 'rgba(255, 255, 255, .2)'
    //         },
    //         ticks: {
    //           display: true,
    //           color: '#f8f9fa',
    //           padding: 10,
    //           font: {
    //             size: 14,
    //             weight: 300,
    //             family: "Roboto",
    //             style: 'normal',
    //             lineHeight: 2
    //           },
    //         }
    //       },
    //     },
    //   },
    // });

    var ctx3 = document.getElementById("chart-year").getContext("2d");

    // new Chart(ctx3, {
    //   type: "bar",
    //   data: {
    //     labels: ,
    //     datasets: [{
    //       label: "Sales",
    //       tension: 0.4,
    //       borderWidth: 0,
    //       borderRadius: 4,
    //       borderSkipped: false,
    //       backgroundColor: "rgba(255, 255, 255, .8)",
    //       data: ,
    //       maxBarThickness: 6
    //     }, ],
    //   },
    //   options: {
    //     responsive: true,
    //     maintainAspectRatio: false,
    //     plugins: {
    //       legend: {
    //         display: false,
    //       }
    //     },
    //     interaction: {
    //       intersect: false,
    //       mode: 'index',
    //     },
    //     scales: {
    //       y: {
    //         grid: {
    //           drawBorder: false,
    //           display: true,
    //           drawOnChartArea: true,
    //           drawTicks: false,
    //           borderDash: [5, 5],
    //           color: 'rgba(255, 255, 255, .2)'
    //         },
    //         ticks: {
    //           suggestedMin: 0,
    //           suggestedMax: 500,
    //           beginAtZero: true,
    //           padding: 10,
    //           font: {
    //             size: 14,
    //             weight: 300,
    //             family: "Roboto",
    //             style: 'normal',
    //             lineHeight: 2
    //           },
    //           color: "#fff"
    //         },
    //       },
    //       x: {
    //         grid: {
    //           drawBorder: false,
    //           display: true,
    //           drawOnChartArea: true,
    //           drawTicks: false,
    //           borderDash: [5, 5],
    //           color: 'rgba(255, 255, 255, .2)'
    //         },
    //         ticks: {
    //           display: true,
    //           color: '#f8f9fa',
    //           padding: 10,
    //           font: {
    //             size: 14,
    //             weight: 300,
    //             family: "Roboto",
    //             style: 'normal',
    //             lineHeight: 2
    //           },
    //         }
    //       },
    //     },
    //   },
    // });
  </script>
@endsection