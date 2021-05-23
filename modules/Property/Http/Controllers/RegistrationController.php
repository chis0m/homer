<?php

namespace Modules\Property\Http\Controllers;

use App\Http\Controllers\API\Controller;
use Globals\Classes\Enum;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Modules\Property\Http\Requests\Register;
use Modules\Property\Models\Property;
use Globals\Traits\TResponder;


class RegistrationController extends Controller
{
    use TResponder;

    /**
     * Store a newly created resource in storage.
     *
     * @param Register $request
     *
     * @return JsonResponse
     */
    public function store(Register $request): JsonResponse
    {
        $propTray = $request->only([
            'title',
            'purpose',
            'bedroom',
            'bathroom',
            'kitchen',
            'toilet',
            'size',
            'furnished',
            'serviced',
            'newly_built',
            'price',
            'description'
        ]);
        $propTray['propertable_id'] = auth()->id();
        $propTray['propertable_type'] = getGuardModel();
        $propTray['slug'] = Str::slug($request['title']);
        $propTray['expired_at'] = now()->addDays(2);
        $property = Property::create($propTray);

        $addressTray = $request->only([
            'street_no',
            'street_name',
            'lga',
            'state',
            'landmark'
        ]);
        $addressTray['addressable_id'] = $property->id;
        $addressTray['addressable_type'] = Property::class;
        $address = $property->addresses()->create($addressTray);
        $property['address'] = $address;
        return $this->success($property, __('property.created'), Response::HTTP_CREATED);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function enable($id) :JsonResponse
    {
        $property = Property::find($id);
        $property->update([
            'status' => Enum::ACTIVE,
            'expired_at' =>  now()->addDays(2)
        ]);
        return $this->success($property, __('property.enabled'), Response::HTTP_ACCEPTED);
    }

        /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function disable($id) :JsonResponse
    {
        $property = Property::find($id);
        $property->update([
            'status' => Enum::INACTIVE
        ]);
        return $this->success($property, __('property.disabled'), Response::HTTP_ACCEPTED);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $property = Property::find($id);
        $property->delete();
        return $this->success(null, __('property.deleted'));
    }
}
