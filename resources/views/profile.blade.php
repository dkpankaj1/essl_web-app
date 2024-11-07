<x-app-layout>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Profile</h1>
    </div>

    <form action="{{ route('profile') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Profile Setting</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" class="form-control"
                                value="{{ old('email', $user->email) }}">
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <input type="text" name="current_password" class="form-control" placeholder="Enter current password">
                            @error('current_password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="start_time">password</label>
                            <input type="password" name="password" class="form-control" placeholder="Enter password">
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="punch_start_before">Confirm Password</label>
                            <input type="number" name="password_confirmation" class="form-control" placeholder="Confirm password">
                            @error('password_confirmation')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary px-4">Update</button>
            </div>
        </div>
    </form>

</x-app-layout>
