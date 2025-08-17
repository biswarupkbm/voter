<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <!-- Title -->
    <title>voters</title>
    <!-- Favicon Icon -->
    <link rel="shortcut icon" href="assets/images/voter/logo/logo.png" type="image/x-icon">
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #f2f2f2; }
        img { max-width: 80px; max-height: 80px; }
    </style>
</head>
<body>
    <h3>Members List</h3>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Father Name</th>
                <th>Voter ID</th>
                <th>Gender</th>
                <th>Village</th>
                <th>Post</th>
                <th>Panchayath</th>
                <th>Mandal</th>
                <th>State</th>
                <th>Voter Card</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pdfData as $index => $member)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $member->name }}</td>
                <td>{{ $member->father_name }}</td>
                <td>{{ $member->voter_id }}</td>
                <td>{{ $member->gender }}</td>
                <td>{{ $member->village }}</td>
                <td>{{ $member->post }}</td>
                <td>{{ $member->panchayath }}</td>
                <td>{{ $member->mandal }}</td>
                <td>{{ $member->state }}</td>
                <td>
                    @if($imageOption === 'with' && $member->voter_card && $member->voter_card !== 'N/A')
                        <img src="{{ asset($member->voter_card) }}" alt="Voter Card">
                    @elseif($imageOption === 'url')
                        {{ $member->voter_card ?? 'N/A' }}
                    @else
                        N/A
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
