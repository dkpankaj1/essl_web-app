<x-app-layout>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Employee</h1>
    </div>


    <div class="card">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Employee List</h6>
            <div>
                <form action="{{ route('employee.sync') }}" method="POST">
                    @csrf
                    <button class="btn btn-success">Sync User</button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-ms">
                    <thead>
                        <tr>
                            <th>userid</th>
                            <th>name</th>
                            <th>role</th>
                            <th>password</th>
                            <th>cardno</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $employee)
                            <tr>
                                <td>{{ $employee->userid }}</td>
                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->role }}</td>
                                <td>{{ '********' }}</td>
                                <td>{{ $employee->cardno }}</td>
                                <td>
                                    <a class="btn btn-warning"
                                        href="{{ route('employee.edit', $employee->id) }}">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $employees->links() }}
        </div>
    </div>

    @push('page-js')
        <script>
            $(document).ready(function() {
                const statusBtn = $('#checkStatusBtn');
                const bmStatus = $('#bmStatus');
                const downloadLogBtn = $('#downloadLogBtn');
                const downloadLogBtnTxt = $('#downloadLogBtnTxt');
                const csrfToken = "{{ csrf_token() }}";

                // Status button click handler
                if (statusBtn.length && bmStatus.length) {
                    statusBtn.click(function() {
                        bmStatus.html("Connecting...");

                        $.ajax({
                            url: "{{ route('biometric.status') }}",
                            type: "GET",
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
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

                // Download log button click handler
                if (downloadLogBtn.length) {
                    downloadLogBtn.click(function() {
                        downloadLogBtnTxt.html("Please wait...");
                        $.ajax({
                            url: "{{ route('biometric.attendance-log') }}",
                            type: "POST",
                            data: {
                                '_token': csrfToken
                            },
                            success: function(response) {
                                try {
                                    const resp = typeof response === "string" ? JSON.parse(
                                        response) : response;
                                    downloadLogBtnTxt.html("Download Complete");
                                } catch (e) {
                                    console.error("Error parsing response:", e);
                                    downloadLogBtnTxt.html("Download Failed");
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.error("Request failed:", textStatus, errorThrown);
                                downloadLogBtnTxt.html("Download Failed");
                            }
                        });
                    });
                }

            });
        </script>
    @endpush

</x-app-layout>
