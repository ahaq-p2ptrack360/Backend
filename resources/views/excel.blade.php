<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Excel File Upload</title>
</head>
<body>
    <h1>Ticket Excel File Upload</h1>

    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    <form  method="POST" enctype="multipart/form-data" action="{{ route('uploads') }}">
        @csrf
        <input type="file" name="excel_file">
        <button type="submit">Upload</button>
    </form>
</body>
</html>
