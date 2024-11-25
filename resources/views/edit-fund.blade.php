@extends('template.base')
@section('content')
    <div class="card">
        <div class="card-block">
            <h4 class="sub-title">Update <b>{{ $fund->name }}</b> Details</h4>
            <form action="{{ url('save-fund') }}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="fundid" value="{{ $fund->id }}">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="">Select Stock</label>
                            <select name="stock" id="" class="form-control stocksList">
                                @foreach($scrips as $scrip)
                                    <option value="{{ $scrip->id }}">{{ $scrip->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="">Percentage</label>
                            <input type="text" class="form-control" name="percentage" min="0" max="100">
                        </div>
                    </div>
                    <div class="col-sm-1" style="text-align: center">
                        <div class="form-group">
                            <label for="">Active</label>
                            <input type="checkbox" class="form-control" name="active" {{ $fund->is_active ? 'checked' : '' }}>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="" style="color: transparent">.</label>
                            <button type="submit" class="form-control btn btn-success">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-block">
            <h4 class="sub-title">Fund Holdings</h4>
            <table class="table table-striped">
                <thead>
                    <th>Stock</th>
                    <th>Percentage</th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach($fund->scrips as $scrip)
                        <tr>
                            <td>{{ $scrip->scrip->name }}</td>
                            <td>{{ $scrip->equity_per }}%</td>
                            <td><a href="{{ url('delete-fund/' . $scrip->id) }}">Delete</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
