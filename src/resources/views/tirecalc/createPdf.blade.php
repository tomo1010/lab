<!DOCTYPE html>
<html>
<head>
    <title>PDF</title>
</head>
<body>
    <h1>キーワード: {{ $keyword }}</h1>

    <h2>印刷設定</h2>
    <table border="1">
        <thead>
            <tr>
                <th>項目</th>
                <th>値</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>商品1 メーカー</td>
                <td>{{ $makers['maker1'] ?? '未選択' }}</td>
            </tr>
            <tr>
                <td>商品2 メーカー</td>
                <td>{{ $makers['maker2'] ?? '未選択' }}</td>
            </tr>
            <tr>
                <td>商品3 メーカー</td>
                <td>{{ $makers['maker3'] ?? '未選択' }}</td>
            </tr>
            <tr>
                <td>汎用サイズ</td>
                <td>{{ $size['sizeFree'] ?? '未選択' }}</td>
            </tr>
            <tr>
                <td>サイズキーワード</td>
                <td>{{ $size['sizeKeyword'] ?? '未入力' }}</td>
            </tr>
            <tr>
                <td>タイヤ選択</td>
                <td>{{ $selectTire ?? '未選択' }}</td>
            </tr>
        </tbody>
    </table>

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
