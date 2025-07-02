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
    public $items = []; // ['name' => '', 'price' => 0] の配列のリスト
    public $message;


    public $showMessage = false;

    protected $listeners = ['updateAndGeneratePdf'];

    public function mount(Invoice $invoice)
    {
        $this->invoice = $invoice;

        $this->date = $invoice->date;
        $this->page_count = $invoice->page_count;
        $this->client = $invoice->client;
        $this->to_suffix = $invoice->to_suffix;
        $this->client_address = $invoice->client_address;
        $this->message = $invoice->message;

        // ✅ JSON文字列からPHP配列にデコード
        $this->items = is_string($invoice->items)
            ? json_decode($invoice->items, true)
            : ($invoice->items ?? []);

        //データがない場合は5件分の空項目を初期化
        if (empty($this->items)) {
            $this->items = array_fill(0, 5, ['name' => '', 'price' => 0]);
        }
    }

    public function getComputedTotalProperty()
    {
        return array_sum(
            array_map(fn($item) => (int) ($item['price'] ?? 0), $this->items)
        );
    }


    public function updateAndGeneratePdf()
    {
        $this->updateInvoice();
        $this->dispatch('submit-pdf-form');
    }

    public function updateInvoice()
    {
        logger('✅ updateInvoice: 開始');
        //dd($this->items);

        $this->validate([
            'date' => 'nullable|date',
            'page_count' => 'nullable|integer|min:1|max:10',
            'client' => 'nullable|string|max:255',
            'to_suffix' => 'nullable|string|max:10',
            'client_address' => 'nullable|string|max:255',
            'message' => 'nullable|string|max:500',

            'items' => 'array',
            'items.*.name' => 'nullable|string|max:255',
            'items.*.price' => 'nullable|numeric|min:0',
        ]);

        // 空項目の除外（store()と同様）
        $filteredItems = collect($this->items)
            ->filter(function ($item) {
                return !empty($item['name']) || !empty($item['price']);
            })
            ->values()
            ->all();

        $this->invoice->update([
            'date' => $this->date,
            'page_count' => $this->page_count,
            'client' => $this->client,
            'to_suffix' => $this->to_suffix,
            'client_address' => $this->client_address,
            'message' => $this->message,
            'items' => $filteredItems,
            'total' => $this->computedTotal,
        ]);

        $this->dispatch('show-message');
    }


    public function render()
    {
        return view('livewire.invoice-update-form');
    }
}
