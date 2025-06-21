<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CompanyInfoForm extends Component
{
    public $postal;
    public $address;
    public $company_name;
    public $tel;
    public $fax;
    public $company_mail;
    public $url;
    public $registration_number;
    public $transfer_1;
    public $transfer_2;
    public $transfer_3;
    public $note;

    public $saved = false; // ← 保存成功を判定するフラグ


    public function mount()
    {
        $user = Auth::user();
        $this->postal = $user->postal;
        $this->address = $user->address;
        $this->company_name = $user->company_name;
        $this->tel = $user->tel;
        $this->fax = $user->fax;
        $this->company_mail = $user->company_mail;
        $this->url = $user->url;
        $this->registration_number = $user->registration_number;
        $this->transfer_1 = $user->transfer_1;
        $this->transfer_2 = $user->transfer_2;
        $this->transfer_3 = $user->transfer_3;
        $this->note = $user->note;
    }

    public function save()
    {
        $user = Auth::user();

        $this->validate([
            'postal' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'tel' => 'nullable|string|max:20',
            'fax' => 'nullable|string|max:20',
            'company_mail' => 'nullable|email|max:255',
            'url' => 'nullable|string|max:255',
            'registration_number' => 'nullable|string|max:30',
            'transfer_1' => 'nullable|string|max:255',
            'transfer_2' => 'nullable|string|max:255',
            'transfer_3' => 'nullable|string|max:255',
            'note' => 'nullable|string|max:1000',
        ]);

        $user->update([
            'postal' => $this->postal,
            'address' => $this->address,
            'company_name' => $this->company_name,
            'tel' => $this->tel,
            'fax' => $this->fax,
            'company_mail' => $this->company_mail,
            'url' => $this->url,
            'registration_number' => $this->registration_number,
            'transfer_1' => $this->transfer_1,
            'transfer_2' => $this->transfer_2,
            'transfer_3' => $this->transfer_3,
            'note' => $this->note,
        ]);

        $this->dispatch('show-message'); // Alpine にイベント送信

    }

    public function render()
    {
        return view('livewire.profile.company-info-form');
    }
}
