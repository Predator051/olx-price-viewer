<?php

namespace App\Console\Commands;

use App\Services\PriceAlertService;
use Illuminate\Console\Command;

class PriceChangeNotification extends Command
{
    public function __construct(private readonly PriceAlertService $alertService)
    {
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:price-change-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check subscriptions on prices and sent notification if it was changed';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $count = $this->alertService->notifySubscribersOnPriceChange();
        $this->info("Count of planned: {$count}", 'success');
    }
}
