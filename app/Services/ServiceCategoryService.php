<?php

namespace App\Services;

use App\Http\Resources\ServiceCategoryResource;
use App\Http\Resources\ThreeViewServiceCategoryResource;
use App\Models\ServiceCategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ServiceCategoryService
{
    public function getTopLevel() : ResourceCollection
    {
        return ServiceCategoryResource::collection($this->topLevel());
    }

    public function topLevel() : Collection
    {
        return ServiceCategory::whereNull('parent_id')->get();
    }

    public function getChilds($category_id) : ResourceCollection
    {
        return ServiceCategoryResource::collection($this->childs($category_id));
    }

    public function childs($category_id) : Collection
    {
        return ServiceCategory::whereParentId($category_id)->get();
    }

    public function getTreeViewFromTop() : ResourceCollection
    {
        return ThreeViewServiceCategoryResource::collection($this->topLevel());
    }

    public function getThreeFromNode($category_id) : JsonResource
    {
        return  new ThreeViewServiceCategoryResource(ServiceCategory::find($category_id));
    }
}
