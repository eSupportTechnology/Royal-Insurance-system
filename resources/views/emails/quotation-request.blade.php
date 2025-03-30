<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotation Email</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f8;
            color: #000;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 750px;
            margin: auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.08);
        }

        .header {
            text-align: center;
            border-bottom: 1px solid #ddd;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }

        .header img {
            max-height: 60px;
            margin-bottom: 10px;
        }

        .info, .footer {
            font-size: 14px;
            color: #000;
        }

        .section-title {
            font-weight: bold;
            font-size: 16px;
            margin-top: 25px;
            margin-bottom: 10px;
        }

        .field-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .field-table th, .field-table td {
            padding: 10px 12px;
            border: 1px solid #ddd;
            text-align: left;
            vertical-align: top;
        }

        .field-table th {
            background-color: #f0f4f8;
            color: #000;
            width: 30%;
        }

        .footer {
            border-top: 1px solid #ddd;
            padding-top: 15px;
            margin-top: 30px;
            font-size: 13px;
        }

        a {
            color: #0a58ca;
            text-decoration: underline;
        }

        a:hover {
            color: #000;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Royal Insurance Broker</h2>
            <p>Colombo, Sri Lanka<br>
            info@royalinsurance.lk | +94 11 280 9809</p>
        </div>

        <p class="info" style="text-align:right;"><strong>Date:</strong> {{ $data['date'] }}</p>

        <p class="section-title">Subject: Quotation for Insurance Coverage</p>

        <p>We have received a customer request for an insurance quotation. The relevant details are as follows</p>

        <table class="field-table">
            @foreach($fields as $field)
                <tr>
                    <th>{{ $field->formField->field_name }}</th>
                    <td>
                        @if($field->formField->field_type === 'file')
                            <a href="{{ asset('storage/' . $field->response) }}" target="_blank">Download File</a>
                        @else
                            {{ $field->response }}
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>

        <p>Please provide us with the minimum possible premium along with the maximum benefits you can offer.</p>

        <p>Thank you for considering Royal Insurance Broker.</p>

        <p>Best regards,<br>
        <strong>Royal Insurance Broker Team</strong></p>

        <div class="footer">
            <p>This email was generated from our quotation system. Please do not reply directly to this email. For any queries, contact us at <a href="mailto:info@royalinsurance.lk">info@royalinsurance.lk</a>.</p>
        </div>
    </div>
</body>
</html>

