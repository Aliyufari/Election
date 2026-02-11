@extends('layouts.app')

@section('header')
  @include('partials.header')
@endsection

@section('sidebar')
  @include('partials.coordinator.sidebar')
@endsection

@section('content')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">
      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">

          <!-- Election Countdown Card - Full Width -->
          <div class="col-12 mb-4">
            <div class="card info-card border-0 shadow-sm p-3">
              <h5 class="card-title text-center mb-2 text-dark fw-bold" style="font-size: 1.5rem; line-height: 1.3;">
                2027 Nigerian National General Election
              </h5>              
              <div class="card-body d-flex align-items-center justify-content-around p-0 flex-wrap">
                <div class="d-flex flex-column align-items-center mx-2 my-2">
                  <h3 class="day fw-bold card-title count-number">00</h3>
                  <span class="count-label text-dark">Days</span>
                </div>
                <div class="d-flex flex-column align-items-center mx-2 my-2">
                  <h3 class="hour fw-bold card-title count-number">00</h3>
                  <span class="count-label text-dark">Hours</span>
                </div>
                <div class="d-flex flex-column align-items-center mx-2 my-2">
                  <h3 class="minute fw-bold card-title count-number">00</h3>
                  <span class="count-label text-dark">Minutes</span>
                </div>
                <div class="d-flex flex-column align-items-center mx-2 my-2">
                  <h3 class="second fw-bold card-title count-number">00</h3>
                  <span class="count-label text-dark">Seconds</span>
                </div>
              </div> 
            </div>
          </div><!-- End Election Countdown Card -->

          <!-- States Card -->
          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card info-card sales-card border-0 shadow-sm h-100">
              <div class="card-body d-flex align-items-center p-3">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; background: rgba(65, 84, 241, 0.1);">
                  <i class="bi bi-house text-primary" style="font-size: 1.5rem;"></i>
                </div>
                <div class="flex-grow-1">
                  <h6 class="card-title mb-1 small" style="font-size: 1rem;">States</h6>
                  <h4 class="fw-bold mb-0" style="font-size: 1.4rem;">19 and FCT Abuja</h4>
                </div>
              </div>
            </div>
          </div><!-- End States Card -->

          <!-- Zones Card -->
          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card info-card sales-card border-0 shadow-sm h-100">
              <div class="card-body d-flex align-items-center p-3">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; background: rgba(101, 31, 255, 0.1);">
                  <i class="bi bi-geo-alt text-purple" style="font-size: 1.5rem;"></i>
                </div>
                <div class="flex-grow-1">
                  <h6 class="card-title mb-1 small" style="font-size: 1rem;">Zones</h6>
                  <h4 class="fw-bold mb-0" style="font-size: 1.4rem;">108</h4>
                </div>
              </div>
            </div>
          </div><!-- End Zones Card -->

          <!-- LGAs Card -->
          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card info-card revenue-card border-0 shadow-sm h-100">
              <div class="card-body d-flex align-items-center p-3">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; background: rgba(46, 202, 106, 0.1);">
                  <i class="bi bi-shop text-success" style="font-size: 1.5rem;"></i>
                </div>
                <div class="flex-grow-1">
                  <h6 class="card-title mb-1 small" style="font-size: 1rem;">LGAs</h6>
                  <h4 class="fw-bold mb-0" style="font-size: 1.4rem;">774</h4>
                </div>
              </div>
            </div>
          </div><!-- End LGAs Card -->

          <!-- Supervisors Card -->
          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card info-card customers-card border-0 shadow-sm h-100">
              <div class="card-body d-flex align-items-center p-3">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; background: rgba(255, 119, 29, 0.1);">
                  <i class="bi bi-collection text-warning" style="font-size: 1.5rem;"></i>
                </div>
                <div class="flex-grow-1">
                  <h6 class="card-title mb-1 small" style="font-size: 1rem;">Wards</h6>
                  <h4 class="fw-bold mb-0" style="font-size: 1.4rem;">8,809</h4>
                </div>
              </div>
            </div>
          </div><!-- End Supervisors Card -->

          <!-- Reports -->
          <div class="col-12">
            <div class="card border-0 shadow-sm">
              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                  </li>
                  <li><a class="dropdown-item" href="#">Today</a></li>
                  <li><a class="dropdown-item" href="#">This Month</a></li>
                  <li><a class="dropdown-item" href="#">This Year</a></li>
                </ul>
              </div>
              <div class="card-body">
                <h5 class="card-title">CVR Analysis</h5>
                <!-- Line Chart -->
                <div id="reportsChart"></div>
                <script>
                  document.addEventListener("DOMContentLoaded", () => {
                    new ApexCharts(document.querySelector("#reportsChart"), {
                      series: [{
                        name: 'States',
                        data: [31, 40, 28, 51, 42, 82, 56],
                      }, {
                        name: 'LGAs',
                        data: [11, 32, 45, 32, 34, 52, 41]
                      }, {
                        name: 'CVRs',
                        data: [55, 61, 74, 105, 92, 105, 155]
                      }],
                      chart: {
                        height: 350,
                        type: 'area',
                        toolbar: {
                          show: false
                        },
                      },
                      markers: {
                        size: 4
                      },
                      colors: ['#4154f1', '#2eca6a', '#ff771d'],
                      fill: {
                        type: "gradient",
                        gradient: {
                          shadeIntensity: 1,
                          opacityFrom: 0.3,
                          opacityTo: 0.4,
                          stops: [0, 90, 100]
                        }
                      },
                      dataLabels: {
                        enabled: false
                      },
                      stroke: {
                        curve: 'smooth',
                        width: 2
                      },
                      xaxis: {
                        type: 'datetime',
                        categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z"]
                      },
                      tooltip: {
                        x: {
                          format: 'dd/MM/yy HH:mm'
                        },
                      }
                    }).render();
                  });
                </script>
                <!-- End Line Chart -->
              </div>
            </div>
          </div><!-- End Reports -->

        </div>
      </div><!-- End Left side columns -->
    </div>
  </section>
</main><!-- End #main -->

<style>
.text-purple {
  color: #6f42c1 !important;
}
.card {
  transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}
.card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
}
.count-number {
  font-size: 1.8rem;
  min-width: 60px;
  text-align: center;
}
.count-label {
  font-size: 0.9rem;
  font-weight: 500;
}

/* Mobile responsiveness */
@media (max-width: 768px) {
  .count-number {
    font-size: 1.5rem;
    min-width: 50px;
  }
  .count-label {
    font-size: 0.8rem;
  }
  .card-title {
    font-size: 1.2rem !important;
  }
}

@media (max-width: 576px) {
  .count-number {
    font-size: 1.3rem;
    min-width: 45px;
  }
  .count-label {
    font-size: 0.75rem;
  }
  .card-body {
    justify-content: center !important;
  }
  .mx-2 {
    margin-left: 0.5rem !important;
    margin-right: 0.5rem !important;
  }
}
</style>
@endsection

@section('footer')
  @include('partials.footer')
@endsection

@section('toast')
  @include('partials.toast')
@endsection