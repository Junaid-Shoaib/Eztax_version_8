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
    $fileUrl = asset('storage/' . auth()->user()->id . '/' . ($current ? $current . '/' : '') . $file->getFilename());
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
