<?php

namespace App\Repositories;

use App\Http\Resources\Payment\PaymentCollection;
use App\Http\Resources\Payment\PaymentResource;
use App\Models\System\Payment;
use App\Repositories\Interfaces\PaymentRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentRepository implements PaymentRepositoryInterface
{
    public function all(array $params = []): PaymentCollection
    {
        $per_page = 0;
        if(isset($params['per_page'])){
            $per_page = $params['per_page'];
        }
        else{
            $par_page = Payment::whereHas('payer', function($q){
                $q->where(['partner_id' => 1]);
            })->get()->count();
        }

        return new PaymentCollection(Payment::whereHas('payer', function($q){
            $q->where(['partner_id' => 1]);
        })->paginate($par_page));
    }

    public function save(array $data, Payment $payment = null): PaymentResource
    {
        try{
            DB::beginTransaction();

            dd($data);
            if($payment){
                $payment->update($data);
            }
            else{
                $payment = Payment::create($data);
            }

            DB::commit();

            return new PaymentResource(Payment::find($payment->id));
        }
        catch(Exception $exception){
            DB::rollBack();
            throw $exception;
        }
    }

    public function get(Payment $payment): PaymentResource
    {
        try{
            return new PaymentResource($payment);
        }
        catch(Exception $exception){
            throw $exception;
        }
    }

    public function delete(Payment $payment): void
    {
        try{
            DB::beginTransaction();

            $payment->delete();

            DB::commit();
        }
        catch(Exception $exception){
            DB::rollBack();
            throw $exception;
        }
    }
}
