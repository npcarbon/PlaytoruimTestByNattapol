@extends('layouts.app')

@section('content')
    {{-- Content goes here --}}
    <h1>OnTop</h1>
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
        <select name="type" id="type" onchange="showCase()">
            <option value="1">Points</option>
            <option value="2">Percentage by item category</option>
        </select>
        =
        <input type="text" name="amount" id="amount">

        <select name="category" id="category" style="display:none;">
            @foreach ($categories as $cate => $value)
                <option value="{{ $cate }}">{{ $cate }}</option>
            @endforeach
        </select>
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
        function showCase() {
            let dc_type = document.getElementById('type').value;
            let dc_amount = document.getElementById('amount').value;
            if (dc_type == 1) {
                document.getElementById('amount').style.display = 'inline'
                document.getElementById('category').style.display = 'none'

            } else {
                document.getElementById('amount').style.display = 'inline'
                document.getElementById('category').style.display = 'inline'

            }
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
                chk_maximum = price * (20 / 100)

                if (parseInt(dc_amount) > chk_maximum) {
                    subtotal = price - chk_maximum
                    document.getElementById('net_price').value = subtotal
                    document.getElementById('dc').value = chk_maximum
                    document.getElementById('dc_show').style.display = 'block'
                    document.getElementById('cuation_alert').style.display = 'none'
                } else {
                    subtotal = price - parseInt(dc_amount)
                    document.getElementById('net_price').value = subtotal
                    document.getElementById('dc').value = dc_amount
                    document.getElementById('dc_show').style.display = 'block'
                    document.getElementById('cuation_alert').style.display = 'none'
                }
            } else {
                let category = document.getElementById('category').value;
                let cate_price = 0
                let categories = {!! json_encode($categories) !!}
                Object.keys(categories).forEach(key => {
                    if (key == category) {
                        for (let index = 0; index < categories[category].length; index++) {
                            cate_price += categories[category][index].price
                        }
                        dcafsp = dc_amount.split("%")

                        if (dc_amount > 100) {
                            document.getElementById('cuation_alert').style.display = 'block'
                            document.getElementById('dc_show').style.display = 'none'
                            document.getElementById('net_price').value = "ERROR"

                        } else {
                            dc = cate_price * (parseInt(dcafsp) / 100)
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
                });
            }
        }
    </script>
@endsection
