<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\Models\PdfAccessLog;
use Carbon\Carbon;

class PdfAccessService
{
    public function canAccess(string $page): bool
    {
        $today = Carbon::today();
        $user = Auth::user();
        $ip = Request::ip();

        if ($user) {
            // サブスクユーザーは無制限
            if ($user->subscribed()) {
                return true;
            }

            // ログインユーザーは1日5回まで
            $count = PdfAccessLog::where('user_id', $user->id)
                ->where('page', $page)
                ->whereDate('access_date', $today)
                ->count();

            return $count < 10;
            
        } else {
            // 未ログインユーザーはIPアドレスで判定、1日1回まで（厳密でなくてOK）
            $count = PdfAccessLog::where('ip_address', $ip)
                ->where('page', $page)
                ->whereDate('access_date', $today)
                ->count();

            return $count < 3;
        }
    }

    public function logAccess(string $page): void
    {
        $user = Auth::user();
        PdfAccessLog::create([
            'user_id' => $user?->id,
            'page' => $page,
            'ip_address' => $user ? null : Request::ip(),
            'access_date' => Carbon::today(),
        ]);
    }
}
