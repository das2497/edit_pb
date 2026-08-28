@extends('layouts.bakery')

@section('title', 'Logs | Perera Bakers')

@section('content')

<div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-4">
    <div>
        <h1 class="display-font page-title mb-1">Ordering Admin Logs</h1>
        <div class="page-sub">Dashboard / Logs</div>
    </div>
</div>

@include('components.bakery.alerts')

<div class="panel">
    <div class="panel-head">
        <div>
            <h2>Logs</h2>
        </div>
        <form action="" method="GET" class="d-flex flex-wrap gap-2">
            <input type="date" class="form-control form-control-sm" name="date">
            <input type="text" class="form-control form-control-sm" placeholder="Search…" name="search" style="min-width:220px;">
            <button class="btn btn-soft btn-sm" id="search">Search</button>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-bakery align-middle">
            <thead>
                <tr>
                    <th style="width: 20%;">DateTime</th>
                    <th style="width: 20%;">Type</th>
                    <th style="width: 20%;">User</th>
                    <th style="width: 40%;">Message</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $log)
                <tr>
                    <td class="mono">[{{ $log->created_at }}]</td>
                    <td>{{ $log->type }}</td>
                    <td>{{ $log->user }}</td>
                    <td style="word-break: break-word;">{{ $log->message }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $logs->links() }}</div>
</div>

@endsection
