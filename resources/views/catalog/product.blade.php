@extends('layout.site')

@section('content')
    <h1>Товар: {{ $product->name }}</h1>
    <p>Цена: {{ number_format($product->price, 2, '.', '') }}</p>
    <p>
        Категория:
        <a href="{{ route('catalog.category', ['slug' => $product->category_slug]) }}">
            {{ $product->category_name }}
        </a>
    </p>
    <p>
        Бренд:
        <a href="{{ route('catalog.brand', ['slug' => $product->brand_slug]) }}">
            {{ $product->brand_name }}
        </a>
    </p>
    <p>{{ $product->content }}</p>
@endsection
