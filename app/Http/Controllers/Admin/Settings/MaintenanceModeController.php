<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MaintenanceOnRequest;
use App\Models\Admin;
use App\Models\Admin\Maintenance;
use Illuminate\Console\Command;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;

class MaintenanceModeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:maintenance-mode-index,admin');
    }

    public function maintenanceMode()  {
        $maintenances = Maintenance::with('admin')->orderBy('maintenances.id','DESC')->get();
        return view('backend.blade.settings.maintenance_mode',compact('maintenances'));
    }

    public function maintenanceModeOn(MaintenanceOnRequest $data) : Response{
        $this->down($data->makeCommand());
        return response([
            'title'=>__('admin_local.Congratulations !'),
            'text'=>__('admin_local.Maintenance Mode Successfully Turned On'),
            'confirmButtonText'=>__('admin_local.Ok'),
        ]);
    }
    public function down(string $command) : Response {
        Artisan::call($command);
        return response([
            'ok'=>1,
        ]);
    }
    public function up() : RedirectResponse {
        Artisan::call('up');
        return to_route('admin.settings.server.maintenanceMode');
    }
}
