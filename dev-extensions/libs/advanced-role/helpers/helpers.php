<?php

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

use Dev\AdvancedRole\Repositories\Interfaces\TeamInterface;
use Dev\AdvancedRole\Services\TeamService;
use Dev\Member\Repositories\Interfaces\MemberInterface;

if (!function_exists('advancedRole_sample_function')) {
    function advancedRole_sample_function($args = [])
    {
    }
}

if (!function_exists('advancedRole_get_deep_teams')) {
    /**
     * @return \Illuminate\Support\Collection
     * @throws Exception
     */
    function advancedRole_get_deep_teams($args = [])
    {
        $indent = Arr::get($args, 'indent', '——');
        $userId = Arr::get($args, 'user_id', null);

        $repo = app(TeamInterface::class);

        if (blank($userId)) {
            return collect();
        }

        $user = app(MemberInterface::class)->getFirstBy([
            'id' => $userId
        ]);
        
        $rootTeam = app(TeamService::class)->getRootTeam($user);
        $resources = $repo->getAllTeams($userId);

        foreach ($resources as $key => $resource) {
            $resource->permission = $resource->id == $rootTeam->id ? [
                'can_edit' => false,
                'can_delete' => false
            ] : [
                'can_edit' => true,
                'can_delete' => true
            ];
        }
        $resources = sort_item_with_children_customize($resources);

        foreach ($resources as $category) {
            $indentText = '';
            $depth = (int) $category->depth;
            for ($index = 0; $index < $depth; $index++) {
                $indentText .= $indent;
            }
            $category->indent_text = $indentText;
        }

        return $resources;
    }
}


if (! function_exists('sort_item_with_children_customize')) {
    function sort_item_with_children_customize(
        Collection|array $list,
        array &$result = [],
        int|string $parent = null,
        int $depth = 0
    ): array {
        if ($list instanceof Collection) {
            $listArr = [];
            foreach ($list as $item) {
                $listArr[] = $item;
            }

            $list = $listArr;
        }

        foreach ($list as $key => $object) {
            if ($object->parent_id == $object->id) {
                $result[] = $object;

                continue;
            }

            if ($object->parent_id == $parent) {
                $result[] = $object;
                $object->depth = $depth;
                unset($list[$key]);
                sort_item_with_children_customize($list, $result, $object->id, $depth + 1);
            }
        }

        return $result;
    }
}
