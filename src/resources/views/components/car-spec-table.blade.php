@props(['title', 'items', 'genre', 'year'])

<div class="mb-10">
    <h2 class="text-xl font-semibold mb-4">{{ $title }}</h2>
    <table class="w-full text-left border-t border-gray-200">
        <tbody class="text-gray-700 text-sm">
            @foreach ($items as [$name, $comment, $spec])

            {{-- minivan 限定表示 --}}
            @if (Str::startsWith($spec, 'minivan_') || in_array($spec, ['minivan_size', 'minivan_3rd', 'minivan_style', 'minivan_slidedoor',]))
            @if ($genre !== 'minivan')
            @continue
            @endif
            @endif

            {{-- suv 限定表示 --}}
            @if (Str::startsWith($spec, 'suv_') || in_array($spec, ['suv_size', 'suv_style']))
            @if ($genre !== 'suv')
            @continue
            @endif
            @endif

            <tr class="border-t border-gray-100 hover:bg-gray-50 transition">
                <td class="py-2 px-3">
                    <a href="{{ route('car.spec', ['genre' => $genre, 'spec' => $spec, 'year' => $year]) }}"
                        class="text-blue-600 hover:underline">
                        {!! $name !!}
                    </a>
                </td>
                <td class="py-2 px-3">{{ $comment }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>