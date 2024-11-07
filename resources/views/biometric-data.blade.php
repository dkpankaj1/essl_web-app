<x-app-layout>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Biometric</h1>
    </div>


    <div class="card">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Attendance Log</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-4 py-3 border-left-secondary">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        192.168.1.168 </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $setting->serial_no }} (<span
                                            id="bmStatus">Offline</span>)</div>
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-success px-4" id="checkStatusBtn">Status</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <hr>
                    <form action="{{ route('biometric.attendance-log') }}" method="POST">
                        @csrf
                        <button class="btn btn-primary btn-icon-split" type="submit">
                            <span class="icon text-white-50">
                                <i class="fas fa-check"></i>
                            </span>
                            <span class="text" id="downloadLogBtnTxt">Download</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('page-js')
        <script>
            $(document).ready(function() {
                const statusBtn = $('#checkStatusBtn');
                const bmStatus = $('#bmStatus');
                // Status button click handler
                if (statusBtn.length && bmStatus.length) {
                    statusBtn.click(function() {
                        bmStatus.html("Connecting...");

                        $.ajax({
                            url: "{{ route('biometric.status') }}",
                            type: "GET",
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                try {
                                    const resp = typeof response === "string" ? JSON.parse(
                                        response) : response;
                                    bmStatus.html(resp.status); // Update the status
                                } catch (e) {
                                    console.error("Error parsing response:", e);
                                    bmStatus.html("Error parsing response");
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.error("Request failed:", textStatus, errorThrown);
                                bmStatus.html("Request failed");
                            }
                        });
                    });
                }
            });
        </script>
    @endpush

</x-app-layout>
