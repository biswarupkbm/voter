<!DOCTYPE html>
<html>
<head>
    <title>Edit Voter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Edit Voter</h2>

    <form action="{{ route('members.update', $member->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{ $member->name }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Father Name</label>
            <input type="text" name="father_name" value="{{ $member->father_name }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Voter ID</label>
            <input type="text" name="voter_id" value="{{ $member->voter_id }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Gender</label>
            <select name="gender" class="form-control" required>
                <option value="Male" {{ $member->gender == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ $member->gender == 'Female' ? 'selected' : '' }}>Female</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Village</label>
            <input type="text" name="village" value="{{ $member->village }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Post</label>
            <input type="text" name="post" value="{{ $member->post }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Panchayath</label>
            <input type="text" name="panchayath" value="{{ $member->panchayath }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Mandal</label>
            <input type="text" name="mandal" value="{{ $member->mandal }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>State</label>
            <input type="text" name="state" value="{{ $member->state }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Voter Card (PDF/JPG/PNG)</label>
            <input type="file" name="voter_card" class="form-control">
            @if($member->voter_card)
                <p>Current: <a href="{{ asset('storage/' . $member->voter_card) }}" target="_blank">View</a></p>
            @endif
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('members.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
