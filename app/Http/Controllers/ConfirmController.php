<?php

namespace App\Http\Controllers;

use App\Code;
use App\ConfirmType;
use App\Services\AbstractTypeService;
use App\Services\ConfirmService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ConfirmController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function sendCode(Request $request)
    {
        $this->validate($request, [
            'email' => [
                'email',
                sprintf('required_without_all:%s', implode(',', ConfirmType::listTypesWithout([ConfirmType::listTypesAll()[ConfirmType::EMAIL]]))),
                ],
            'phone' => [
                'string',
                sprintf('required_without_all:%s', implode(',', ConfirmType::listTypesWithout([ConfirmType::listTypesAll()[ConfirmType::PHONE]]))),
            ],
        ]);

        $queryData = $request->all();

        try {
            /** @var ConfirmService $service */
            $service = app()->get(ConfirmService::class);

            /** @var AbstractTypeService $typeService */
            $typeService = $service->getVerifyingService($queryData);
            $typeService->send();
            $typeService->updateSendStats();
        } catch (\Exception $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()]);
        }

        return response()->json(['status' => 'success', 'version' => app()->version()]);
    }

    public function checkCode(Request $request)
    {
        $this->validate($request, [
            'email' => [
                'email',
                sprintf('required_without_all:%s', implode(',', ConfirmType::listTypesWithout([ConfirmType::listTypesAll()[ConfirmType::EMAIL]]))),
            ],
            'phone' => [
                'string',
                sprintf('required_without_all:%s', implode(',', ConfirmType::listTypesWithout([ConfirmType::listTypesAll()[ConfirmType::PHONE]]))),
            ],
            'code' => ['string', Rule::exists(Code::class, 'code')]
        ]);

        $queryData = $request->all();

        /** @var ConfirmService $service */
        $service = app()->get(ConfirmService::class);
        $service->confirm($queryData);

    }
}
