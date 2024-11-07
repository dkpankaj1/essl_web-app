<x-app-layout>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Employee</h1>
    </div>


    <div class="card">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Employee List</h6>
            <div class="d-flex">
                <form action="{{ route('employee.sync') }}" method="POST">
                    @csrf
                    <button class="btn btn-success btn-icon-split mx-1">
                        <span class="icon text-white-50">
                            <i class="fas fa-sync"></i>
                        </span>
                        <span class="text">Sync User</span>
                    </button>
                </form>

                <form action="{{ route('employee.export') }}" method="POST">
                    @csrf
                    <button class="btn btn-info btn-icon-split mx-1">
                        <span class="icon text-white-50">
                            <i class="fas fa-file-excel"></i>
                        </span>
                        <span class="text">Export</span>
                    </button>

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
                                    <button class="btn btn-danger deleteBtn"
                                        data-url="{{ route('employee.destroy', $employee->id) }}">Delete</button>
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

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this item?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
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
        <script>
            $(document).on('click', '.deleteBtn', function() {
                const url = $(this).data('url');
                $('#deleteForm').attr('action', url);
                $('#deleteModal').modal('show');
            });
        </script>
    @endpush

</x-app-layout>
