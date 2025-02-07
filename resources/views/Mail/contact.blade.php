<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <p>Dear <strong>{{ $data['company_id'] }},</p>
    <p>I hope this message finds you well. Please find the motor insurance details below for your kind reference and necessary processing:
    </p>
    <p>Vehicle Details:</p>

    <p><strong>Make: <strong>{{ $data['make'] }}</strong></strong></p>
    <p><strong>Year: <strong>{{ $data['year'] }}</strong></strong></p>
    <p><strong>Vehicle Number: <strong>{{ $data['vehicle_number'] }}</strong></strong></p>
    <p><strong>Usage: <strong>{{ $data['usage'] }}</strong></strong></p>
    <p><strong>Vehicle Value: <strong>{{ $data['vehicle_value'] }}</strong></strong></p>
    <p><strong>Financial Interest: <strong>{{ $data['financial_interest'] }}</strong></strong></p>
    <p><strong>Fuel Type: <strong>{{ $data['fuel_type'] }}</strong></strong></p>
    <p><strong>Name: <strong>{{ $data['name'] }}</strong></strong></p>
    <p><strong>Id Number: <strong>{{ $data['id_number'] }}</strong></strong></p>

    <p>Please confirm receipt of these details and inform me if further documentation or clarification is required. I look forward to your prompt response.
    </p>
    <p>Thank you for your assistance.
    </p>
    <p>Best regards,
    <br><strong>{{ $data['name'] }}</strong></p>
</body>
</html>
