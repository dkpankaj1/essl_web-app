<x-app-layout>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a href="{{route('report.create')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>

    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Device ({{$setting->machine_ip}})</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $setting->serial_no }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-server fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Employee</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\Employee::count()}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                               Log Count</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\AttendanceLog::count()}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Current Shift</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $setting->start_time }} -
                                {{ $setting->end_time }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-md-6">
            <!-- Illustrations -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Illustrations</h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;"
                            src="img/undraw_posting_photo.svg" alt="...">
                    </div>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Error placeat sint assumenda beatae
                        quos nesciunt aliquam, reiciendis eveniet eius ut. Quibusdam nemo rem culpa maiores enim
                        recusandae, quam quaerat illum soluta, vitae aspernatur a. Quae voluptas eum, incidunt aliquam
                        tempora ex fugiat optio deserunt, id dicta quidem corporis minima odit dolore ullam. Sed, cumque
                        nam. Minima iste laborum excepturi impedit quia optio possimus suscipit recusandae error
                        dolorem, provident accusantium pariatur. Cupiditate accusamus, mollitia, placeat nam ut aut ad
                        architecto temporibus rerum perspiciatis, minus aspernatur omnis pariatur possimus? Est nihil
                        enim, amet hic at provident, distinctio vero molestiae possimus dolorem impedit!</p>

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <!-- Approach -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Development Approach</h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;"
                            src="img/undraw_posting_photo.svg" alt="...">
                    </div>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Error placeat sint assumenda beatae
                        quos nesciunt aliquam, reiciendis eveniet eius ut. Quibusdam nemo rem culpa maiores enim
                        recusandae, quam quaerat illum soluta, vitae aspernatur a. Quae voluptas eum, incidunt aliquam
                        tempora ex fugiat optio deserunt, id dicta quidem corporis minima odit dolore ullam. Sed, cumque
                        nam. Minima iste laborum excepturi impedit quia optio possimus suscipit recusandae error
                        dolorem, provident accusantium pariatur. Cupiditate accusamus, mollitia, placeat nam ut aut ad
                        architecto temporibus rerum perspiciatis, minus aspernatur omnis pariatur possimus? Est nihil
                        enim, amet hic at provident, distinctio vero molestiae possimus dolorem impedit!</p>
                </div>
            </div>
        </div>

    </div>

</x-app-layout>
