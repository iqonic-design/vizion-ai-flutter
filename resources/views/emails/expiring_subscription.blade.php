<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expiring Subscription Email</title>
</head>
<body>
    <p>Hello {{ $user->first_name }} {{$user->last_name}},</p>

    @php
        // Calculate the expiration date (7 days from now)
        $expirationDate = now()->addDays(7);
        // Calculate the number of days remaining until expiration
        $daysRemaining = now()->diffInDays($expirationDate);
    @endphp
    
    <p>Your subscription plan is expiring soon. Please renew your subscription plan within the next 7 days to continue enjoying our services.</p>
    
    <p>Thank you,</p>
</body>
</html>