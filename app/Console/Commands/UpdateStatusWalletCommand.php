<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateStatusWalletCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status every 60 minutes based';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $investor_with_plants = DB::table('investor_with_plants')
            ->join('wallets', 'investor_with_plants.wallet_id', '=', 'wallets.id')
            ->select('investor_with_plants.*', 'wallets.status as wallet_status')
            ->where('investor_with_plants.status', 0)
            ->where('investor_with_plants.created_at', '<=', now()->subMinutes(60))
            ->get();
        foreach ($investor_with_plants as $value) {
            if ($value->wallet_status == 1 && $value->status == 0) {
                DB::table('investor_with_plants')
                    ->where('id', $value->id)
                    ->update(['status' => 3]);

                DB::table('wallets')
                    ->where('id', $value->wallet_id)
                    ->update(['status' => 0]);
            }
        }
    }
}