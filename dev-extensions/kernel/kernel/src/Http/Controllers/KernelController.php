<?php

namespace Dev\Kernel\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class KernelController extends BaseController
{
    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="L5 OpenApi",
     *      description="L5 Swagger OpenApi description",
     *      @OA\Contact(
     *          email="dev@visualweber.net"
     *      ),
     *     @OA\License(
     *         name="Apache 2.0",
     *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *     )
     * )
     *  @OA\Server(
     *      url=L5_SWAGGER_CONST_HOST,
     *      description="L5 Swagger OpenApi Local Server"
     * )
     */

    public function test()
    {
    }
}
