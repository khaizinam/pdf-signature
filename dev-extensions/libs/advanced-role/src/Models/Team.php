<?php

namespace Dev\AdvancedRole\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

use Dev\Base\Casts\SafeContent;

use Laratrust\Models\Team as LaratrustTeam;

class Team extends LaratrustTeam
{
    protected $table = 'app_teams';

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'status',
        'parent_id',
        'author_id',
        'author_type'
    ];

    protected $casts = [
        'name' => SafeContent::class,
        'display_name' => SafeContent::class,
        'description' => SafeContent::class
    ];

    /**
     * This will give model's Parent 
     * 
     * Get parent node
     * $team = Member::find(8); 
     * $parent = $team->parent; // 4
     * 
     * Get the grandparent
     * $team = Member::find(8); 
     * $parent = $team->parent()->parent; // 2
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id'); // ->withDefault();
    }

    /**
     * This will give model's Parent, Parent's parent, and so on until root.  
     * 
     * Get all the parent nodes (Tree structure)
     * $team = Member::find(8); 
     * $parent = $team->parentRecursive; // 4,2,1 as a tree structure
     * @return BelongsTo
     */
    public function parentRecursive(): BelongsTo
    {
        return $this->parent()->with('parentRecursive');
    }

    /**
     * Get current model's all recursive parents in a collection in flat structure.
     * 
     * Get all the parent nodes (Flat collection)
     * $team = Member::find(8); 
     * $parent = $team->parentRecursiveFlatten; // [4,2,1]
     */
    public function parentRecursiveFlatten()
    {
        $result = collect();
        $item = $this->parentRecursive;
        if ($item instanceof Member) {
            $result->push($item);
            $result = $result->merge($item->parentRecursiveFlatten());
        }
        return $result;
    }

    /**
     * @return HasMany
     * 
     * Get all Children
     * $team = Member::find(2); 
     * $parent = $team->children; // [4,5]
     * 
     * Get all Children
     * $team = Member::find(2); 
     * $parent = $team->childrenRecursive; // 4, 5, 8, 9, 10, 11
     * 
     * Get GrandChildren
     * 
     * $team = Member::find(2); 
     * $parent = $team->children()->children; // [4,5]
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * This will give model's Children, Children's Children and so on until last node. 
     * @return HasMany
     */
    public function childrenRecursive(): HasMany
    {
        return $this->children()->with('childrenRecursive');
    }

    public function deepParent($data = null)
    {
        $result = !blank($data) ? $data : $this;
        if (blank($result->parent->id)) {
            return $result;
        }
        return $result->deepParent($result->parent);
    }
}
