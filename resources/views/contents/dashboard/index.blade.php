@extends('layouts.main')

@section('css')
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet" />
@endsection


@section('content')
    <main class="content">
        <div class="container-fluid">
            <div class="row">
                <h1 class="dashboard fw-bold mb-3 px-0">Dashboard</h1>

                <div class="col-6 order-2 ps-1 pe-0">
                    <div class="dashboard-menu-box-2 d-flex justify-content-between py-2 px-2 px-sm-3">
                        <div>
                            <span class="fw-bold dashboard-stat-count">{{ $dashboard_data['total_book_borrowed'] }}</span>
                            <br />
                            <span class="dashboard-stat-text">Buku Dipinjam</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <img src="{{ Asset('img/icons/buku-dipinjam-icon.svg') }}" alt="buku-dipinjam"
                                class="dashboard-stat-image" />
                        </div>
                    </div>
                </div>

                <div class="col-6 order-1 pe-1 ps-0">
                    <div class="dashboard-menu-box-1 d-flex justify-content-between py-2 px-2 px-sm-3">
                        <div>
                            <span class="fw-bold dashboard-stat-count">{{ $dashboard_data['total_visitors'] }}</span>
                            <br />
                            <span class="dashboard-stat-text">Pengunjung</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <img src="{{ Asset('img/icons/pengunjung-icon.svg') }}" alt="pengunjung" class="dashboard-stat-image" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col px-2 px-sm-3 dashboard-stat-box" style="height: 58vh">
                    <div class="d-flex justify-content-between">
                        <h2 class="dashboard fw-bold py-2">Statistik</h2>
                        <form action="" class="py-2 d-flex flex-row justify-content-center gap-1">
                            <input type="date" placeholder="Start Date" class="dashboard-input-date" name="start_date" value="{{ old('start_date', $start_date) }}"/>
                            <div class="dashboard-date-separator">-</div>
                            <input type="date" placeholder="End Date" class="dashboard-input-date" name="end_date" value="{{ old('end_date', $end_date) }}"/>
                            <button class="btn btn-primary dashboard-btn-filter p-0" type="submit">
                                Filter
                            </button>
                        </form>
                    </div>
                    <canvas id="barchart" class="mt-1"></canvas>
                </div>
            </div>
        </div>
    </main>
@endsection


@section('js')
    <script>
        var chart_data = {!! json_encode($dashboard_data['chart_data']) !!};

        console.log(chart_data);

        new Chart(document.getElementById('barchart'), {
            type: 'bar',
            data: {
                labels: chart_data['labels'],
                datasets: [{
                        label: 'Pengunjung',
                        backgroundColor: '#1FBADC',
                        data: chart_data['total_visitors'],
                    },
                    {
                        label: 'Buku Yang Dipinjam',
                        backgroundColor: '#F5AD41',
                        data: chart_data['total_book_borrowed'],
                    },
                ],
            },
            options: {
                borderRadius: 5,
                title: {
                    display: true,
                    textdate: '',
                },
            },
        })
    </script>
    <script>
        flatpickr('input[type=date]', {})
    </script>
@endsection
