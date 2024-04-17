<?php

namespace App\Console;

use App\Models\Tenant;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            error_log('Running subscription check');
            $tenants = Tenant::whereDate('subscription_ends_at', '=', now()->startOfDay())
                ->get();

            foreach ($tenants as $tenant) {
                if ($tenant->transactions()->where('reference', 'like', 'subscription-%')->whereDate('created_at', '=', now()->startOfDay())->exists()) {
                    continue;
                }

                $tenant->balance -= $tenant->plan->price;
                $tenant->transactions()->create([
                    'amount' => -$tenant->plan->price,
                    'notes' => $tenant->plan->name,
                    'reference' => 'subscription-' . $tenant->plan->id . '-' . now()->format('m-d-Y')
                ]);

                $tenant->suspended = $tenant->balance < 0;

                $plan = $tenant->plan;
                switch ($plan->duration_unit) {
                    case 'day':
                        $tenant->subscription_ends_at = now()->addDays($plan->duration);
                        break;

                    case 'month':
                        $tenant->subscription_ends_at = now()->addMonths($plan->duration);
                        break;

                    case 'year':
                        $tenant->subscription_ends_at = now()->addYears($plan->duration);
                        break;
                    default:
                        # code...
                        break;
                }

                $tenant->save();
            }



        })->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
