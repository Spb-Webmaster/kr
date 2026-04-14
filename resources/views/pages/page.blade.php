@extends('layouts.partial.layout-page', ['class' => ''])
<x-seo.meta
    :title="$item->metatitle ?? $item->title"
    :description="$item->description ?? ''"
    :keywords="$item->keywords ?? ''"
/>
@section('content-home')

    <section class="block relative">
        <x-site.catalog.category.category/>
    </section>

    <section class="block relative">
        <div class="product_single">



            <div class="title">
                <h1 class="product_single__title">{{ $item->title }}</h1>

                @if($item->subtitle)
                    <div class="product_single__subtitle">{{ $item->subtitle }}</div>
                @endif
            </div>


            @if($item->desc)
                <div class="product_single__desc desc">
                    {!! $item->desc !!}
                </div>
            @endif

            @if($item->desc2)
                <div class="product_single__desc desc">
                    {!! $item->desc2 !!}
                </div>

            @endif


        </div>
    </section>

@endsection
