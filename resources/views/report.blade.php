<x-app-layout>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Report</h1>
    </div>

    <form action="{{ route('report.generate') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Generate Report</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        
                        <div class="form-group">
                            <label for="report_type">Report Type</label>
                            <select class="form-control" name="report_type">
                                <option value="">-- Select Report --</option>
                                <option value="1" @if (old('report_type') === '1') selected @endif>Attendance
                                    Report</option>
                                <option value="2" @if (old('report_type') === '2') selected @endif>Detail Report
                                </option>
                            </select>
                            @error('report_type')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" name="start_date" class="form-control"
                                value="{{ old('start_date') }}">
                            @error('start_date')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}">
                            @error('end_date')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary px-4">Generate</button>
            </div>
        </div>
    </form>
</x-app-layout>
