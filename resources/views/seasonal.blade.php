@extends('layouts.app')

@section('content')
    {{-- Content goes here --}}
    <h1>Seasonal</h1>
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
        Discount
        <input type="text" name="dc_amount" id="dc_amount"> THB
        at every
        <input type="text" name="every_amount" id="every_amount"> THB
        <button type="button" onclick="calculate({{ $net_price }})">Submit</button>
    </form>


    <h3>Subtotal = <input type="text" id="subtotal" value="{{ $net_price }}" disabled> THB</h3>
    <div style="display: none" id="dc_show">
        <h3>Discount = <input type="text" id="dc" disabled> THB</h3>
    </div>

    <h3>Net price = <input type="text" id="net_price" disabled> THB</h3>

    <script>
        function calculate(price) {
            let dc_amount = document.getElementById('dc_amount').value;
            let amount = document.getElementById('every_amount').value;
            dcamount = amount.split(",")
            if (dcamount.lenght > 0) {
                every_amount = dcamount[0] + dcamount[1]
            } else {
                every_amount = amount
            }
            let time_dc = price % parseInt(every_amount).toFixed(2)
            console.log('amount time = ' + time_dc)
            console.log('Total = ' + parseInt(every_amount))
            console.log('Discount = ' + dc_amount * time_dc)
            dc = dc_amount * time_dc
            subtotal = price - dc
            if (subtotal < 0) {
                subtotal = 0
            }
            document.getElementById('dc').value = dc
            document.getElementById('dc_show').style.display = 'block'
            document.getElementById('net_price').value = subtotal


        }
    </script>
@endsection
