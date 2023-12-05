<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

//php artisan schedule:list
//php artisan schedule:work
//php artisan todo

class GrowCtrl extends Controller{

    protected function updateStatus($id, $status){
        DB::connection('mysql2')
        ->table('demat')
        ->where('id', $id)
        //->where('id', 1)
        ->update(['sid_grow_status' => $status]);
    }

    public function data(){
        Log::alert('Grow');

        $res    = DB::connection('mysql2')
                        ->table('demat')
                        ->select('id', 'sharecode', 'sid', 'sid_grow', 'sid_grow_status')
                        ->whereNotNull('sid')
                        ->whereNotNull('sid_grow')
                        ->whereNull('sid_grow_status')
                        ->first();

        Log::info(json_encode($res));
        if(!$res){
            Log::info('-: sid_grow : All completed :-');
            $res = DB::connection('mysql2')
                        ->table('demat')
                        ->whereNotNull('sid')
                        ->whereNull('sid_grow')
                        ->whereNull('sid_grow_status')
                        ->update(['sid_grow' => DB::raw('sharecode')]);

            /*
            UPDATE demat SET sid_grow = sharecode 
                            where sid_grow is NULL 
                            and sharecode != '' 
                            and sid_grow_status is NULL;
            */
            return;
        }
        Log::info(json_encode($res));

        //".$name."/weekly?intervalInDays=1&minimal=true";
        $grow	= 'https://groww.in/v1/api/charting_service/v2/chart/delayed/exchange/NSE/segment/CASH/';
        $url    = $grow.$res->sid_grow.'/all?intervalInDays=3&minimal=true';
        $data   = Http::timeout(10)->get($url);
        $table  = 'stock_pricehistory';

        if(!$data->successful()){
            $this->updateStatus($res->id, 2);
            return;
        }

        //Log::alert(json_encode($data->json()));
        $this->updateStatus($res->id, 1);
        

        $data 		= collect($data->json())->toArray();

        //dd($data['candles'][0][1]);

        $t 			= $data['candles'][0][0];
        $minVal 	= $data['candles'][0][1];
        $t2 		= $data['candles'][0][0];
        $maxVal 	= $data['candles'][0][1];
        $year       = [];
        $yearData   = [];
        
        foreach($data['candles'] as $val){
            $y			= date('Y', $val[0]);
            if(!isset($yearData[$y]['open_price'])){
                $yearData[$y]['min_price']     = round($val[1]);
                $yearData[$y]['max_price']     = round($val[1]);
                $yearData[$y]['open_price'] = round($val[1]);
            }

            if($yearData[$y]['max_price'] < $val[1]){
                $yearData[$y]['max_price']     = round($val[1]);
            }
            
            if($yearData[$y]['min_price'] > $val[1]){
                $yearData[$y]['min_price']     = round($val[1]);
            }
        }

        //Log::info(json_encode($yearData));
        
        if(!empty($yearData)){
            $historydata = DB::connection('mysql2')
                                ->table($table)
                                ->where('sid', $res->sid)
                                ->get();
            
            if(!$historydata->count()){
                foreach($yearData as $key=>$val){
                    DB::connection('mysql2')
                        ->table($table)
                        ->insert([
                                    'share_id' => $res->id, 
                                    'sid' => $res->sid, 
                                    'year' => $key,
                                    'open_price' => $val['open_price'],
                                    'min_price' => $val['min_price'], 
                                    'max_price' => $val['max_price']
                                ]);
                }
            }
            else{
                foreach($yearData as $key=>$val){
                    if($key != date('Y')) continue;

                    DB::connection('mysql2')
                        ->table($table)
                        ->where([
                                    'share_id' => $res->id,
                                    'sid' => $res->sid,
                                    'year' => $key
                                ])
                        ->update([
                                    'open_price' => $val['open_price'],
                                    'min_price' => $val['min_price'], 
                                    'max_price' => $val['max_price']
                                ]);

                }
            }
        }


   }
}