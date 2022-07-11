@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row mt-2">
        <div class="col-md-6">
            <div class="row">
                @can('do-admin-stuff')
                <div class="col-lg-6 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $userCount }}</h3>
                            <p>Users</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <a href="{{ route('user.index') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                @endcan
                <div class="@can('do-admin-stuff') col-lg-6 col-6 @else col-lg-12 col-12 @endcan">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $filecount }}</h3>
                            <p>Files</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-file"></i>
                        </div>
                        <a href="{{ route('file.index') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>

            @if ($filecount != 0)
            @can('do-admin-stuff')
            <div class="row">
                <div class="col-12 col-lg-12">
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">Files</h3>
                        </div>
                        <div class="card-body d-flex justify-content-center">
                            <div style="position: relative; width: 40vw">
                                <canvas id="myChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endcan
            @endif

            @cannot('do-admin-stuff')
            <div class="col-lg-12 col-12 px-0">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Calendar</h3>
                    </div>
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
            @endcannot
        </div>

        <div class="col-md-6">
            <div class="col-lg-12 col-12 px-0">
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">
                            Announcements
                        </h3>
                    </div>
                    <div class="card-body">
                        @can('do-admin-stuff')
                        <form action="{{ route('announcement.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="announcementDetailsTextArea" class="form-label">Post new
                                    announcement</label>
                                <textarea class="form-control" id="announcementDetailsTextArea" rows="3" name="details"
                                    required></textarea>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="sendSMS" value="sendSMS"
                                        id="sendSMS">
                                    <label class="form-check-label" for="sendSMS">
                                        Send as SMS
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary mb-4">Post</button>
                            </div>
                        </form>
                        @endcan
                        @forelse ($announcements as $announcement)
                        <div class="card">
                            <div class="card-body">
                                <h5>
                                    {{ $announcement->details }}
                                </h5>
                                <p class="text-muted">{{ $announcement->created_at->diffForHumans() }}</p>
                                @can('do-admin-stuff')
                                <form action="{{ route('announcement.destroy', $announcement->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i
                                            class="fas fa-trash"></i></button>
                                </form>
                                @endcan
                            </div>
                        </div>
                        @empty
                        <h5>No announcements to display</h5>
                        @endforelse
                    </div>
                </div>
            </div>
            @can('do-admin-stuff')
            <div class="col-lg-12 col-12 px-0">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Calendar</h3>
                    </div>
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
            @endcan
        </div>
    </div>
</div>
@endsection

@section('fullcalendar')
<script>
    console.log('{{ now()->format("Y-m-d") }}')

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        
        var calendar = new FullCalendar.Calendar(calendarEl, {
            themeSystem: 'bootstrap5',
            selectable: true,
            selectMinDistance: 2,
            dateClick: function(date) {
                console.log(date.dateStr);
            },
            select: function(date) {
                console.log(date.startStr + ' to ' + date.endStr);
            },
            initialView: 'dayGridMonth',
            initialDate: '{{ now()->format("Y-m-d") }}',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: [
                {
                    title: 'All Day Event',
                    start: '2022-06-30'
                },
            ]
        });
        calendar.render();
    });
</script>
@endsection

@section('scripts')
<script src="{{ asset('js/chartjs.js') }}"></script>

<script>
    const data = {
        labels: [
        @foreach ($roles as $role)
            '{{ $role->roleName }}',
        @endforeach
        ],
        datasets: [{
            label: 'Files',
            data: [
                @foreach ($count as $roleFileCount)
                    {{ $roleFileCount }},
                @endforeach
            ],
            backgroundColor: [
            'rgb(255, 99, 132)',
            'rgb(54, 162, 235)',
            'rgb(255, 205, 86)'
            ],
            hoverOffset: 4
        }]
    };

    const config = {
        type: 'pie',
        data: data,
        options: {
            responsive: true, 
            maintainAspectRatio: false,
        }
    };
</script>

<script>
    const myChart = new Chart(
        document.getElementById('myChart'),
        config
    );

</script>

@endsection