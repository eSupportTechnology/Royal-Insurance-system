<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motor Insurance Quotation</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h1 { color: #333; }
    </style>
</head>
<body>
    <h1>Quotation</h1>

    <p>I hope this message finds you well. Please find the motor insurance details below for your kind reference and necessary processing:</p>

    <p><strong>Vehicle Details:</strong></p>

    <p><strong>Make:</strong> {{ $data['make'] }}</p>
    <p><strong>Year:</strong> {{ $data['year'] }}</p>
    <p><strong>Vehicle Number:</strong> {{ $data['vehicle_number'] }}</p>
    <p><strong>Usage:</strong> {{ $data['usage'] }}</p>
    <p><strong>Vehicle Value:</strong> {{ $data['vehicle_value'] }}</p>
    <p><strong>Financial Interest:</strong> {{ $data['financial_interest'] }}</p>
    <p><strong>Fuel Type:</strong> {{ $data['fuel_type'] }}</p>

    <p>Please confirm receipt of these details and inform me if further documentation or clarification is required. I look forward to your prompt response.</p>

    <p>Thank you for your assistance.</p>
</body>
</html>
