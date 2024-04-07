<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryListResource;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\Category\CategoryRequest;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = ServiceCategory::simplePaginate($request->paginate ?? 15);

        $this->setData(CategoryListResource::collection($categories));

        return $this->response();
    }

    public function store(CategoryRequest $request)
    {

        $category = ServiceCategory::create([
            'type' => $request->type,
            'parent_id' => $request->parent_id,
            'name' => $request->name
        ]);

        $this->setData(new CategoryResource($category))->setStatus(201);

        return $this->response();

    }

    public function show($id)
    {

        $category = ServiceCategory::find($id);

        $this->setData(new CategoryResource($category));

        return $this->response();

    }

    public function update(CategoryRequest $request, $id)
    {
         ServiceCategory::find($id)->update([
           'type' => $request->type,
            'parent_id' => $request->parent_id,
            'name' => $request->name
        ]);

        $category = ServiceCategory::find($id);

        $this->setData(new CategoryResource($category));

        return $this->response();
    }

    public function destroy($id)
    {
        ServiceCategory::destroy($id);

        $this->setData(['message' => 'success']);

        return $this->response();

    }
}
