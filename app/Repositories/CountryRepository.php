<?php

namespace App\Repositories;

use App\Http\Resources\Country\CountryCollection;
use App\Http\Resources\Country\CountryResource;
use App\Models\System\Country;
use App\Repositories\Interfaces\CountryRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CountryRepository implements CountryRepositoryInterface
{
    public function all(array $params = []): CountryCollection
    {
        $per_page = 0;
        if(isset($params['per_page'])){
            $per_page = $params['per_page'];
        }
        else{
            $par_page = Country::where('id', '>', 0)->get()->count();
        }

        return new CountryCollection(Country::paginate($par_page));
    }

    public function save(array $data, Country $country = null): CountryResource
    {
        try{
            DB::beginTransaction();

            $data['updated_by'] = Auth::id();
            if($country){
                $country->update($data);
            }
            else{
                $data['created_by'] = Auth::id();

                $country = Country::withTrashed()->where(['name' => $data['name']])->first();

                if($country){
                    $country->restore();
                    $country->update($data);
                }
                else{
                    $country = Country::create($data);
                }
            }

            DB::commit();

            return new CountryResource(Country::find($country->id));
        }
        catch(Exception $exception){
            DB::rollBack();
            throw $exception;
        }
    }

    public function get(Country $country): CountryResource
    {
        try{
            return new CountryResource($country);
        }
        catch(Exception $exception){
            throw $exception;
        }
    }

    public function delete(Country $country): void
    {
        try{
            DB::beginTransaction();

            $country->delete();

            DB::commit();
        }
        catch(Exception $exception){
            DB::rollBack();
            throw $exception;
        }
    }
}
