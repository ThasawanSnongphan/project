@extends('layout')
@section('title', 'Project')
@section('content')
    <div>
        <form action="{{ route('project.PDF', $project->proID) }}" method="GET" target="_blank">
            <button type="submit" class="btn btn-primary">Export PDF</button>
        
    </div>

@endsection
