<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify CODE</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
    <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-center mb-4">Enter CODE</h2>
        <form method="POST" action="{{ route('password.otp.verify') }}">
            @csrf
            <input type="hidden" name="email" value="{{ session('email') }}">

            <div class="mb-4">
                <label for="otp" class="block text-sm font-medium text-gray-700">CODE</label>
                <input type="text" id="otp" name="otp" required maxlength="6"
                    class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>

            @if ($errors->has('otp'))
                <p class="text-red-500 text-sm">{{ $errors->first('otp') }}</p>
            @endif

            <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-md hover:bg-indigo-700">
                Verify CODE
            </button>
        </form>
    </div>
</body>
</html>
