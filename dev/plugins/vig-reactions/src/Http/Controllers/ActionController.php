<?php

namespace Dev\VigReactions\Http\Controllers;

use Dev\VigReactions\Repositories\Interfaces\VigReactionsInterface;
use Dev\VigReactions\Repositories\Interfaces\VigReactionMetaInterface;
use Dev\Base\Http\Controllers\BaseController;
use Dev\Base\Http\Responses\BaseHttpResponse;
use Dev\VigReactions\Http\Requests\VigReactionsRequest;
use Dev\VigReactions\Traits\Reacts;
use Dev\VigReactions\Http\Resources\ReactionResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Dev\VigReactions\Http\Events\CreateOrUpdateReactionEvent;

class ActionController extends BaseController
{
    use Reacts;

    /**
     * @var VigReactionsInterface
     */
    protected $vigReactionsRepository;

    /**
     * @var VigReactionMetaInterface
     */
    protected $metaBoxRepository;

    /**
     * @param VigReactionsInterface $vigReactionsRepository
     */
    public function __construct(VigReactionsInterface $vigReactionsRepository, VigReactionMetaInterface $metaBoxRepository)
    {
        $this->vigReactionsRepository = $vigReactionsRepository;
        $this->metaBoxRepository = $metaBoxRepository;
    }

    /**
     * @param VigReactionsRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse|JsonResponse|RedirectResponse|JsonResource
     */
    public function getReaction(VigReactionsRequest $request, BaseHttpResponse $response)
    {
        $reactionType = $request->input('reaction_type');

        if (!class_exists($reactionType)) {
            return $response;
        }

        $data = $reactionType::findOrFail($request->input('reaction_id'));

        $meta = $this->metaBoxRepository->getMetadata($data);

        if($meta) {
            return $response->setData($meta)->toApiResponse();
        }

        $react = $data->reactions ? $data->reactions->first() : null;

        if (!$react) {
            return $response->setError()->setMessage(__('Reaction not found'));
        }

        return $response->setData(new ReactionResource($react))->toApiResponse();
    }

    /**
     * @param VigReactionsRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse|JsonResponse|RedirectResponse|JsonResource
     */
    public function pressReaction(VigReactionsRequest $request, BaseHttpResponse $response)
    {
        $reactionType = $request->input('reaction_type');

        if (!class_exists($reactionType)) {
            return $response;
        }

        $data = $reactionType::findOrFail($request->input('reaction_id'));

        $react = $this->reactTo($data, $request->input('type'));

        event(new CreateOrUpdateReactionEvent($react));

        return $response->setData(new ReactionResource($react))->toApiResponse();
    }
}
