<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function settings()
    {
        $app = Setting::all()->last();

        return view('app.settings', compact('app'));
    }

    public function update_settings(Request $request)
    {
        $app = Setting::all()->last();

        $app->app_name = $request->app_name;
        $app->company_name = $request->company_name;

        $app->update();

        return redirect()->back()->with('toast_success', 'App settings changed');
    }
}
