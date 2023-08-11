<?php

namespace App\Http\Controllers;

use App\Services\SalustianoCsvService;
use Illuminate\Http\Request;

class TestController extends Controller
{

    public function __construct(
        private SalustianoCsvService $salustianoCsvService
    ){}

    public function test1(){
        return view('test1');
    }

    public function test2(){
        return view('test2');
    }

    public function test3(){
        return view('test3');
    }

    public function exportCsv(Request $request) {
        try{
            $dataToExport = $request->input('dataToExport');
            $this->salustianoCsvService->exportCsv($dataToExport);
        }catch (\Exception $ex){
            return response()->json(['error' => 'Parâmetros informados incorretamente.'], 400);
        }
    }
}
