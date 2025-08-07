<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; padding: 30px; }
        .qr { position: absolute; bottom: 20px; right: 20px; }
    </style>
</head>
<body>
    <h1>{{ $resume->title }}</h1>
    <p><strong>Education:</strong> {{ is_array($resume->education) ? implode(', ', $resume->education) : $resume->education }}</p>
    <p><strong>Experience:</strong> {{ is_array($resume->experience) ? implode(', ', $resume->experience) : $resume->experience }}</p>
    <p><strong>Skills:</strong> {{ is_array($resume->skills) ? implode(', ', $resume->skills) : $resume->skills }}</p>

    <div class="qr">
        <img src="data:image/svg+xml;base64,{{ $qrCode }}" alt="QR Code" />

    </div>
</body>
</html>
