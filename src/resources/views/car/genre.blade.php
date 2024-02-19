@extends('layouts.app')

@section('content')

    <p><h1>カテゴリ一</h1></p>

    <ul class="nav nav-tabs justify-content-center">
        <li class="nav-item"><a href="#size" class="nav-link active" data-toggle="tab">大きさ</a></li>
        <li class="nav-item"><a href="#choose" class="nav-link" data-toggle="tab">選ぶ楽しみ</a></li>
        <li class="nav-item"><a href="#utility" class="nav-link" data-toggle="tab">使い勝手</a></li>
        <li class="nav-item"><a href="#power" class="nav-link" data-toggle="tab">パワー</a></li>
        <li class="nav-item"><a href="#condition" class="nav-link" data-toggle="tab">絶対条件</a></li>
        <li class="nav-item"><a href="#trend" class="nav-link" data-toggle="tab">流行り</a></li>
        <li class="nav-item"><a href="#cost" class="nav-link" data-toggle="tab">維持費</a></li>
        <li class="nav-item"><a href="#money" class="nav-link" data-toggle="tab">お金</a></li>
    </ul>


        <div class="tab-content">

            <div id="size" class="tab-pane active">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>大きさ</th>
                            <th>コメント</th>                              
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>車体の大きさ</td>
                            <td>車体の大きさをミリ単位で比較</td>
                        </tr>
                        <tr>
                            <td>トレッド</td>
                            <td>左右タイヤの幅で比較</td>
                        </tr>
                        <tr>
                            <td>室内の広さ</td>
                            <td>室内の広さをミリ単位で比較</td>
                        </tr>
                        <tr>
                            <td>排気量</td>
                            <td>エンジンの大きさで比較</td>
                        </tr>
                        <tr>
                            <td>タイヤサイズ</td>
                            <td>タイヤサイズで比較</td>
                        </tr>
                        <tr>
                            <td>サイズ</td>
                            <td>ざっくりS・M・Lのサイズ分けで比較</td>
                        </tr>
                        <tr>
                            <td>小廻り</td>
                            <td>小廻りがきくかどうかで比較</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div id="choose" class="tab-pane">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>選ぶ楽しみ</th>
                            <th>コメント</th>                              
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>車名</td>
                            <td>有名だからって選んでませんか？</td>
                        </tr>
                        <tr>
                            <td>メーカー</td>
                            <td>たまにはいつもと違うメーカーから</td>
                        </tr>
                        <tr>
                            <td>発売日</td>
                            <td>新型車はやっぱりイイ！</td>
                        </tr>
                        <tr>
                            <td>カラー</td>
                            <td>最近はカラーバリーションが豊富</td>
                        </tr>
                        <tr>
                            <td>選ぶ楽しみ</td>
                            <td>長距離乗る人は検討材料のひとつ</td>
                        </tr>
                        <tr>
                            <td>kg単価</td>
                            <td>クルマって1kgあたりいくら？</td>
                        </tr>
                        <tr>
                            <td>サイズ</td>
                            <td>ざっくりS・M・Lのサイズ分けで比較</td>
                        </tr>

                        {{-- ジャンル別分岐--}}
                        @if($genre == 'minivan')
                        <tr>
                            <td>スライドドア</td>
                            <td>スライドドアの有無</td>
                        </tr>
                        <tr>
                            <td>３列目</td>
                            <td>３列目シートの格納方法</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <div id="utility" class="tab-pane">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>使い勝手</th>
                            <th>コメント</th>                              
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>ホイールベース</td>
                            <td>前輪から後輪までの長さ</td>
                        </tr>
                        <tr>
                            <td>トレッド</td>
                            <td>左右タイヤの幅</td>
                        </tr>
                        <tr>
                            <td>室内の広さ</td>
                            <td>室内の広さをミリ単位で比較</td>
                        </tr>
                        <tr>
                            <td>乗り降りの高さ</td>
                            <td>高い方が乗りやすい？それとも逆？</td>
                        </tr>
                        <tr>
                            <td>燃料タンク容量</td>
                            <td>気にする人は気にする比較項目</td>
                        </tr>
                        <tr>
                            <td>小廻り</td>
                            <td>駐車場での運転しやすさに直結</td>
                        </tr>

                        {{-- ジャンル別分岐--}}
                        @if($genre == 'minivan')
                        <tr>
                            <td>スライドドア</td>
                            <td>スライドドアの有無</td>
                        </tr>
                        <tr>
                            <td>３列目</td>
                            <td>３列目シートの格納方法</td>
                        </tr>
                        <tr>
                            <td>乗車人数</td>
                            <td>ミニバンは６人以上乗れるのが魅力のひとつ</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>


            <div id="power" class="tab-pane">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>パワー</th>
                            <th>コメント</th>                              
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>重さ</td>
                            <td>車輌の重量でもパワーが違ってきます</td>
                        </tr>
                        <tr>
                            <td>排気量</td>
                            <td>エンジンの大きさ</td>
                        </tr>
                        <tr>
                            <td>馬力</td>
                            <td>クルマのパワーといえば馬力</td>
                        </tr>
                        <tr>
                            <td>トルク</td>
                            <td>出足の強さ</td>
                        </tr>

                        {{-- ジャンル別分岐--}}
                        @if($genre == 'suv')
                        <tr>
                            <td>スライドドア</td>
                            <td>スライドドアの有無</td>
                        </tr>
                        <tr>
                            <td>３列目</td>
                            <td>３列目シートの格納方法</td>
                        </tr>
                        <tr>
                            <td>乗車人数</td>
                            <td>ミニバンは６人以上乗れるのが魅力のひとつ</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>


            <div id="condition" class="tab-pane">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>絶対条件</th>
                            <th>コメント</th>                              
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>車名</td>
                            <td>欲しいクルマの名前は何？</td>
                        </tr>
                        <tr>
                            <td>メーカー</td>
                            <td>メーカーで選ぶのみアリ</td>
                        </tr>
                        <tr>
                            <td>価格</td>
                            <td>予算は大事</td>
                        </tr>
                        <tr>
                            <td>車体の大きさ</td>
                            <td>車体の大きさをミリ単位で比較</td>
                        </tr>
                        <tr>
                            <td>乗車人数</td>
                            <td>６人以上のる用途があるなら必須</td>
                        </tr>
                        <tr>
                            <td>乗り降りの高さ</td>
                            <td>こちらも大事といえば大事</td>
                        </tr>

                        {{-- ジャンル別分岐--}}
                        @if($genre == 'minivan')
                        <tr>
                            <td>スライドドア</td>
                            <td>スライドドアの有無</td>
                        </tr>
                        <tr>
                            <td>３列目</td>
                            <td>３列目シートの格納方法</td>
                        </tr>
                        <tr>
                            <td>形</td>
                            <td>同じミニバンでも形が違います</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <div id="trend" class="tab-pane">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>流行り</th>
                            <th>コメント</th>                              
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>発売日</td>
                            <td>新型車種が欲しい！</td>
                        </tr>
                        <tr>
                            <td>カラー</td>
                            <td>色も流行りがあります</td>
                        </tr>
                        <tr>
                            <td>燃費</td>
                            <td>今どきの流行りはコレ</td>
                        </tr>

                        {{-- ジャンル別分岐--}}
                        @if($genre == 'minivan')
                        <tr>
                            <td>形</td>
                            <td>ミニバンでも形が違うます</td>
                        </tr>
                        <tr>
                            <td>乗車人数</td>
                            <td>８人乗りよりも７人乗り？</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <div id="cost" class="tab-pane">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>維持費</th>
                            <th>コメント</th>                              
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>価格</td>
                            <td>基本のき</td>
                        </tr>
                        <tr>
                            <td>重さ</td>
                            <td>実燃費に関係します</td>
                        </tr>
                        <tr>
                            <td>重量税</td>
                            <td>車検時の税金のひとつ</td>
                        </tr>
                        <tr>
                            <td>燃費</td>
                            <td>日常生活に直結する維持費</td>
                        </tr>
                        <tr>
                            <td>自動車税</td>
                            <td>毎年支払う税金</td>
                        </tr>
                        <tr>
                            <td>タイヤサイズ</td>
                            <td>年間走行距離が多い人はチェック</td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <div id="money" class="tab-pane">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>お金</th>
                            <th>コメント</th>                              
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>価格</td>
                            <td>クルマを買う時のお金の話</td>
                        </tr>
                        <tr>
                            <td>自動車税</td>
                            <td>毎年支払う税金</td>
                        </tr>
                        <tr>
                            <td>重量税</td>
                            <td>車検時の税金のひとつ</td>
                        </tr>
                        <tr>
                            <td>kg単価</td>
                            <td>クルマって1kgあたりいくら？</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>

@endsection