<?php
namespace App\Http\Controllers;

use App\Tool\UUID;
use App\Tool\Validate\ValidateCode;
use Illuminate\Http\Request;

class TestController extends Controller {
    public function index() {
        $uuid = UUID::create();
        echo $uuid;
    }
    public function get(Request $request) {
        echo $request->session()->get('validate_code', '');
    }
}