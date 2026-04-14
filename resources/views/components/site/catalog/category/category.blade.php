<div class="catalog_category_category">
    <h2 class="h2">{{ config2('moonshine.home.cat_title') }}</h2>
    <div class="flex">
        <a href="{{ route('certificates', ['category' => 'all']) }}"
           class="link {{ request()->route('category') === 'all' ? 'active' : '' }}">Все</a>
        @foreach($product_categories as $product_category)
            <a href="{{ route('certificates', ['category' => $product_category->slug]) }}"
               class="link {{ request()->route('category') === $product_category->slug ? 'active' : '' }}">
                {{ $product_category->title }}
            </a>
        @endforeach
    </div>
</div>
