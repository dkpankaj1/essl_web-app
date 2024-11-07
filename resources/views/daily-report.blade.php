<x-app-layout>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daily Report</h1>
    </div>

    <form action="{{ route('report.today') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Generate Daily Report</h6>
            </div>
            <div class="card-body">
                <p>A daily report provides a concise summary of key activities, progress, and issues encountered within
                    a single day. It helps track accomplishments, outstanding tasks, and future actions, offering clear
                    visibility into daily operations. This report aids in team alignment, productivity assessment, and
                    supports effective decision-making for ongoing projects.</p>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary px-4">Generate</button>
            </div>
        </div>
    </form>
</x-app-layout>
