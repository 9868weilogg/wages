@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ $plan->name }}</div>
                <div class="card-body">
                <form method="post" action="/subscriptions">
                    @csrf
                    <div id="dropin-container"></div>
                    <hr />
                    <input type="hidden" name="plan" value="{{ $plan->id }}" />
                    <button type="submit" class="btn btn-outline-dark d-none" id="payment-button">Pay</button>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://js.braintreegateway.com/js/braintree-2.32.1.min.js"></script>
<script
  src="http://code.jquery.com/jquery-3.3.1.js"
  integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
  crossorigin="anonymous"></script>
<script>
    jQuery.ajax({
        url: "{{ route('token') }}",
    })
    .done(function(res) {
        console.log(res)
        braintree.setup(res.data.token, 'dropin', {
            container: 'dropin-container',
            onReady: function() {
                jQuery('#payment-button').removeClass('d-none')
            }
        });
    })
    .fail(function(res) {
        console.log(res)
    });
</script>
@endsection