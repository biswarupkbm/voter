<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Members List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .highlight { background-color: yellow; font-weight: bold; }
        .action-btns i { font-size: 1.2rem; }
    </style>
</head>
<body class="p-4 bg-light">

<div class="container mt-4">
    <h2 class="mb-4">Members List</h2>

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
                        <button type="button" class="btn btn-warning btn-sm edit-btn">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm cancel-btn" style="display:none;">
                            <i class="bi bi-x-circle"></i>
                        </button>
                        <form action="{{ route('members.update', $member->id) }}" method="POST" class="save-form d-inline" style="display:none;">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="bi bi-check-lg"></i>
                            </button>
                        </form>
                        <form action="{{ route('members.destroy', $member->id) }}" method="POST" class="d-inline">
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

<script>
    const fields = ['name','father_name','voter_id','gender','village','post','panchayath','mandal','state'];

    document.querySelectorAll(".edit-btn").forEach(editBtn => {
        editBtn.addEventListener("click", function () {
            let row = this.closest("tr");
            let cells = row.querySelectorAll("td");
            let cancelBtn = row.querySelector(".cancel-btn");
            let saveForm = row.querySelector(".save-form");

            row.dataset.original = JSON.stringify(Array.from(cells).map(cell => cell.innerHTML));

            fields.forEach((field, index) => {
                let text = cells[index+1].textContent.trim();
                cells[index+1].innerHTML = `<input type="text" class="form-control form-control-sm" name="${field}" value="${text}">`;
            });

            this.style.display = "none";
            cancelBtn.style.display = "inline-block";
            saveForm.style.display = "inline-block";
        });
    });

    document.querySelectorAll(".cancel-btn").forEach(cancelBtn => {
        cancelBtn.addEventListener("click", function () {
            let row = this.closest("tr");
            let original = JSON.parse(row.dataset.original);
            let cells = row.querySelectorAll("td");
            original.forEach((html, i) => {
                cells[i].innerHTML = html;
            });
        });
    });

    document.querySelectorAll(".save-form").forEach(saveForm => {
        saveForm.addEventListener("submit", function () {
            let row = this.closest("tr");
            let inputs = row.querySelectorAll("input.form-control");
            inputs.forEach(input => {
                let hidden = document.createElement("input");
                hidden.type = "hidden";
                hidden.name = input.name;
                hidden.value = input.value;
                this.appendChild(hidden);
            });
        });
    });

    document.getElementById("searchInput").addEventListener("keyup", function () {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll("#membersTable tbody tr");

        rows.forEach(row => {
            let text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });
</script>

</body>
</html>
