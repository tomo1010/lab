<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CompanyInfoForm extends Component
{
    public $company_postal;
    public $company_address;
    public $company_name;
    public $company_tel;
    public $company_fax;
    public $company_handyphone;
    public $company_mail;
    public $company_url;
    public $company_registration_number;
    public $company_transfer_1;
    public $company_transfer_2;
    public $company_transfer_3;
    public $company_note;

    public $saved = false; // ← 保存成功を判定するフラグ

    public function mount()
    {
        $user = Auth::user();
        $this->company_postal = $user->company_postal;
        $this->company_address = $user->company_address;
        $this->company_name = $user->company_name;
        $this->company_tel = $user->company_tel;
        $this->company_fax = $user->company_fax;
        $this->company_handyphone = $user->company_handyphone;
        $this->company_mail = $user->company_mail;
        $this->company_url = $user->company_url;
        $this->company_registration_number = $user->company_registration_number;
        $this->company_transfer_1 = $user->company_transfer_1;
        $this->company_transfer_2 = $user->company_transfer_2;
        $this->company_transfer_3 = $user->company_transfer_3;
        $this->company_note = $user->company_note;
    }

    public function save()
    {
        $this->validate([
            'company_postal' => 'nullable|string|max:20',
            'company_address' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'company_tel' => 'nullable|string|max:20',
            'company_fax' => 'nullable|string|max:20',
            'company_handyphone' => 'nullable|string|max:20',
            'company_mail' => 'nullable|email|max:255',
            'company_url' => 'nullable|string|max:255',
            'company_registration_number' => 'nullable|string|max:30',
            'company_transfer_1' => 'nullable|string|max:255',
            'company_transfer_2' => 'nullable|string|max:255',
            'company_transfer_3' => 'nullable|string|max:255',
            'company_note' => 'nullable|string|max:1000',
        ]);

        Auth::user()->update([
            'company_postal' => $this->company_postal,
            'company_address' => $this->company_address,
            'company_name' => $this->company_name,
            'company_tel' => $this->company_tel,
            'company_fax' => $this->company_fax,
            'company_handyphone' => $this->company_handyphone,
            'company_mail' => $this->company_mail,
            'company_url' => $this->company_url,
            'company_registration_number' => $this->company_registration_number,
            'company_transfer_1' => $this->company_transfer_1,
            'company_transfer_2' => $this->company_transfer_2,
            'company_transfer_3' => $this->company_transfer_3,
            'company_note' => $this->company_note,
        ]);

        $this->dispatch('show-message'); // Alpine にイベント送信
    }

    public function render()
    {
        return view('livewire.profile.company-info-form');
    }
}
