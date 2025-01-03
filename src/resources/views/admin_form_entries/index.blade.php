@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Form Entries</h1>
        <table>
            <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>File</th>
            </tr>
            </thead>
            <tbody>
            @foreach($entries as $entry)
                <tr>
                    <td>{{ $entry['first_name'] }}</td>
                    <td>{{ $entry['last_name'] }}</td>
                    <td><a href="{{ asset('storage/' . $entry['file_path']) }}" target="_blank">View File</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
