<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;


class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = collect(); // デフォルトで空のコレクションを作成

        //if (\Auth::check()) { // 認証済みの場合
        //    // 認証済みユーザを取得
        //    $user = \Auth::user();
        //    // ユーザの投稿の一覧を作成日時の降順で取得
        //    $invoices = $user->invoices()->orderBy('updated_at', 'desc')->paginate(10);
        //}

        return view('invoice.index', compact('invoices'));
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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


    public function createPdf(Request $request)
    {
        //dd($request);
        $data = $request->all();
        $date['date'] = now()->format('Y-m-d');
        $data['date'] = $date['date'];

        $pdf = PDF::loadView('invoice.createPdf', $data);

        return $pdf->stream('invoice_' . $data['date'] . '.pdf');
    }
}
