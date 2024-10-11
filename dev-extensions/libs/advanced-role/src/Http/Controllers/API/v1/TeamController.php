<?php

namespace Dev\AdvancedRole\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Dev\Base\Http\Responses\BaseHttpResponse;
use Illuminate\Http\Request;
use Dev\AdvancedRole\Http\Requests\v1\StoreTeamRequest;
use Dev\AdvancedRole\Http\Resources\TeamListResource;
use Dev\AdvancedRole\Repositories\Interfaces\TeamInterface;
use Symfony\Component\HttpFoundation\Response;
use Dev\AdvancedRole\Http\Resources\TeamResource;
use Dev\AdvancedRole\Services\TeamService;

class TeamController extends Controller
{
    public TeamInterface $teamRepository;
    public TeamService $teamService;

    public function __construct(TeamInterface $teamRepository, TeamService $teamService) {
        $this->teamRepository = $teamRepository;
        $this->teamService = $teamService;
    }

    public function index(Request $request, BaseHttpResponse $response) {
        try {
            $teams = $this->teamService->index($request->user());
            return $response
                ->setData(TeamListResource::collection($teams));
        } catch (\Throwable $th) {
            return $response
                ->setError(true)
                ->setMessage($th->getMessage())
                ->setCode(Response::HTTP_BAD_REQUEST);
        }
    }

    public function store(StoreTeamRequest $request, BaseHttpResponse $response) {
        try {
            $team = $this->teamService->store($request);
            return $response
                ->setData(new TeamResource($team))
                ->setMessage('Create successfully');
        } catch (\Throwable $th) {
            return $response
                ->setError(true)
                ->setMessage($th->getMessage())
                ->setCode(Response::HTTP_BAD_REQUEST);
        }
    }

    public function show($id, BaseHttpResponse $response) {
        try {
            $team = $this->teamService->show($id);
            return $response
                ->setData(new TeamResource($team));
        } catch (\Throwable $th) {
            return $response
                ->setError(true)
                ->setMessage($th->getMessage())
                ->setCode(Response::HTTP_BAD_REQUEST);
        }
    }

    public function update($id, Request $request, BaseHttpResponse $response) {
        try {
            $team = $this->teamService->update($id, $request);
            return $response
                ->setData(new TeamResource($team))
                ->setMessage('Update successfully');
        } catch (\Throwable $th) {
            return $response
                ->setError(true)
                ->setMessage($th->getMessage())
                ->setCode(Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy($id, Request $request, BaseHttpResponse $response) {
        try {
            $this->teamService->destroy($id, $request->user());
            return $response
                ->setMessage(__('Destroy successfully!'))
                ->setCode(Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $response
                ->setError(true)
                ->setMessage($th->getMessage())
                ->setCode(Response::HTTP_BAD_REQUEST);
        }
    }

    public function deletes(Request $request, BaseHttpResponse $response) {
        try {
            $ids = $request->input('ids');
            if (empty($ids)) {
                return $response
                    ->setMessage(trans('core/base::notices.no_select'));
            }
            $this->teamService->deletes($ids, $request->user());
            return $response
                ->setMessage(__('Destroy successfully!'));
        } catch (\Throwable $th) {
            return $response
                ->setError(true)
                ->setMessage($th->getMessage())
                ->setCode(Response::HTTP_BAD_REQUEST);
        }
    }
}
