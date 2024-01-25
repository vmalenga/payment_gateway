<?php

namespace App\Repositories;

use App\Http\Resources\Zone\ZoneCollection;
use App\Http\Resources\Zone\ZoneResource;
use App\Models\System\Zone;
use App\Repositories\Interfaces\ZoneRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ZoneRepository implements ZoneRepositoryInterface
{
    public function all(array $params = []): ZoneCollection
    {
        $per_page = 0;
        if(isset($params['per_page'])){
            $per_page = $params['per_page'];
        }
        else{
            $par_page = Zone::where('id', '>', 0)->get()->count();
        }

        return new ZoneCollection(Zone::paginate($par_page));
    }

    public function save(array $data, Zone $zone = null): ZoneResource
    {
        try{
            DB::beginTransaction();

            $data['updated_by'] = Auth::id();
            if($zone){
                $zone->update($data);
            }
            else{
                $data['created_by'] = Auth::id();

                $zone = Zone::withTrashed()->where(['code' => $data['code']])->first();

                if($zone){
                    $zone->restore();
                    $zone->update($data);
                }
                else{
                    $zone = Zone::create($data);
                }
            }

            DB::commit();

            return new ZoneResource(Zone::find($zone->id));
        }
        catch(Exception $exception){
            DB::rollBack();
            throw $exception;
        }
    }

    public function get(Zone $zone): ZoneResource
    {
        try{
            return new ZoneResource($zone);
        }
        catch(Exception $exception){
            throw $exception;
        }
    }

    public function delete(Zone $zone): void
    {
        try{
            DB::beginTransaction();

            $zone->delete();

            DB::commit();
        }
        catch(Exception $exception){
            DB::rollBack();
            throw $exception;
        }
    }
}
