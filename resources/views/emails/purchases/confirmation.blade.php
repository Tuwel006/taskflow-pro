<x-mail::message>
# Order Confirmed!

Hi {{ $purchase['customer_name'] ?? 'Valued Customer' }},

Thank you for your purchase from **Taskflow Pro**. We're excited to let you know that your order has been received and is currently being processed.

<x-mail::panel>
**Order Summary**  
Order ID: #{{ $purchase['order_id'] ?? rand(10000, 99999) }}  
Date: {{ now()->format('M d, Y') }}
</x-mail::panel>

### Purchased Item
{{ $purchase['product_name'] ?? 'Enterprise Action Suite' }}  
**Amount Paid: {{ $purchase['amount'] ?? '$49.00' }}**

<x-mail::button :url="config('app.url') . '/dashboard'" color="success">
View Your Dashboard
</x-mail::button>

If you have any questions, feel free to reply to this email or visit our [support center]({{ config('app.url') }}/support).

Stay productive,<br>
The {{ config('app.name') }} Project

<x-mail::subcopy>
If you’re having trouble clicking the "View Your Dashboard" button, copy and paste the URL below into your web browser: [{{ config('app.url') }}/dashboard]({{ config('app.url') }}/dashboard)
</x-mail::subcopy>
</x-mail::message>
