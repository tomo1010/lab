<!DOCTYPE html>
<html>
<head>
    <title>PDF</title>
</head>
<body>
    <h1>キーワード: {{ $keyword }}</h1>
    <h2>商品データ</h2>
    <table border="1">
        <thead>
            <tr>
                <th>商品番号</th>
                <th>商品代金</th>
                <th>工賃合計</th>
                <th>税抜合計</th>
                <th>税込合計</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product['productNumber'] }}</td>
                    <td>{{ number_format($product['profitTotal']) }} 円</td>
                    <td>{{ number_format($product['wagesTotal']) }} 円</td>
                    <td>{{ number_format($product['taxExcludedTotal']) }} 円</td>
                    <td>{{ number_format($product['taxIncludedTotal']) }} 円</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
