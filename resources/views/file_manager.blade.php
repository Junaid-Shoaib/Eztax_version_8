@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">File Explorer</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <a href="{{ route('file.manager') }}">Home</a>
                            @if ($current)
                                @php
                                    $segments = explode('/', $current);
                                    $breadcrumbPath = '';
                                @endphp

                                @foreach ($segments as $index => $segment)
                                    @php
                                        $breadcrumbPath .= ($index === 0) ? $segment : '/' . $segment;
                                    @endphp

                                    @if ($index !== count($segments) - 1)
                                        / <a href="{{ route('file.manager', $breadcrumbPath) }}">{{ $segment }}</a>
                                    @else
                                        / {{ $segment }}
                                    @endif
                                @endforeach
                            @endif
                        </div>

                        <div class="row file-boxes">
                            @if ($parent)
                            <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                                <div class="border rounded shadow-sm text-center p-3 h-100 d-flex flex-column justify-content-center align-items-center bg-light hover-shadow">
                                    <a href="{{ route('file.manager', $parent) }}" class="text-decoration-none text-dark w-100">
                                        <div class="mb-2" style="font-size: 40px;">🔙</div>
                                    </a>
                                </div>
                            </div>
                            @endif

                            @foreach($folders as $folder)
                            @php
                                $folderName = basename($folder);
                                $folderPath = $current ? $current . '/' . $folderName : $folderName;
                            @endphp
                            <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                                <div class="border rounded shadow-sm text-center p-3 h-100 d-flex flex-column justify-content-center align-items-center bg-light hover-shadow">
                                    <a href="{{ route('file.manager', $folderPath) }}" class="text-decoration-none text-dark w-100">
                                        <div class="mb-2" style="font-size: 40px;">📁</div>
                                        <div class="small text-break">{{ $folderName }}</div>
                                    </a>
                                </div>
                            </div>
                            @endforeach

                            @foreach($files as $file)
                            @php
                                $ext = strtolower($file->getExtension());
                                $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
                                $isImage = in_array($ext, $imageExtensions);
                                $fileUrl = asset('storage/'. auth()->user()->id . '/'   . ($current ? $current . '/' : '') . $file->getFilename());
                            @endphp
                            <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                                <div class="border rounded shadow-sm text-center p-3 h-100 d-flex flex-column justify-content-center align-items-center bg-light hover-shadow">
                                    <a href="{{ route('file.download', ($current ? $current . '/' : '') . $file->getFilename()) }}" class="text-decoration-none text-dark w-100">
                                        @if($isImage)
                                            <img src="{{ $fileUrl }}" class="img-fluid mb-2 rounded" style="max-height: 80px;">
                                        @else
                                            <div class="mb-2" style="font-size: 40px;">📄</div>
                                        @endif
                                        <div class="small text-break">{{ $file->getFilename() }}</div>
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div id="loader" class="text-center my-3" style="display: none;">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-shadow:hover {
    background-color: rgba(108,117,125,0.15);
}
</style>

@push('js')
<script>
let page = 1;
let loading = false;

window.onscroll = function () {
    if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 200 && !loading) {
        loading = true;
        page++;
        document.getElementById('loader').style.display = 'block';
        loadMoreData(page);
    }
};

function loadMoreData(page) {
    let current = "{{ $current }}";
    let url = current ? `/file-manager/${current}?page=${page}` : `/file-manager?page=${page}`;

    fetch(url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('loader').style.display = 'none';

        if (data.trim().length === 0) {
            return;
        }

        document.querySelector('.file-boxes').insertAdjacentHTML('beforeend', data);
        loading = false;
    })
    .catch(error => {
        console.error(error);
        document.getElementById('loader').style.display = 'none';
        loading = false;
    });
}
</script>
@endpush

@endsection
