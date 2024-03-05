@if($spec == 'maker')
    メーカー
@elseif($spec == 'maker_kana')
    メーカー英語
@elseif($spec == 'name')
    車名
@elseif($spec == 'release')
    発売日
@elseif($spec == 'grade')
    グレード
@elseif($spec == 'price')
    価格
@elseif($spec == 'model')
    型式
@elseif($spec == 'turningradius')
    最小回転半径
@elseif($spec == 'drive')
    駆動方式
@elseif($spec == 'size_length')
    全長
@elseif($spec == 'size_width')
    全幅
@elseif($spec == 'size_height')
    全高
@elseif($spec == 'size')
    大きさ
@elseif($spec == 'door')
    ドア数
@elseif($spec == 'wheelbase')
    ホイールベース
@elseif($spec == 'mission')
    ミッション
@elseif($spec == 'tred')
    前トレッド/後トレッド
@elseif($spec == 'shift')
    AI-SHIFT
@elseif($spec == 'indoorsize_length')
室内長
@elseif($spec == 'indoorsize_width')
室内幅
@elseif($spec == 'indoorsize_height')
室内高
@elseif($spec == 'indoorsize')
室内大きさ
@elseif($spec == 'fourws')
4WS
@elseif($spec == 'weight')
車輌重量
@elseif($spec == 'seats')
シート数
@elseif($spec == 'capacity')
最大積載量
@elseif($spec == 'ridingcapacity')
乗車定員
@elseif($spec == 'grossweight')
車輌総重量
@elseif($spec == 'missionposition')
ミッション位置
@elseif($spec == 'groundclearance')
最低地上高
@elseif($spec == 'manualmode')
マニュアルモード
@elseif($spec == 'colors')
色数
@elseif($spec == 'comment')
掲載コメント
@elseif($spec == 'enginemodel')
エンジン型式
@elseif($spec == 'environmentalengine')
環境対策エンジン
@elseif($spec == 'kinds')
種類
@elseif($spec == 'fuel')
使用燃料
@elseif($spec == 'supercharger')
過給機
@elseif($spec == 'fueltank')
燃料タンク
@elseif($spec == 'cylinderdevice')
可変気筒装置
@elseif($spec == 'JC08')
燃費（JC08）
@elseif($spec == 'displacement')
総排気量
@elseif($spec == 'WLTC')
燃費（WLTC）
@elseif($spec == 'achievedfuel')
燃費基準達成
@elseif($spec == 'ps')
最高出力
@elseif($spec == 'torque')
最大トルク
@elseif($spec == 'position')
位置
@elseif($spec == 'steeringgear')
ステアリングギア方式
@elseif($spec == 'powersteering')
パワーステアリング
@elseif($spec == 'VGS')
VGS/VGRS
@elseif($spec == 'suspensionF')
サスペンション形式　前
@elseif($spec == 'suspensionR')
サスペンション形式　後
@elseif($spec == 'tiresizeF')
タイヤサイズ　前
@elseif($spec == 'tiresizeR')
タイヤサイズ　後
@elseif($spec == 'braketypeF')
ブレーキ形式　前
@elseif($spec == 'braketypeR')
ブレーキ形式　後

{{--計算必要なスペック--}}
@elseif($spec == 'tax')
自動車税
@elseif($spec == 'jtax')
重量税
@elseif($spec == 'kg')
kg単価
@elseif($spec == 'cruising')
航続距離

{{--その他--}}
@elseif($spec == 'half')
上半期・下半期

@endif