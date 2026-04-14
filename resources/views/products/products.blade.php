@extends('layouts.partial.layout-page', ['class' => ''])
<x-seo.meta
    title=""
    description=""
    keywords=""
    :canonical="route('certificates', ['category' => $category])"
/>
@section('content-home')

    <section class="block relative">
        <x-site.catalog.category.category/>
    </section>

    <section class="block relative">
        @livewire('product-catalog', ['category' => $category])
    </section>

@endsection
