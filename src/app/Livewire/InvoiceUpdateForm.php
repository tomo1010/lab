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

    public $postal;
    public $address;
    public $name;
    public $tel;
    public $fax;
    public $mail;
    public $url;
    public $registration_number;
    public $transfer_1;
    public $transfer_2;
    public $transfer_3;

    public $showMessage = false;  // ← 追加



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

        $this->postal = $invoice->postal;
        $this->address = $invoice->address;
        $this->name = $invoice->name;
        $this->tel = $invoice->tel;
        $this->fax = $invoice->fax;
        $this->mail = $invoice->mail;
        $this->url = $invoice->url;
        $this->registration_number = $invoice->registration_number;
        $this->transfer_1 = $invoice->transfer_1;
        $this->transfer_2 = $invoice->transfer_2;
        $this->transfer_3 = $invoice->transfer_3;
    }

    public function getComputedTotalProperty()
    {
        return array_sum($this->prices);
    }

    // PDF生成のためのイベントリスナー    
    protected $listeners = ['updateAndGeneratePdf'];

    public function updateAndGeneratePdf()
    {
        $this->updateInvoice();
        // ↓ Livewire v3 正式仕様
        $this->dispatch('submit-pdf-form');
    }



    public function updateInvoice()
    {
        logger('✅ updateInvoice: 開始');

        $this->validate([
            'date' => 'nullable|date',
            'page_count' => 'nullable|integer|min:1|max:10',
            'client' => 'nullable|string',
            'to_suffix' => 'nullable|string|in:様,御中',
            'client_address' => 'nullable|string',
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
            // ▼ 発行者情報を追加
            'postal' => $this->postal,
            'address' => $this->address,
            'name' => $this->name,
            'tel' => $this->tel,
            'fax' => $this->fax,
            'mail' => $this->mail,
            'url' => $this->url,
            'registration_number' => $this->registration_number,
            'transfer_1' => $this->transfer_1,
            'transfer_2' => $this->transfer_2,
            'transfer_3' => $this->transfer_3,

        ]);

        for ($i = 1; $i <= 5; $i++) {
            $this->invoice->{'item_' . $i} = $this->items[$i - 1] ?? '';
            $this->invoice->{'price_' . $i} = $this->prices[$i - 1] ?? 0;
        }

        $this->invoice->save();

        // ✅ Alpine.js にメッセージ表示命令を送る
        $this->dispatch('show-message');
    }




    public function render()
    {
        return view('livewire.invoice-update-form');
    }
}
