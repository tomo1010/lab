<!DOCTYPE html>
<html>
<head>
    <title>PDF</title>
</head>
<body>
    <h1>お見積書</h1>

    @if(!empty($address) || !empty($honorific))
        {{ $address ?? '　　　　　' }} {{ $honorific ?? '' }}
    @endif

    {{ $date }}

    <h2>{{ $selectTire }}</h2>
    <h2>
        @if(!empty($sizeFree) || !empty($sizeGeneral))
            {{ $sizeFree ?? '' }} {{ $sizeGeneral ?? '' }}
        @endif
    </h2>

    @if(($products[0]['profitTotal'] ?? 0) != 0)
        <h2>{{ $makers['maker1'] ?? '商品A' }}</h2>
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
    @endif

    @if(($products[1]['profitTotal'] ?? 0) != 0)
        <h2>{{ $makers['maker2'] ?? '商品B' }}</h2>
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
    @endif

    @if(($products[2]['profitTotal'] ?? 0) != 0)
        <h2>{{ $makers['maker3'] ?? '商品C' }}</h2>
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
    @endif

    <p>{{ $comment }}</p>
    <br>
    ※見積もり有効期限は発行から１週間<br>

</body>
</html>
