<?php
namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\File;
use App\Sale;

class AdminStatsComposer
{
    public function compose(View $view)
    {
        $view->with([
            'fileCount' => File::finished()->hasApproved()->count(),
            'saleCount' => Sale::count(),
            'monthCommission' => Sale::monthCommission(),
            'lifetimeCommission' => Sale::lifetimeCommission(),
        ]);
    }
}