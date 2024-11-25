@extends('template.base')
@section('content')
    <div class="card">
        <div class="card-block">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Fund</th>
                        <th>Profit / Loss</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($funds as $fund)
                        <tr style="color: {{ $fund['profit_loss'] > 0 ? 'green' : 'red' }};font-weight: bold">
                            <th>{{ $fund['fund'] }}</th>
                            <td>{{ $fund['profit_loss'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        setInterval(function() {
            window.location.reload();
        }, 60000);
    </script>
@endsection
