{{-- Simple table to display hafalan history --}}
{{-- You might want to style this further using Tailwind CSS classes --}}
<div class="p-4">
    @if ($riwayats->isEmpty())
        <p class="text-gray-500">Belum ada riwayat hafalan untuk surah ini.</p>
    @else
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Tanggal</th>
                    <th scope="col" class="px-6 py-3">Nilai</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3">Catatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($riwayats as $riwayat)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4">{{ $riwayat->tanggal->format('d M Y') }}</td>
                        <td class="px-6 py-4">{{ $riwayat->nilai ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <span @class([
                                'px-2 py-1 rounded text-xs',
                                'bg-gray-200 text-gray-800' => $riwayat->status_hafalan == 'belum_hafal',
                                'bg-yellow-200 text-yellow-800' => $riwayat->status_hafalan == 'sedang_hafal',
                                'bg-green-200 text-green-800' => $riwayat->status_hafalan == 'selesai',
                            ])>
                                {{ str_replace('_', ' ', Str::ucfirst($riwayat->status_hafalan)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">{{ $riwayat->catatan ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
