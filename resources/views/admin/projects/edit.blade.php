@extends('layouts.app')
@section('content')
    <section class="container">
        <h1>Edit {{ $project->title }} </h1>
        <form action="{{ route('admin.projects.update', $project->slug) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="title">Title</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title"
                    required value="{{ old('title', $project->title) }}">
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="body">Body</label>
                <textarea type="text" class="form-control @error('body') is-invalid @enderror" name="body" id="body"
                    required>
                    {{ old('body', $project->body) }}
                </textarea>
                @error('body')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="image">Image</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror" name="image"
                    id="image" value="{{ old('image', $project->image) }}">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <h5>Techologies</h5>
            @foreach ($technologies as $item)
                <div class="d-inline-block m-3">
                    <input type="checkbox" name="technologies[]" value="{{ $item['image'] }}"
                        @if (isset($technologies) && str_contains($project->technologies, $item['image'])) checked @endif>
                    <img style="width: 50px" src="{{ $item['image'] }}" alt="{{ $item['name'] }}">
                </div>
            @endforeach
            <div>
                <button type="submit" class="btn btn-success">Submit</button>
                <button type="reset" class="btn btn-primary">Reset</button>
            </div>

        </form>
    </section>
@endsection
