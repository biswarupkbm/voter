<!DOCTYPE html>
<html>
<head>
    <title>Add Voter</title>
    <style>
        body {
            background: linear-gradient(135deg, #44f0e2ff, #e5b816ff);
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;  
        }

        .card {
            
            background: orange;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(15px);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            color: #fff;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.4);
        }

        .card h4 {
            margin: 0 0 20px;
            font-weight: 600;
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
            font-size: 14px;
            color: #ffff;
        }

        input[type="text"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            border-radius: 12px;
            border: none;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            font-size: 14px;
        }

        input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 0 2px #c25785ff;
        }

        small.text-danger {
            color: #ff6b6b !important;
            font-size: 12px;
        }

        .radio-group {
            display: flex;
            gap: 20px;
        }

        .radio-group label {
            font-weight: normal;
            color: #e0d7f9;
        }

        input[type="radio"] {
            margin-right: 5px;
        }

        .btn-submit {
            background: linear-gradient(90deg, #8e2de2, #4a00e0);
            border: none;
            padding: 12px;
            font-weight: bold;
            border-radius: 12px;
            width: 100%;
            cursor: pointer;
            color: white;
            font-size: 16px;
            transition: transform 0.2s ease, background 0.3s ease;
        }

        .btn-submit:hover {
            transform: scale(1.05);
            background: linear-gradient(90deg, #4a00e0, #8e2de2);
        }

        .alert {
            padding: 10px;
            background: rgba(46, 151, 204, 0.2);
            border-radius: 10px;
            margin-bottom: 15px;
            color: #0be767ff;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <h4>Add Voter</h4>

            @if(session('success'))
                <div class="alert">{{ session('success') }}</div>
            @endif

            <form action="{{ route('members.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" required>
                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Father's Name</label>
                    <input type="text" name="father_name" required>
                    @error('father_name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Voter ID</label>
                    <input type="text" name="voter_id" required>
                    @error('voter_id') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Gender</label>
                    <div class="radio-group">
                        <label><input type="radio" name="gender" value="Male" required> Male</label>
                        <label><input type="radio" name="gender" value="Female"> Female</label>
                    </div>
                    @error('gender') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Village</label>
                    <input type="text" name="village" required>
                    @error('village') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Post</label>
                    <input type="text" name="post" required>
                    @error('post') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Panchayath</label>
                    <input type="text" name="panchayath" required>
                    @error('panchayath') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Mandal</label>
                    <input type="text" name="mandal" required>
                    @error('mandal') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>State</label>
                    <input type="text" name="state" required>
                    @error('state') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Upload Voter ID Card</label>
                    <input type="file" name="voter_card" accept="image/*,application/pdf" required>
                    @error('voter_card') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <button type="submit" class="btn-submit">Add Voter</button>
            </form>
        </div>
    </div>

</body>
</html>
