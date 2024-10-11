<?php

namespace Dev\Kernel\Http\Controllers\API\v1;

use Dev\Base\Http\Responses\BaseHttpResponse;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use chillerlan\QRCode\{QRCode, QROptions};
use chillerlan\QRCode\Common\EccLevel;
use chillerlan\QRCode\Data\QRMatrix;
use chillerlan\QRCode\Output\{QROutputInterface, QRGdImage};

class KernelController extends Controller
{
    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse|JsonResponse
     */
    public function test(Request $request, BaseHttpResponse $response)
    {
        dd($request);

        return $response
            ->setData([])
            ->toApiResponse();
    }
}
