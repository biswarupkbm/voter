<!DOCTYPE html>
<html>
<head>
    <title>Add Voter</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { background: linear-gradient(135deg, #51fff1ff, #e5b816ff); font-family: 'Poppins', sans-serif; }
        .container { max-width: 600px; margin: 50px auto; padding: 20px; }
        .card { background: #ffb74cff; border-radius: 20px; padding: 25px; color: #fff; }
        .card h4 { text-align:center; margin-bottom:20px; }
        .form-group label { display:block; margin-bottom:6px; color:#070607ff; }
        .form-group input, .form-group select { width:100%; padding:10px; border-radius:12px; border:none; background:#fff; color:#181010ff; }
        .btn-submit { width:100%; padding:12px; font-weight:bold; border:none; border-radius:12px; background:linear-gradient(90deg,#e22d84ff,#4a00e0); color:white; cursor:pointer; }
        .btn-submit:hover { background:linear-gradient(90deg,#e0005aff,#2d9ae2ff); }
        small.text-danger { color:#ff6b6b !important; font-size:12px; }
        .radio-group { display:flex; gap:20px; }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <h4>Add Voter</h4>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('members.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group"><label>Name</label><input type="text" name="name" required>@error('name') <small class="text-danger">{{ $message }}</small> @enderror</div>
            <div class="form-group"><label>Father's Name</label><input type="text" name="father_name" required>@error('father_name') <small class="text-danger">{{ $message }}</small> @enderror</div>
            <div class="form-group"><label>Voter ID</label><input type="text" name="voter_id" required>@error('voter_id') <small class="text-danger">{{ $message }}</small> @enderror</div>
            <div class="form-group"><label>Gender</label><div class="radio-group">
                <label><input type="radio" name="gender" value="Male" required> Male</label>
                <label><input type="radio" name="gender" value="Female"> Female</label>
            </div>@error('gender') <small class="text-danger">{{ $message }}</small> @enderror</div>
            <div class="form-group"><label>Village</label><input type="text" name="village" required>@error('village') <small class="text-danger">{{ $message }}</small> @enderror</div>
            <div class="form-group"><label>Post</label><input type="text" name="post" required>@error('post') <small class="text-danger">{{ $message }}</small> @enderror</div>
            <div class="form-group"><label>Panchayath</label><input type="text" name="panchayath" required>@error('panchayath') <small class="text-danger">{{ $message }}</small> @enderror</div>
            <div class="form-group"><label>Mandal</label><input type="text" name="mandal" required>@error('mandal') <small class="text-danger">{{ $message }}</small> @enderror</div>
            <div class="form-group"><label>State</label><input type="text" name="state" required>@error('state') <small class="text-danger">{{ $message }}</small> @enderror</div>
            <div class="form-group"><label>Voter Card</label><input type="file" name="voter_card" accept="image/*" required>@error('voter_card') <small class="text-danger">{{ $message }}</small> @enderror</div>
            <button type="submit" class="btn-submit mt-3">Add Voter</button>
        </form>
    </div>
</div>
</body>
</html>
