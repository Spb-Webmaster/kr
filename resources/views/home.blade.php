@extends('layouts.partial.layout-home')
<x-seo.meta
    title="{!!  (config2('moonshine.home.metatitle')) !!}"
    description="{!!  (config2('moonshine.home.description')) !!}"
    keywords="{!!  (config2('moonshine.home.keywords'))  !!}"
/>
@section('content-home')


    <section class="block relative">
        <x-site.catalog.category.category/>
    </section>

    <section class="block relative">
        <x-site.catalog.category.category-tag/>
    </section>

    <section class="block relative">
        <x-site.catalog.category.category-teaser-img/>
    </section>

    <section>
        <div class="block relative">
            <div class="index_page desc">
                {!!  config2('moonshine.home.desc') !!}
            </div>
        </div>
    </section>

    <section class="block relative">
        <x-site.advantage/>
    </section>


@endsection
