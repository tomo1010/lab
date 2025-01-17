<!DOCTYPE html>
<html>
<head>
    <title>PDF</title>
</head>
<body>
    <h1> {{ $selectTire }}</h1>
    <h1>
    @if(!empty($sizeFree) || !empty($sizeGeneral))
        {{ $sizeFree ?? '' }} {{ $sizeGeneral ?? '' }}
    @endif
    </h1>

<h2>{{ $makers['maker1'] ?? '未選択' }}</h2>
    <table border="1">
        <thead>
            <tr>
                <th>商品代金</th>
                <th>工賃合計</th>
                <th>税抜合計</th>
                <th>税込合計</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ number_format($products[0]['profitTotal'] ?? 0) }} 円</td>
                <td>{{ number_format($products[0]['wagesTotal'] ?? 0) }} 円</td>
                <td>{{ number_format($products[0]['taxExcludedTotal'] ?? 0) }} 円</td>
                <td>{{ number_format($products[0]['taxIncludedTotal'] ?? 0) }} 円</td>
            </tr>
        </tbody>
    </table>

<h2>{{ $makers['maker2'] ?? '未選択' }}</h2>

<table border="1">
        <thead>
            <tr>
                <th>商品代金</th>
                <th>工賃合計</th>
                <th>税抜合計</th>
                <th>税込合計</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ number_format($products[1]['profitTotal'] ?? 0) }} 円</td>
                <td>{{ number_format($products[1]['wagesTotal'] ?? 0) }} 円</td>
                <td>{{ number_format($products[1]['taxExcludedTotal'] ?? 0) }} 円</td>
                <td>{{ number_format($products[1]['taxIncludedTotal'] ?? 0) }} 円</td>
            </tr>
        </tbody>
    </table>
<h2>{{ $makers['maker3'] ?? '未選択' }}</h2>
<table border="1">
        <thead>
            <tr>
                <th>商品代金</th>
                <th>工賃合計</th>
                <th>税抜合計</th>
                <th>税込合計</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ number_format($products[2]['profitTotal'] ?? 0) }} 円</td>
                <td>{{ number_format($products[2]['wagesTotal'] ?? 0) }} 円</td>
                <td>{{ number_format($products[2]['taxExcludedTotal'] ?? 0) }} 円</td>
                <td>{{ number_format($products[2]['taxIncludedTotal'] ?? 0) }} 円</td>
            </tr>
        </tbody>
    </table>

</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <title>PDF</title>
</head>
<body>
    <h1>キーワード: {{ $keyword }}</h1>

    <h2>商品ごとのデータ</h2>
    <table border="1">
        <thead>
            <tr>
                <th>商品番号</th>
                <th>メーカー</th>
                <th>商品代金</th>
                <th>工賃合計</th>
                <th>税抜合計</th>
                <th>税込合計</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>商品1</td>
                <td>{{ $makers['maker1'] ?? '未選択' }}</td>
                <td>{{ number_format($products[0]['profitTotal'] ?? 0) }} 円</td>
                <td>{{ number_format($products[0]['wagesTotal'] ?? 0) }} 円</td>
                <td>{{ number_format($products[0]['taxExcludedTotal'] ?? 0) }} 円</td>
                <td>{{ number_format($products[0]['taxIncludedTotal'] ?? 0) }} 円</td>
            </tr>
            <tr>
                <td>商品2</td>
                <td>{{ $makers['maker2'] ?? '未選択' }}</td>
                <td>{{ number_format($products[1]['profitTotal'] ?? 0) }} 円</td>
                <td>{{ number_format($products[1]['wagesTotal'] ?? 0) }} 円</td>
                <td>{{ number_format($products[1]['taxExcludedTotal'] ?? 0) }} 円</td>
                <td>{{ number_format($products[1]['taxIncludedTotal'] ?? 0) }} 円</td>
            </tr>
            <tr>
                <td>商品3</td>
                <td>{{ $makers['maker3'] ?? '未選択' }}</td>
                <td>{{ number_format($products[2]['profitTotal'] ?? 0) }} 円</td>
                <td>{{ number_format($products[2]['wagesTotal'] ?? 0) }} 円</td>
                <td>{{ number_format($products[2]['taxExcludedTotal'] ?? 0) }} 円</td>
                <td>{{ number_format($products[2]['taxIncludedTotal'] ?? 0) }} 円</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
