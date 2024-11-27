<?php

namespace App\Services\Products;

use App\Models\Store;
use App\Models\Category;
use App\Dto\Products\CategoryDto;
use App\Services\Concerns\HasInstance;

final class CategoryService
{
    use HasInstance;

    public function firstOrCreate(CategoryDto $categoryDto): Category
    {
        return Category::query()
            ->firstOrCreate(
                attributes: [
                    'remote_id' => $categoryDto->remoteId,
                    'store_id' => $categoryDto->storeId,
                ],
                values: [
                    'name' => $categoryDto->name,
                    'image' => $categoryDto->image,
                    'status' => $categoryDto->status,
                ],
            );
    }

    public function updateOrCreate(CategoryDto $categoryDto): Category
    {
        return Category::query()
            ->updateOrCreate(
                attributes: [
                    'remote_id' => $categoryDto->remoteId,
                    'store_id' => $categoryDto->storeId,
                ],
                values: [
                    'name' => $categoryDto->name,
                    'image' => $categoryDto->image,
                    'status' => $categoryDto->status,
                ],
            );
    }

    public function saveSallaCategory(Store $store, array $data): Category
    {
        $category = $this->updateOrCreate(
            categoryDto: CategoryDto::fromSalla(
                store: $store,
                data: $data,
            ),
        );

        return $category;
    }
}
