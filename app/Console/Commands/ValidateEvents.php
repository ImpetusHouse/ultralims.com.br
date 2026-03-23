<?php

namespace App\Console\Commands;

use App\Models\General\Events\Event;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ValidateEvents extends Command
{
    protected $signature = 'validate:events';
    protected $description = 'Valida os eventos que já passaram e marca eles como inativos';

    public function __construct(){
        parent::__construct();
    }

    public function handle(){
        $today = Carbon::today();

        // Buscar eventos que já passaram
        Event::where(function ($query) use ($today) {
            $query->where('end_date', '<', $today)
                ->orWhere(function ($query) use ($today) {
                    $query->whereNull('end_date')
                        ->where('date', '<', $today);
                });
        })->update(['status' => false]);

        Log::info('Eventos validados com sucesso.');
        $this->info('Eventos validados com sucesso.');
        return 0;
    }
}
