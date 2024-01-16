@extends('layouts.app')
@section('content')
    <section class="container">
        <h1>Category Create</h1>
        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name"
                    required maxlength="200" minlength="3">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="body">Body</label>
                <textarea type="text" class="form-control @error('body') is-invalid @enderror" name="body" id="body">{{ old('body') }}</textarea>
                @error('body')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="category">Category</label>
                <select class="form-control @error('category_id') is-invalid @enderror" name="category_id" id="category_id">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"{{ old('category_id') == $category->id ? ' selected' : '' }}>
                            {{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <img id="uploadPreview" src="https://via.placeholder.com/300x200" alt="Placeholder">
            </div>
            <div class="mb-3">
                <label for="image">Image</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror" name="image"
                    id="image">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            @foreach ($technologies as $item)
                <div class="d-inline-block mx-2">
                    <input name="technologies[]" id="{{ $item['name'] }}" value="{{ $item['image'] }}" type="checkbox">
                    <img style="width: 50px" src="{{ $item['image'] }}" alt="{{ $item['name'] }}">
                </div>
            @endforeach
            <div class="my-2">
                <button type="submit" class="btn btn-success">Submit</button>
                <button type="reset" class="btn btn-primary">Reset</button>
            </div>

        </form>
    </section>
@endsection
