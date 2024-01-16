@extends('layouts.app')
@section('content')
    <section class="container">
        <h1>{{ $project->title }}</h1>
        <p>{!! $project->body !!}</p>
        <img class="w-50" src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}">
        <div>
            <h4>Technologies:</h4>
            @for ($i = 0; $i < count($project->technologies); $i++)
                <div class="d-inline-block m-2 ">
                    <img style="width: 50px" src="{{ $project->technologies[$i] }}" alt="">
                </div>
            @endfor
        </div>

        <div>
            <button class="btn btn-primary d-inline-block"><a class="text-white text-decoration-none"
                    href="{{ route('admin.projects.edit', $project->slug) }}">Edit</button>
            <form class="d-inline-block" action="{{ route('admin.projects.destroy', $project->slug) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger cancel-button" data-item-title="{{ $project->title }}"
                    type="submit">Delete</button>
            </form>
            <button class="btn btn-warning d-inline-block"><a class="text-black text-decoration-none"
                    href="{{ route('admin.projects.index') }}">Back</a>
            </button>
        </div>

    </section>
    @include('partials.modal_delete')
@endsection
