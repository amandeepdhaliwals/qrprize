<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code</title>
    <style>
        .qr-code-container {
            text-align: center;
            padding: 20px;
        }
        .qr-code-image {
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="qr-code-container">
        <h1>{{ $store->store_name }}</h1>
        <h2>{{ $campaign->campaign_name }}</h2>
        <div class="qr-code-image">
            <img src="data:image/png;base64,{{ $campaign->qr_code_image }}" alt="QR Code" />
        </div>
    </div>
</body>
</html>
