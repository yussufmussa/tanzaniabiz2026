<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SystemInfoController extends Controller
{
    public function __invoke(Request $request)
    {
       $systemInfo = [
        'PHP Version'       => phpversion(),
        'Laravel Version'   => app()->version(),
        'Server Software'   => request()->server('SERVER_SOFTWARE'),
        'Server IP Address' => request()->server('SERVER_ADDR'),
        'Server Protocol'   => request()->server('SERVER_PROTOCOL'),
        'HTTP Host'         => request()->getHost(),
        'Database Port'     => config('database.connections.mysql.port'),
        'App Environment'   => app()->environment(),
        'App Debug'         => config('app.debug') ? 'true' : 'false',
        'Timezone'          => config('app.timezone'),
    ];


        return view('backend.general_pages.system_info', compact('systemInfo'));
    }
}
