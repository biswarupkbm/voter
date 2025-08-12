<!DOCTYPE html>
<html>
<head>
    <title>Add Voter</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

    <div class="container mt-5" style="max-width: 500px;">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Add Voter</h4>
            </div>
            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('members.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" required>
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Father's Name</label>
                        <input type="text" name="father_name" class="form-control" required>
                        @error('father_name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Voter ID</label>
                        <input type="text" name="voter_id" class="form-control" required>
                        @error('voter_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Gender</label><br>
                        <div class="form-check form-check-inline">
                            <input type="radio" name="gender" value="Male" class="form-check-input" required>
                            <label class="form-check-label">Male</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" name="gender" value="Female" class="form-check-input">
                            <label class="form-check-label">Female</label>
                        </div>
                        @error('gender') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Village</label>
                        <input type="text" name="village" class="form-control" required>
                        @error('village') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Post</label>
                        <input type="text" name="post" class="form-control" required>
                        @error('post') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Panchayath</label>
                        <input type="text" name="panchayath" class="form-control" required>
                        @error('panchayath') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mandal</label>
                        <input type="text" name="mandal" class="form-control" required>
                        @error('mandal') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">State</label>
                        <input type="text" name="state" class="form-control" required>
                        @error('state') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Upload Voter ID Card</label>
                        <input type="file" name="voter_card" class="form-control" accept="image/*,application/pdf" required>
                        @error('voter_card') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Add Voter</button>
                </form>

            </div>
        </div>
    </div>

</body>
</html>
