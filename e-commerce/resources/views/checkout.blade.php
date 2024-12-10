<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" 
        data-client-key="{{ config('midtrans.client_key') }}"></script>
</head>
<body>
    <div id="payment-form"></div>
    <script type="text/javascript">
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                alert('Payment success!');
                window.location.href = '/keranjang';
            },
            onPending: function(result) {
                alert('Payment pending!');
                window.location.href = '/keranjang';
            },
            onError: function(result) {
                alert('Payment failed!');
                window.location.href = '/keranjang';
            },
            onClose: function() {
                alert('You closed the payment window');
                window.location.href = '/keranjang';
            }
        });
    </script>
</body>
</html>
