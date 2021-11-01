<?php

namespace App\Http\Controllers;

use App\Http\Requests\VehicleRequest;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VehiclesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('vehicles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    public function getAll(): JsonResponse
    {
        return response()->json(Vehicle::query()->with(['orders'])->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function store(VehicleRequest $request): JsonResponse
    {
        Vehicle::query()->create([
            'reg_no'=>$request->get('reg_no'),
        ]);

        return response()->json(
            Vehicle::getLastInserted()
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        Vehicle::query()->find($id)->update([
            'reg_no'=>$request->get('edit_vehicle')
        ]);

        return response()->json(
            Vehicle::getVehicleById($id)
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Vehicle::query()->find($id)->delete();
    }


    public function markVehicleLoading(Request $request)
    {
        $vehicle_id = $request->get('vehicle');
        Vehicle::markVehicleLoading($vehicle_id);
    }

    public function markVehicleOnTransit(Request $request)
    {
        $vehicle_id = $request->get('vehicle');
        Vehicle::markVehicleOnTransit($vehicle_id);
    }

    public function markVehicleAvailable(Request $request)
    {
        $vehicle_id = $request->get('vehicle');
        Vehicle::markVehicleAvailable($vehicle_id);
    }

    public function getAvailableVehicles(): JsonResponse
    {
        return response()->json(
            Vehicle::getAvailableVehicles()
        );
    }
}
