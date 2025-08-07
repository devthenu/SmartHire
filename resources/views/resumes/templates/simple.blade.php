{{-- Simple Modern Resume PDF Layout --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $resume->title }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; padding: 30px; }
        h1 { font-size: 24px; margin-bottom: 10px; }
        h2 { font-size: 18px; margin-top: 20px; }
        p { font-size: 14px; line-height: 1.6; }

        .section { margin-bottom: 20px; }
        .qr-code { margin-top: 30px; }
    </style>
</head>
<body>

    <h1>{{ $resume->title }}</h1>

    <div class="section">
        <h2>Education</h2>
        <p>{{ is_array($resume->education) ? implode(', ', $resume->education) : $resume->education }}</p>
    </div>

    <div class="section">
        <h2>Experience</h2>
        <p>{{ is_array($resume->experience) ? implode(', ', $resume->experience) : $resume->experience }}</p>
    </div>

    <div class="section">
        <h2>Skills</h2>
        <p>{{ is_array($resume->skills) ? implode(', ', $resume->skills) : $resume->skills }}</p>
    </div>

    <div class="section qr-code">
        <h2>QR Code</h2>
        <img src="data:image/svg+xml;base64,{{ $qrCode }}" width="100" height="100" alt="QR Code">
        <p>Scan to view resume online.</p>
    </div>

</body>
</html>
