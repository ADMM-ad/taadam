<?php

namespace App\Providers;
use Illuminate\Support\Facades\View; 
use Illuminate\Support\Facades\Auth;
use App\Models\Jobdesk;
use App\Models\DetailJobdesk;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $userId = Auth::id();
    
                // Hitung jumlah jobdesk yang terkait dengan user yang sedang login dan statusnya "ditugaskan"
                $countDitugaskan = Jobdesk::where('status', 'ditugaskan')
                    ->whereHas('detailJobdesk', function ($query) use ($userId) {
                        $query->where('user_id', $userId);
                    })
                    ->count();
            } else {
                $countDitugaskan = 0;
            }
    
            $view->with('countDitugaskan', $countDitugaskan);
        });
    }
}
