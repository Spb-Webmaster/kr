<div class="catalog_category_category-teaser-img">
<div class="t_block">
    <h2 class="h2 title">Выбрать сертификат</h2>
    <div class="subtitle">Выберете сертификат в интересующим вас разделе</div>
</div>
<div class="flex teasers">
    @foreach($categories as $category)
        @php $imgSrc = intervention('350x190', $category->img, 'image/category', 'cover'); @endphp
        <a href="{{ route('certificates', ['category' => $category->slug]) }}" class="teaser">
            <img width="350" height="190" src="{{ $imgSrc ? asset($imgSrc) : Storage::url('image/category/no-img-category.jpg') }}" alt="{{ $category->title }}" />
            <span class="category_name"><span class="absolute">{{ $category->title }}</span></span>
        </a>
    @endforeach
</div>
</div>
