<!DOCTYPE html>
<html>
<head>
    <title>Add Voter</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { background: linear-gradient(135deg, #7151ffff, #855de2ff); font-family: 'Poppins', sans-serif; }
        .container { max-width: 600px; margin: 50px auto; padding: 20px; }
        .card { background: #f0f0f0; border-radius: 20px; padding: 25px; color: #1111bbff; }
        .card h4 { text-align:center; margin-bottom:20px; }
        .form-group label { display:block; margin-bottom:6px; color:#070607ff; }
        .form-group input, .form-group select { width:100%; padding:10px; border-radius:12px; border:none; background:  #ffff#333333; color:#181010ff; }
        .btn-submit { width:100%; padding:12px; font-weight:bold; border:none; border-radius:12px; background:linear-gradient(90deg,#e22d84ff,#4a00e0); color:white; cursor:pointer; }
        .btn-submit:hover { background:linear-gradient(90deg,#e0005aff,#2d9ae2ff); }
        small.text-danger { color:#ff6b6b !important; font-size:12px; }
        .radio-group { display:flex; gap:20px; margin-bottom:15px; }
        .upload-section { margin-top: 30px; padding-top: 20px; border-top: 2px dashed #fff; }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <h4>Add Voter Manually</h4>

        {{-- Success/Error messages --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- Manual Add Form --}}
        <form action="{{ route('members.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group"><label>Name</label><input type="text" name="name" required>@error('name') <small class="text-danger">{{ $message }}</small> @enderror</div>
            <div class="form-group"><label>Father's Name</label><input type="text" name="father_name" required>@error('father_name') <small class="text-danger">{{ $message }}</small> @enderror</div>
            <div class="form-group"><label>Voter ID</label><input type="text" name="voter_id" required>@error('voter_id') <small class="text-danger">{{ $message }}</small> @enderror</div>
            <div class="mb-3">
                <fieldset class="border-0 p-0">
                    <legend class="fw-normal mb-2" style="font-size:15px; color:#000000;">Gender</legend>
                    <div class="d-flex gap-2">
                        <input type="radio" class="btn-check" name="gender" id="male" value="Male" required autocomplete="off">
                        <label class="btn btn-light rounded-pill flex-fill text-center fw-normal" for="male" style="color:#000000;">Male</label>

                        <input type="radio" class="btn-check" name="gender" id="female" value="Female" autocomplete="off">
                        <label class="btn btn-light rounded-pill flex-fill text-center fw-normal" for="female" style="color:#000000;">Female</label>
                    </div>
                    @error('gender') 
                        <small class="text-danger d-block mt-1">{{ $message }}</small> 
                    @enderror
                </fieldset>
            </div>
            <div class="form-group"><label>Village</label><input type="text" name="village" required>@error('village') <small class="text-danger">{{ $message }}</small> @enderror</div>
            <div class="form-group"><label>Post</label><input type="text" name="post" required>@error('post') <small class="text-danger">{{ $message }}</small> @enderror</div>
            <div class="form-group"><label>Panchayath</label><input type="text" name="panchayath" required>@error('panchayath') <small class="text-danger">{{ $message }}</small> @enderror</div>
            <div class="form-group"><label>Mandal</label><input type="text" name="mandal" required>@error('mandal') <small class="text-danger">{{ $message }}</small> @enderror</div>
            <div class="form-group"><label>State</label><input type="text" name="state" required>@error('state') <small class="text-danger">{{ $message }}</small> @enderror</div>
            <div class="form-group">
                <label>Voter Card <span class="text-danger">*</span></label>
                <input type="file" name="voter_card" accept="image/*" required class="form-control">
                @error('voter_card')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <button type="submit" class="btn-submit mt-3">Add Voter</button>
        </form>

        {{-- Excel Upload Section --}}
        <div class="upload-section text-center">
            <h5>Or Upload Excel File</h5>
            <form action="{{ route('members.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" accept=".xls,.xlsx" class="form-control mb-3" required>
                <button type="submit" class="btn-submit">Upload</button>
            </form>
        </div>
    </div>
</div>

<script>
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
</script>
</body>
</html>
