@extends('base')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <a href="{{ route('walks.index') }}">
                    <button class="btn btn-sm mt-1" style="float:left;">
                        <i class="fa-solid fa-2x fa-circle-left"></i>
                    </button>
                </a>
                <h1>Walk {{ $walkData->id }}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <span class="fw-bold">Dog name</span>
                <p>{{ $walkData->dogOwner->dog->name }}</p>
            </div>
            <div class="col-md-3">
                <span class="fw-bold">Owner name</span>
                <p>{{ $walkData->dogOwner->owner->name }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <span class="fw-bold">Walk Time</span>
                <p>
                {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $walkData->started_at)->format('d F Y H:i:s') }}
                -
                @if($walkData->finished_at)
                    {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $walkData->finished_at)->format('d F Y H:i:s') }}
                @else
                    <span style="font-style:italic;">na</span>
                @endif
                </p>
            </div>
        </div>
    </div>
@endsection