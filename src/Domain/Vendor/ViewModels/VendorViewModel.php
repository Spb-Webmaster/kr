<?php
namespace Domain\Vendor\ViewModels;

use App\Models\Vendor;
use Domain\Vendor\DTOs\VendorDto;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Support\Traits\Makeable;

class VendorViewModel
{
    use Makeable;

    public function create($array, $request = null): ?Model
    {
        $data = VendorDto::formRequest($request->merge($array));
        return Vendor::create($data->toArray());

    }

    public function vendor($request = null): ?Model
    {
         return Vendor::query()
             ->where('email', $request->email)
             ->where('password', trim($request->password))
             ->where('published', 1)
             ->first();
    }

    public function v($email): Vendor|RedirectResponse
    {
        $v =  Vendor::query()
            ->where('email', $email)
            ->where('published', 1)
            ->first();
        if (is_null($v)) {
            flash()->alert(config('message_flash.alert.__enter_error'));
            return redirect(route('vendor_login'));
        }
        return $v;
    }



}
