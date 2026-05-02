<?php

declare(strict_types=1);

namespace App\MoonShine\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use MoonShine\Contracts\Core\DependencyInjection\CrudRequestContract;
use MoonShine\Laravel\Http\Controllers\MoonShineController;
use Symfony\Component\HttpFoundation\Response;

final class SettingController extends MoonShineController
{
    public function setting(Request $request): Response
    {
        $data = $request->except(['_token', '_method', '_component_name']);
        Storage::disk('config')->put("moonshine/setting.php", "<?php\n\n" . 'return ' . var_export($data, true) . ";\n");
        cache_clear();
        return back();
    }
}
