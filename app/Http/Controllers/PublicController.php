<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class PublicController extends Controller
{
    public function systemInformations(){
        $systemInformation = systemInformation();
        return response()->json([
            "name" => $systemInformation->name,
            "phone" => $systemInformation->phone,
            "mobile" => $systemInformation->mobile,
            "address" => $systemInformation->address,
            "email" => $systemInformation->email,
            "twitter" => $systemInformation->twitter,
            "facebook" => $systemInformation->facebook,
            "instagram" => $systemInformation->instagram,
            "skype" => $systemInformation->skype,
            "linked_in" => $systemInformation->linked_in,
            "logo" => documentUrl("system-images/logos/".$systemInformation->logo),
            "icon" => documentUrl("system-images/icons/".$systemInformation->icon),
        ], 200);
    }
}
