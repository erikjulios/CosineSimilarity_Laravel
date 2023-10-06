@extends('template')
@section('content')

    <a href="{{ url('history') }}" class="px-2">
        <i class="nav-icon fas fa-arrow-left"></i>
        Back
    </a><br><br>
    <h1>Detail Persentase</h1>

    @if (!empty($judul_words))
        <p>Judul:</p>
        <p>
            @foreach ($judul_words as $word)
                @if (in_array($word, $highlightedWords))
                    <span class="highlight">{{ $word }}</span>
                @else
                    {{ $word }}
                @endif
            @endforeach
        </p>
    @endif

    @if (!empty($abstraksi_words))
        <p>Abstraksi:</p>
        <p>
            @foreach ($abstraksi_words as $word)
                @if (in_array($word, $highlightedWords))
                    <span class="highlight">{{ $word }}</span>
                @else
                    {{ $word }}
                @endif
            @endforeach
        </p>
    @endif
@endsection