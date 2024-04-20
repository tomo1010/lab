

<table class="table table-striped">
            <thead>
                <tr>
                    <th>車名</th>
                    <th></th>                              
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)

                <tr>
                    <td>
                    <img src="{{ $item['mediumImageUrls'] }}">
                    </td>
                </tr>
                <tr>
                    <td>
                        {{ $item['itemName'] }}
                    </td>
                </tr>

                @endforeach
            </tbody>
        </table>
