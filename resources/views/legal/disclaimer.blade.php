@extends('layout.back.master')
@section('title', "DISCLAIMER – BMT FASHION")
@section('content')

<body style="padding:20px; font-family:Arial; line-height:1.7;">
    <h1>Disclaimer - BMT Fashion</h1>
    <p>{!! nl2br(e($content ?? 'DISCLAIMER – BMT FASHION  
Effective Date: 01 January 2025

1. GENERAL INFORMATION  
The information provided by BMT Fashion is for general shopping purposes. All products, prices, and availability are subject to change.

2. PRODUCT REPRESENTATION  
Images shown are for representation only. Actual product color may vary depending on lighting and device display.

3. NO WARRANTIES  
The app is provided "as-is" without warranties of any kind, including but not limited to:  
• Accuracy  
• Reliability  
• Availability  
• Fitness for a particular purpose

4. THIRD-PARTY SERVICES  
We are not responsible for actions, failures, or policies of:  
• Courier partners  
• Payment gateways  
• Third-party vendors

5. EXTERNAL LINKS  
External website links found in the app are not controlled or endorsed by us.

6. LIABILITY  
To the maximum extent permitted by law, we are not liable for:  
• Loss of data  
• Financial loss  
• Delayed deliveries  
• App interruptions  
• Damages caused by misuse

7. USER RESPONSIBILITY  
Users must verify product details, price, and size before confirming an order.

8. CONTACT  
support@bmtfashion.in')) !!}</p>
</body>
@endsection

