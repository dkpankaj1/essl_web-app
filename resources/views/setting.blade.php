<x-app-layout>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Settings</h1>
    </div>

    <form action="{{ route('setting') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Appcation Setting</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="company_name">Company Name</label>
                            <input type="text" name="company_name" class="form-control"
                                value="{{ old('company_name', $setting->company_name) }}">
                            @error('company_name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="machine_ip">Machine ip</label>
                            <input type="text" name="machine_ip" class="form-control"
                                value="{{ old('machine_ip', $setting->machine_ip) }}">
                            @error('machine_ip')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="start_time">Start Time</label>
                            <input type="time" name="start_time" class="form-control"
                                value="{{ old('start_time', $setting->start_time) }}">
                            @error('start_time')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="punch_start_before">Punch start before (min)</label>
                            <input type="number" name="punch_start_before" class="form-control"
                                value="{{ old('punch_start_before', $setting->punch_start_before) }}">
                            @error('punch_start_before')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="end_time">End time </label>
                            <input type="time" name="end_time" class="form-control"
                                value="{{ old('end_time', $setting->end_time) }}">
                            @error('end_time')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="punch_end_after">Punch end after (min)</label>
                            <input type="number" name="punch_end_after" class="form-control"
                                value="{{ old('punch_end_after', $setting->punch_end_after) }}">
                            @error('punch_end_after')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="punch_end_after">Mode</label>
                            <select name="report_mode" class="form-control">
                                <option value="">--select--</option>
                                <option value="0" @if ($setting->report_mode == 0) selected @endif>Single Punch
                                </option>
                                <option value="1" @if ($setting->report_mode == 1) selected @endif>In-Out Punch
                                </option>
                            </select>
                            @error('report_mode')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <div class="col-md-8 d-flex justify-content-center align-items-center">
                        <img src="{{ asset('img/undraw_posting_photo.svg') }}" alt="banner" class="img-fluid"
                            style="height: 200px">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary px-4">Update</button>
            </div>
        </div>
    </form>

</x-app-layout>
