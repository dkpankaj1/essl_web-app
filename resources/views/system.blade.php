<x-app-layout>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">System</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">

                <!-- Optimize Section -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card mb-4 py-3 border-left-secondary">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Optimize</div>
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-success px-4"
                                        onclick="confirmAction('optimize')">Run</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Clear Employee DB Section -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card mb-4 py-3 border-left-secondary">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">clearEmployeeDB</div>
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-success px-4"
                                        onclick="confirmAction('clearEmployeeDB')">Run</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Clear Attendance DB Section -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card mb-4 py-3 border-left-secondary">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">clearAttendanceDB</div>
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-success px-4"
                                        onclick="confirmAction('clearAttendanceDB')">Run</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Optimize Section -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card mb-4 py-3 border-left-danger">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Clear Attendance Log From Device
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-danger px-4" data-toggle="modal"
                                        data-target="#confirmDeleteModal">
                                        Run
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Confirmation Form -->
    <form id="confirmDeleteForm" action="{{ route('biometric.clear-log') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog"
        aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Action</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to clear the biometric log? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteButton">Confirm</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Bootstrap Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="confirmModalLabel">Warning</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to proceed with this action? This action is irreversible.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmBtn"
                        onclick="executeAction()">Proceed</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Modal -->
    <div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="infoModalLabel">Action Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Message will be displayed here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    @push('page-js')
        <script>
            document.getElementById('confirmDeleteButton').addEventListener('click', function() {
                document.getElementById('confirmDeleteForm').submit();
            });
        </script>

        <script>
            let action = '';
            let infoModal = new bootstrap.Modal(document.getElementById('infoModal'));

            // Function to open the modal with the specific action
            function confirmAction(actionType) {
                action = actionType; // Store the action type
                let message = '';

                // Define the confirmation message based on the action
                if (action === 'optimize') {
                    message = 'Are you sure you want to run Optimize? This may take some time.';
                } else if (action === 'clearEmployeeDB') {
                    message = 'Warning: This will clear all employee data! Do you want to continue?';
                } else if (action === 'clearAttendanceDB') {
                    message = 'Warning: This will delete all attendance records! Do you want to continue?';
                }

                // Update the modal message
                document.querySelector('.modal-body').textContent = message;

                // Show the confirmation modal
                new bootstrap.Modal(document.getElementById('confirmModal')).show();
            }

            // Function to execute the action when the user confirms
            function executeAction() {
                let url = '';
                if (action === 'optimize') {
                    url = '{{ route('system.optimize-clear') }}';
                } else if (action === 'clearEmployeeDB') {
                    url = '{{ route('system.clear-employee-db') }}';
                } else if (action === 'clearAttendanceDB') {
                    url = '{{ route('system.clear-attendance-db') }}';
                }

                // Send the POST request
                fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({}),
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Show success message in the info modal
                        document.querySelector('#infoModal .modal-body').textContent = data.message;
                        infoModal.show(); // Show the info modal
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // Show error message in the info modal
                        document.querySelector('#infoModal .modal-body').textContent = 'Something went wrong!';
                        infoModal.show(); // Show the info modal
                    });
            }
        </script>
    @endpush


</x-app-layout>
