@extends('template.base')
@section('content')
    @foreach($data as $sectors)
        <div class="card">
            <div class="card-header">
                <center><h3>{{ $sectors->name }}</h3></center>
            </div>
            <div class="card-block table-border-style">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>SCRIP</th>
                            <th>LDCP</th>
                            <th>OPEN</th>
                            <th>HIGH</th>
                            <th>LOW</th>
                            <th>CURRENT</th>
                            <th>CHANGE</th>
                            <th>VOLUME</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sectors->scrips as $scrip)
                            <tr style="color: {{ $scrip?->today?->first()?->change > 0 ? 'green' : 'red' }};">
                                <th scope="row">{{ $scrip->name }}</th>
                                <td>{{ $scrip?->today?->first()?->ldcp }}</td>
                                <td>{{ $scrip?->today?->first()?->open }}</td>
                                <td>{{ $scrip?->today?->first()?->high }}</td>
                                <td>{{ $scrip?->today?->first()?->low }}</td>
                                <td>{{ $scrip?->today?->first()?->current }}</td>
                                <td>{{ $scrip?->today?->first()?->change }}</td>
                                <td>{{ $scrip?->today?->first()?->volume }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach

@endsection
