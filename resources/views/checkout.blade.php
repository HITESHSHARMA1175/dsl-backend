<form method="POST" action="{{ route('checkout.create') }}">
    @csrf
    <!-- Include order details here -->
    <button type="submit">Proceed to Payment</button>
</form>
