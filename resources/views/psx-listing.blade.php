@extends('template.base')
@section('content')
        <div class="card">
            <div class="card-block">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Stock</th>
                            <th class="price">LAST</th>
                            <th class="price">HIGH</th>
                            <th class="price">LOW</th>
                            <th class="price">CHANGE</th>
                            <th class="price">CHANGE %</th>
                            <th class="price">VOLUME</th>
                            <th class="price">TIME</th>
                            <th class="performance">DAILY</th>
                            <th class="performance">1 WEEK</th>
                            <th class="performance">1 MONTH</th>
                            <th class="performance">YTD</th>
                            <th class="performance">1 Year</th>
                            <th class="performance">3 Years</th>
                            <th class="technical">Hourly</th>
                            <th class="technical">Daily</th>
                            <th class="technical">Weekly</th>
                            <th class="technical">Monthly</th>
                            <th class="fundamental">Market Cap</th>
                            <th class="fundamental">Revenue</th>
                            <th class="fundamental">P/E Ratio</th>
                            <th class="fundamental">Beta</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $scrip)
                            <tr>
                                <th scope="row">{{ $scrip->name }}</th>
                                <td class="price">{{ $scrip?->latest?->current }}</td>
                                <td class="price">{{ $scrip?->latest?->high }}</td>
                                <td class="price">{{ $scrip?->latest?->low }}</td>
                                <td class="price" style="color: {{ $scrip?->latest?->change > 0 ? 'green' : 'red' }};">{{ $scrip?->latest?->change }}</td>
                                <td class="price" style="color: {{ $scrip?->latest?->change > 0 ? 'green' : 'red' }};">{{ $scrip?->latest?->change_per }}%</td>
                                <td class="price">{{ $scrip?->latest?->volume }}</td>
                                <td class="price">{{ $scrip?->latest?->updated_at }}</td>
                                <td class="performance" style="color: {{ $scrip?->performance_day > 0 ? 'green' : 'red' }};">{{ $scrip?->performance_day }}%</td>
                                <td class="performance" style="color: {{ $scrip?->performance_week > 0 ? 'green' : 'red' }};">{{ $scrip?->performance_week }}%</td>
                                <td class="performance" style="color: {{ $scrip?->performance_month > 0 ? 'green' : 'red' }};">{{ $scrip?->performance_month }}%</td>
                                <td class="performance" style="color: {{ $scrip?->performance_ytd > 0 ? 'green' : 'red' }};">{{ $scrip?->performance_ytd }}%</td>
                                <td class="performance" style="color: {{ $scrip?->performance_year > 0 ? 'green' : 'red' }};">{{ $scrip?->performance_year }}%</td>
                                <td class="performance" style="color: {{ $scrip?->performance_3_year > 0 ? 'green' : 'red' }};">{{ $scrip?->performance_3_year }}%</td>
                                <td class="technical" style="color: {{ str_contains($scrip?->technical_day , 'buy') ? 'green' : 'red' }};">{{ $scrip?->technical_day }}</td>
                                <td class="technical" style="color: {{ str_contains($scrip?->technical_hour , 'buy') ? 'green' : 'red' }};">{{ $scrip?->technical_hour }}</td>
                                <td class="technical" style="color: {{ str_contains($scrip?->technical_week , 'buy') ? 'green' : 'red' }};">{{ $scrip?->technical_week }}</td>
                                <td class="technical" style="color: {{ str_contains($scrip?->technical_month , 'buy') ? 'green' : 'red' }};">{{ $scrip?->technical_month }}</td>
                                <td class="fundamental">{{ number_format($scrip?->fundamental_market_cap ?? 0, 2)  }}</td>
                                <td class="fundamental">{{ $scrip?->fundamental_revenue ?? 0 }}</td>
                                <td class="fundamental">{{ $scrip?->fundamental_ratio ?? 0 }}</td>
                                <td class="fundamental">{{ $scrip?->fundamental_beta ?? 0 }}</td>
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
