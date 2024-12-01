<div class="custom-control custom-checkbox">
    <input type="checkbox" class="custom-control-input" id="category-{{ $category->id }}" name="categories[]" value="{{ $category->id }}" {{ isset($productCategoriesIds) && in_array($category->id ,$productCategoriesIds) ? 'checked' : '' }}>
    <label class="custom-control-label" for="category-{{ $category->id }}">{{ $category->name }}</label>
</div>
{{--{{ implode(',',$productCategoriesIds) }}--}}
@if ($category->children != null)
    <div style="margin-left: 20px;">
        @foreach ($category->children as $childCategory)
            @include('backend.admin.product.categoryTree', ['category' => $childCategory, 'productCategoriesIds' => isset($productCategoriesIds) ? $productCategoriesIds : []])
        @endforeach
    </div>
@endif
