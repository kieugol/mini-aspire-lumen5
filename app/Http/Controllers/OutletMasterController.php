<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\OutletMasterService;
use App\Http\Requests\OutletMaster\OutletMasterCreateRequest;
use App\Http\Requests\OutletMaster\OutletMasterUpdateRequest;
use App\Libraries\ApiResponse;

class OutletMasterController extends BaseController
{
    use ApiResponse;

    protected $outletMasterService;

    public function __construct(Request $request, OutletMasterService $outletMasterInstance)
    {
        parent::__construct($request);
        $this->outletMasterService = $outletMasterInstance;
    }

    public function getAll()
    {
        $data = $this->outletMasterService->getAll();

        return $this->sendResponse($data[RESPONSE_KEY], $data[STT_CODE_KEY]);
    }

    public function getList()
    {
        $data = $this->outletMasterService->getList($this->request);

        return $this->sendResponse($data[RESPONSE_KEY], $data[STT_CODE_KEY]);
    }

    public function getDetail($id)
    {
        $data = $this->outletMasterService->getDetail($id);

        return $this->sendResponse($data[RESPONSE_KEY], $data[STT_CODE_KEY]);
    }

    public function create()
    {
        $this->validate($this->request, OutletMasterCreateRequest::rules(), OutletMasterCreateRequest::messages());

        $data = $this->outletMasterService->create($this->request);

        return $this->sendResponse($data[RESPONSE_KEY], $data[STT_CODE_KEY]);
    }

    public function update($id)
    {
        $this->request->merge(['id' => $id]);
        $this->validate($this->request, OutletMasterUpdateRequest::rules(), OutletMasterUpdateRequest::messages());
        $data = $this->outletMasterService->update($this->request, $id);

        return $this->sendResponse($data[RESPONSE_KEY], $data[STT_CODE_KEY]);
    }

    public function delete($id)
    {
        $data = $this->outletMasterService->delete($id);

        return $this->sendResponse($data[RESPONSE_KEY], $data[STT_CODE_KEY]);
    }
}
