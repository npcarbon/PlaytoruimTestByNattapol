@extends('layouts.app')

@section('content')
    {{-- Content goes here --}}
    <h1>Coupon</h1>
    @php
        $net_price = 0;
    @endphp
    @foreach ($products as $product)
        <p>{{ $product->qty }} x {{ $product->name }} = {{ $product->qty * $product->price }}
            {{ $product->currency }}</p>
        @php
            $net_price += $product->price;
        @endphp
    @endforeach
    <form action="" method="post">
        Discount By
        <select name="type" id="type">
            <option value="1">Fixed Amount</option>
            <option value="2">Percentage</option>
        </select>
        =
        <input type="text" name="amount" id="amount" onkeypress="return onlyNumberKey(event)">
        <button type="button" onclick="calculate({{ $net_price }})">Submit</button>
    </form>
    <p id="cuation_alert" style="color: red;font-size:12px; display:none;">Can not discount with PERCENATGE more than 100%
    </p>
    <h3>Subtotal = <input type="text" id="subtotal" value="{{ $net_price }}" disabled> THB</h3>
    <div style="display: none" id="dc_show">
        <h3>Discount = <input type="text" id="dc" disabled> THB</h3>
    </div>
    <h3>Net price = <input type="text" id="net_price" disabled> THB</h3>
    <script>
        function onlyNumberKey(evt) {
            let ASCIICode = (evt.which) ? evt.which : evt.keyCode
            if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                return false;
            return true;
        }

        function calculate(price) {
            let dc_type = document.getElementById('type').value;
            let amount = document.getElementById('amount').value;
            dcamount = amount.split(",")
            if (dcamount.lenght > 0) {
                dc_amount = dcamount[0] + dcamount[1]
            } else {
                dc_amount = amount
            }
            if (dc_type == 1) {
                subtotal = price - parseInt(dc_amount)
                if (subtotal < 0) {
                    subtotal = 0
                } else {
                    subtotal = subtotal
                }
                document.getElementById('net_price').value = subtotal
                document.getElementById('dc').value = dc_amount
                document.getElementById('dc_show').style.display = 'block'
                document.getElementById('cuation_alert').style.display = 'none'
            } else {
                dcafsp = dc_amount.split("%")
                if (dc_amount > 100) {
                    document.getElementById('cuation_alert').style.display = 'block'
                    document.getElementById('dc_show').style.display = 'none'
                    document.getElementById('net_price').value = "ERROR"
                } else {
                    dc = price * (parseInt(dcafsp) / 100)
                    subtotal = price - dc
                    if (subtotal < 0) {
                        subtotal = 0
                    }
                    document.getElementById('dc').value = dc
                    document.getElementById('dc_show').style.display = 'block'
                    document.getElementById('net_price').value = subtotal
                    document.getElementById('cuation_alert').style.display = 'none'

                }
            }
        }
    </script>
@endsection
