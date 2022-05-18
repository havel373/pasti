<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Bukti Pembelian</title>
    <style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>
</head>
<body>
    <center>
		<h3>Bukti Pembelian</h3>
	</center>
    <br>
    @php $i=1 @endphp
    Nama : {{$order->name}}
    <br>
    Tanggal Pembelian : {{$order->created_at->format('j F Y')}}
    <table class='table table-bordered'>
		<thead>
			<tr>
                <th>Nama Produk</th>
                <th>Banyak Pembelian</th>
                <th>Harga</th>
                <th>Total Harga</th>
			</tr>
		</thead>
		<tbody>
            @foreach($order->order_detail as $orders)
            <tr>
                @php
                    $totalharga = 0;
                @endphp
                <td>
                {{$orders->titles}}
                </td>
                <td>{{number_format($orders->qty)}}</td>
                <td>{{number_format($orders->price)}}</td>
                <td>{{number_format($orders->subtotal)}}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3">Jumlah Total</td>
                <td>{{number_format($order->total)}}</td>
            </tr>
        </tbody>
	</table>
</body>
</html>