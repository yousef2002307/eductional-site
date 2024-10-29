<!DOCTYPE html>
<html>
<head>
    <title>Upload Video to Google Drive</title>
</head>
<body>
    @if ($errors->any())
        <p>
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </p>
    @endif
    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif
    <h1>Upload Video</h1>
    <form action="{{ route('upload.video') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="video" accept="video/*" required>
        <button type="submit">Upload</button>
    </form>
</body>
</html>