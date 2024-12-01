<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>商品一覧</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f5f5f5;
      margin: 0;
      padding: 20px;
    }
    
    .container {
      max-width: 800px;
      margin: 0 auto;
    }

    h1 {
      color: #333;
      text-align: center;
      margin-bottom: 20px;
    }

    ul.product-list {
      list-style: none;
      padding: 0;
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }

    .product-item {
      background-color: #fff;
      padding: 15px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      flex: 1 1 calc(50% - 20px); /* 2 items per row */
      box-sizing: border-box;
    }

    .product-name {
      font-size: 1.1em;
      font-weight: bold;
      color: #333;
      margin: 0 0 5px;
    }

    .product-price {
      font-size: 1em;
      color: #d9534f;
    }
  </style>
</head>
<body>

<div class="container">
  <h1>商品一覧</h1>
  <ul class="product-list">
    @foreach ($items as $item)
      <li class="product-item">
        <p class="product-name">{{ $item['itemName'] }}</p>
        <p class="product-price">{{ $item['totalItemPrice'] }}円</p>
        <p class="subtotal-price">（内工賃{{ $item['subtotalPrice'] }}円）</p>
        <p class="product-maker">{{  $item['maker'] }}</p>
      </li>
    @endforeach
  </ul>
</div>

</body>
</html>
