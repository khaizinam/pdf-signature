<?php

namespace Dev\AdvancedRole\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

use Exception;
use Dev\AdvancedRole\Repositories\Interfaces\TeamInterface;
use Dev\Member\Repositories\Interfaces\MemberInterface;
use Dev\AdvancedRole\Enums\AgentStatusEnum;
use Dev\Base\Enums\BaseStatusEnum;
use Dev\AdvancedRole\Models\Member;

class TeamService
{
    protected MemberInterface $memberRepository;
    protected TeamInterface $teamRepository;

    public function __construct(MemberInterface $memberRepository, TeamInterface $teamRepository)
    {
        $this->memberRepository = $memberRepository;
        $this->teamRepository = $teamRepository;
    }

    public function getRootTeam($user)
    {
        $dataQ = [
            'parent_id' => null,
            'author_id' => $user->id,
            'author_type' => Member::class,
        ];
        $teamRoot = $this->teamRepository->getFirstBy($dataQ);

        if (blank($teamRoot)) {
            $data = [
                'name' => Str::uuid(),
                'display_name' => "{$user->name}'s Team",
                'parent_id' => null,
                'author_id' => $user->id,
                'author_type' => Member::class,
            ];

            $teamRoot = $this->teamRepository->create($data);
        }

        return $teamRoot;
    }

    public function index($user)
    {
        $teams = advancedRole_get_deep_teams([
            'indent' => '/--',
            'user_id' => $user->id
        ]);
        foreach ($teams as $row) {
            $row->display_name = trim($row->indent_text . ' ' . $row->display_name);
        }
        return $teams;
    }

    public function store($request)
    {
        $rootTeam = $this->getRootTeam($request->user());
        if (!blank($request->parent_id)) {
            $rootTeam = $this->teamRepository->findById($request->parent_id);
        }

        $team = $this->teamRepository->create([
            'name' => Str::uuid(),
            'display_name' => $request->name,
            'parent_id' => $rootTeam->id,
            'author_id' => $request->user()->id,
            'author_type' => Member::class,
        ]);

        return $team;
    }

    public function show($id)
    {
        $team = $this->teamRepository->getFirstBy([
            'id' => $id
        ]);

        if (blank($team)) {
            throw new Exception(__('Data not found!'));
        }
        return $team;
    }

    public function update($id, $request)
    {
        $team = $this->show($id);
        $rootTeam = $this->getRootTeam($request->user());

        if (!blank($request->parent_id)) {
            $rootTeam = $this->teamRepository->findById($request->parent_id);
        }

        $team->update([
            'display_name' => $request->name,
            'parent_id' => $rootTeam->id,
        ]);
        return $team;
    }

    public function deletes($ids, $user)
    {
        foreach ($ids as $id) {
            try {
                $this->destroy($id, $user);
            } catch (\Throwable $th) {
                continue;
            }
        }
    }

    public function destroy($id, $user)
    {
        $rootTeam = $this->getRootTeam($user);
        $team = $this->teamRepository->getFirstBy([
            'id' => $id
        ]);

        if (blank($team)) {
            throw new Exception(__('Data not found!'));
        }

        if ($team->children && $rootTeam->id != $id) {
            foreach ($team->children as $key => $child) {
                $child->update([
                    'parent_id' => $rootTeam->id
                ]);
            }
        }
        $team->delete();
    }
}