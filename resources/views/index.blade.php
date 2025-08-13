<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Members List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .highlight {
            background-color: yellow;
            font-weight: bold;
        }
        .action-btns i {
            font-size: 1.2rem;
        }
        .action-btns a, .action-btns button {
            padding: 4px 8px;
        }
    </style>
</head>
<body class="p-4 bg-light">

<div class="container mt-4">
    <h2 class="mb-4">Members List</h2>

    {{-- Search Bar --}}
    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Search members...">
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped" id="membersTable">
        <thead class="table-dark">
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
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($members as $index => $member)
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
                        
                        @if($member->voter_card)
                            <a href="{{ asset('storage/' . $member->voter_card) }}" target="_blank" class="btn btn-info btn-sm">
                                <i class="bi bi-eye"></i>
                            </a>
                        @else
                            N/A
                        @endif
                    </td>
                    <td class="action-btns">
                        {{-- Edit --}}
                        <a href="{{ route('members.index', $member->id) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square"></i>
                        </a>

                        {{-- Update --}}
                        <a href="{{ route('members.index', $member->id) }}" class="btn btn-success btn-sm">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>

                        {{-- Delete --}}
                        <form action="{{ route('members.store', $member->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById("searchInput").addEventListener("keyup", function () {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll("#membersTable tbody tr");

        rows.forEach(row => {
            let text = row.textContent.toLowerCase();
            if (text.includes(filter)) {
                row.style.display = "";
                highlightText(row, filter);
            } else {
                row.style.display = "none";
            }
        });
    });

    function highlightText(row, filter) {
        let cells = row.querySelectorAll("td");
        cells.forEach(cell => {
            let cellText = cell.textContent;
            if (filter && cellText.toLowerCase().includes(filter)) {
                let regex = new RegExp(`(${filter})`, "gi");
                cell.innerHTML = cellText.replace(regex, `<span class="highlight">$1</span>`);
            } else {
                cell.innerHTML = cellText; // Remove previous highlights
            }
        });
    }
</script>
</body>
</html>
