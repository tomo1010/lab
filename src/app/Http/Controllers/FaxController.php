<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use PDF;

class FaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //if (\Auth::check()) { // 認証済みの場合
        //    // 認証済みユーザを取得
        //    $user = \Auth::user();
        //    // ユーザの投稿の一覧を作成日時の降順で取得
        //    $Faxs = $user->Faxs()->orderBy('updated_at', 'desc')->paginate(10);
        //}
        //dd($_COOKIE);
        return view('fax.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * 
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->action === 'pdf') {
            return $this->createPdf($request); // PDF生成処理
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    /**
     * PDF作成
     */

    //送付状
    public function sendPdf(Request $request)
    {

        $data = $request->all();
        $date['date'] = now()->format('Y-m-d');
        $data['date'] = $date['date'];
        //dd($data);
        $pdf = PDF::loadView('fax.sendPdf', $data);

        return $pdf->stream('fax_' . $data['date'] . '.pdf');
    }


    //車両入替え
    public function changePdf(Request $request)
    {
        $validated = $request->validate([
            'send_date'   => ['required', 'date'],
            'change_date' => ['required', 'date'],
            // 他の入力も必要に応じて追加
        ]);

        $sendDate   = \Carbon\Carbon::parse($validated['send_date'])->format('Y-m-d');
        $changeDate = \Carbon\Carbon::parse($validated['change_date'])->format('Y-m-d');

        // Viewに渡すデータを整える（$request->all() ベースで上書き）
        $data = $request->all();
        $data['send_date']   = $sendDate;
        $data['change_date'] = $changeDate;

        $pdf = \PDF::loadView('fax.changePdf', $data);

        // 例：送信日をファイル名に使用
        return $pdf->stream('fax_' . $sendDate . '.pdf');
    }
}
