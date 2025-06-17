<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Invoice;

class InvoiceUpdateForm extends Component
{
    public $invoice;

    public $date;
    public $page_count;
    public $client;
    public $to_suffix;
    public $client_address;
    public $items = [];
    public $prices = [];
    public $message;

    public function mount(Invoice $invoice)
    {
        $this->invoice = $invoice;

        $this->date = $invoice->date;
        $this->page_count = $invoice->page_count;
        $this->client = $invoice->client;
        $this->to_suffix = $invoice->to_suffix;
        $this->client_address = $invoice->client_address;

        for ($i = 0; $i < 5; $i++) {
            $this->items[$i] = $invoice->{'item_' . ($i + 1)} ?? '';
            $this->prices[$i] = $invoice->{'price_' . ($i + 1)} ?? 0;
        }

        $this->message = $invoice->message;
    }

    public function getComputedTotalProperty()
    {
        return array_sum($this->prices);
    }



    // PDF生成のためのイベントリスナー    
    protected $listeners = ['updateAndGeneratePdf'];

    public function updateAndGeneratePdf()
    {
        $this->updateInvoice(); // 保存処理を実行

        // ブラウザ側へPDF送信命令（Livewire側からJSイベント発火）
        $this->dispatchBrowserEvent('submit-pdf-form');
    }




    public function updateInvoice()
    {
        $this->validate([
            'date' => 'required|date',
            'page_count' => 'required|integer|min:1|max:10',
            'client' => 'required|string',
            'to_suffix' => 'required|string|in:様,御中',
            'client_address' => 'required|string',
            'message' => 'nullable|string',
        ]);

        $this->invoice->update([
            'date' => $this->date,
            'page_count' => $this->page_count,
            'client' => $this->client,
            'to_suffix' => $this->to_suffix,
            'client_address' => $this->client_address,
            'message' => $this->message,
            'total' => $this->computedTotal,
        ]);

        for ($i = 1; $i <= 5; $i++) {
            $this->invoice->{'item_' . $i} = $this->items[$i - 1] ?? '';
            $this->invoice->{'price_' . $i} = $this->prices[$i - 1] ?? 0;
        }

        $this->invoice->save();

        session()->flash('message', 'データを更新しました。');
    }

    public function render()
    {
        return view('livewire.invoice-update-form');
    }
}
