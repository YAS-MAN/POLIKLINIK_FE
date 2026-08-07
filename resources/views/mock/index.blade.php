@extends('layouts.app')

@section('title', $title . ' | Poliklinik Al-Azhar')

@section('content')
<!-- SUB-HEADER -->
<div class="sub-header">
    <div class="breadcrumb">
        <!-- Home SVG -->
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" style="color: var(--text-muted); margin-right: 4px;">
            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
        </svg>
        <span>/</span>
        <span class="breadcrumb-item active">{{ $title }}</span>
    </div>
</div>

<div class="card">
    <div class="card-title-bar" style="border-bottom: 1px solid var(--border-color); padding-bottom: 12px; margin-bottom: 16px;">
        <div>
            <h3 class="card-title">{{ $title }}</h3>
            <p style="font-size: 13.5px; color: var(--text-muted); margin-top: 4px;">{{ $description }}</p>
        </div>
    </div>

    @if(count($rows) > 0)
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    @foreach($rows[0] as $header)
                        <th>{{ $header }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach(array_slice($rows, 1) as $row)
                <tr>
                    @foreach($row as $val)
                        <td>{{ $val }}</td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p style="color: var(--text-muted); text-align: center; padding: 20px;">Belum ada entri data parameter.</p>
    @endif
</div>
@endsection
