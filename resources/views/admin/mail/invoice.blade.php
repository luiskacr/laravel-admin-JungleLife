<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>{{ __('app.invoice_tittle') }}</title>

    <!-- Invoice styling -->
    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            text-align: center;
            color: #777;
        }

        body h1 {
            font-weight: 300;
            margin-bottom: 0px;
            padding-bottom: 0px;
            color: #000;
        }

        body h3 {
            font-weight: 300;
            margin-top: 10px;
            margin-bottom: 20px;
            font-style: italic;
            color: #555;
        }

        body a {
            color: #06f;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }


        .invoice-boxx {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #f7f7f7;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }
    </style>
</head>

<body>
<div class="invoice-boxx">
    <br>
    <h1 align="center" class="title">{{ __('app.invoice_tittle') }}</h1>
    <br>
    <div class="invoice-box">
        <table>
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="{{ asset('assets/images/logo2.png') }}" alt="logo" style="width: 50%; max-width: 150px" />
                            </td>
                            <td>
                                {{ __('app.invoice') }} : {{ $prefix . $invoice->id  }}<br />
                                {{ __('app.date') }} : {{ \Illuminate\Support\Carbon::now()->format('d-m-Y') }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                Jungle Life.<br />
                                Bijagua, Upala<br />
                                Alajuela, Costa Rica.
                            </td>
                            <td>
                                {{ $client['name'] }}<br />
                                {{ $client['telephone'] }}<br />
                                {{ $client['email'] }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table>
            <tr class="heading">
                <td>{{ __('app.products') }}</td>
                <td>{{ __('app.quantity2') }}</td>
                <td>{{ __('app.price') }}</td>
                <td> {{ __('app.total') }} </td>
            </tr>
            @php($total = 0)
            @php($symbol = $invoice->getMoney->symbol)
            @foreach($details as $detail)
                <tr class="item">
                    @php($product_total = ($detail['quantity'] * $detail['price']) )
                    <td>{{ $detail['name'] }}</td>
                    <td>{{ $detail['quantity'] }}</td>
                    <td>{{ $symbol . $detail['price'] }}</td>
                    <td>{{ $symbol . $product_total }}</td>
                    @php($total = $total + $product_total)
                </tr>
            @endforeach
            <tr class="total">
                <td></td>
                <td></td>
                <td></td>
                <td> <b>{{ __('app.total') }} : {{ $symbol . $total }}</b> </td>
            </tr>
        </table>
        <p align="center"><strong>{{ __('app.invoice_thanks') }}</strong></p>
    </div>
    <br>
</div>
<div>
    <br>
    <br>
</div>

<div class="invoice-box">
    <h1 align="center" class="title">{{ env('APP_NAME') }}</h1>
    <p align="center">
        Phone: +62 21 6386 9506
        <br> Email: contact@indosol.com
        <br> Website:<a href="www.indosol.com">www.indosol.com</a>
        <br>
    </p>
    <div align="center">
        <a href="#"> <img src="https://cdn3.iconfinder.com/data/icons/free-social-icons/67/facebook_circle_color-512.png" align="middle" style="width:10%; max-width:50px;"> </a>
        <a href="#"> <img src="https://cdn3.iconfinder.com/data/icons/free-social-icons/67/google_circle_color-128.png" align="middle" style="width:10%; max-width:50px;"> </a>
    </div>
    <div align="center">
       <p>©{{ now()->year }} {{ __('app.template_rights') }}</p>
    </div>
</div>

</body>
</html>
