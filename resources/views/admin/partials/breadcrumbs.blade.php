@if(count($breadcrumbs))
    <ol class="breadcrumb">
        @foreach($breadcrumbs as $breadcrumb => $link)
            @if($link)
                <li class="breadcrumb-item">
                    <a href="{{ $link }}">{{$breadcrumb}}</a>
                </li>
            @else
            <li class="breadcrumb-item">
                <a href="#">{{$breadcrumb}}</a>
            </li>
            @endif
        @endforeach
    </ol>

@endif
