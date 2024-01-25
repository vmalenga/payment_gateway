<?php

namespace App\Repositories;

use App\Http\Resources\Country\CountryCollection;
use App\Http\Resources\Country\CountryResource;
use App\Http\Resources\Partner\PartnerCollection;
use App\Http\Resources\Partner\PartnerResource;
use App\Models\Auth\Partner;
use App\Models\System\Country;
use App\Repositories\Interfaces\CountryRepositoryInterface;
use App\Repositories\Interfaces\PartnerRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PartnerRepository implements PartnerRepositoryInterface
{
    public function all(array $params = []): PartnerCollection
    {
        $per_page = 0;
        if(isset($params['per_page'])){
            $per_page = $params['per_page'];
        }
        else{
            $par_page = Partner::where('id', '>', 0)->get()->count();
        }

        return new PartnerCollection(Partner::paginate($par_page));
    }

    public function save(array $data, Partner $partner = null): PartnerResource
    {
        try{
            DB::beginTransaction();

            $data['updated_by'] = Auth::id();
            if($partner){
                $partner->update($data);
            }
            else{
                $data['created_by'] = Auth::id();

                $partner = Partner::withTrashed()->where(['name' => $data['name']])->first();

                if($partner){
                    $partner->restore();
                    $partner->update($data);
                }
                else{
                    $partner = Partner::create($data);
                }
            }

            DB::commit();

            return new PartnerResource(Partner::find($partner->id));
        }
        catch(Exception $exception){
            DB::rollBack();
            throw $exception;
        }
    }

    public function get(Partner $partner): PartnerResource
    {
        try{
            return new PartnerResource($partner);
        }
        catch(Exception $exception){
            throw $exception;
        }
    }

    public function delete(Partner $partner): void
    {
        try{
            DB::beginTransaction();

            $partner->delete();

            DB::commit();
        }
        catch(Exception $exception){
            DB::rollBack();
            throw $exception;
        }
    }
}
