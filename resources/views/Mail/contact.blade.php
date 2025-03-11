<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotation Email</title>
</head>
<body>
    <p><strong>Royal Insurance Broker</strong> <br>
    [Address] <br>
    [Email | Phone Number] <br>
    <strong>{{ $data['date'] }}</strong></p>


    <p><strong>{{ $data['company_id'] }},</strong><br>
    <strong>{{ $data['email'] }},</strong><br>
    [City, Postal Code] <br></p>

    <p>Subject: Quotation for Insurance Coverage</p>

    <p>Dear <strong>{{ $data['company_id'] }},</strong></p>

    <p>We are pleased to provide you with a comprehensive insurance quotation tailored to your specific needs. As a trusted insurance broker, Royal Insurance Broker is committed to delivering the best life and general insurance solutions to safeguard your assets and future.</p>

    <p>Enclosed, you will find our detailed quotation, which includes coverage options, benefits, and premium details. Our team is available to discuss any modifications or additional requirements you may have to ensure the policy aligns perfectly with your expectations.</p>

    <p>Please review the attached quotation and do not hesitate to contact us for further clarification or assistance.</p>

    <p>Thank you for considering Royal Insurance Broker.</p>

    <p>Best regards,<br>
    Royal Insurance Broker</p>

</body>
</html>
