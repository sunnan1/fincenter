@extends('template.base')
@section('content')
    <div class="card">
        <div class="card-block">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Fund</th>
                        <th>Validity Date</th>
                        <th>NAV</th>
                        <th>YTD</th>
                        <th>MTD</th>
                        <th>1 Day</th>
                        <th>15 Days</th>
                        <th>30 Days</th>
                        <th>2 Years</th>
                        <th>3 Years</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($funds as $scrip)
                        <tr>
                            <th scope="row">{{ $scrip->name }}</th>
                            <td>{{ date('Y M, d' , strtotime($scrip?->latestperformance?->validity_date)) }}</td>
                            <td>{{ $scrip?->latestperformance?->nav }}</td>
                            <td style="color: {{ $scrip?->latestperformance?->ytd > 0 ? 'green' : 'red' }};">{{ $scrip?->latestperformance?->ytd }}</td>
                            <td style="color: {{ $scrip?->latestperformance?->mtd > 0 ? 'green' : 'red' }};">{{ $scrip?->latestperformance?->mtd }}</td>
                            <td style="color: {{ $scrip?->latestperformance?->day_1 > 0 ? 'green' : 'red' }};">{{ $scrip?->latestperformance?->day_1 }}</td>
                            <td style="color: {{ $scrip?->latestperformance?->day_15 > 0 ? 'green' : 'red' }};">{{ $scrip?->latestperformance?->day_15 }}</td>
                            <td style="color: {{ $scrip?->latestperformance?->day_30 > 0 ? 'green' : 'red' }};">{{ $scrip?->latestperformance?->day_30 }}</td>
                            <td style="color: {{ $scrip?->latestperformance?->year_2 > 0 ? 'green' : 'red' }};">{{ $scrip?->latestperformance?->year_2 }}</td>
                            <td style="color: {{ $scrip?->latestperformance?->year_3 > 0 ? 'green' : 'red' }};">{{ $scrip?->latestperformance?->year_3 }}</td>
                            @if(auth()->user()->type == 'EXPERT')
                                <td><a href="{{ url('fund/' .$scrip?->id) }}">Edit</a></td>
                            @else
                                <td></td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $(".table").DataTable()
        });
    </script>
@endsection
