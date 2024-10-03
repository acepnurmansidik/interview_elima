<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
</head>
<body>
  <div class="w-full p-5 flex gap-3 flex-col">
    <form class="flex gap-3" method="GET">
        <select name="month" id="month" class=" px-4 py-2 rounded-xl border-2 border-blue-600">
            <option value="all">All</option>
            <option value="3">Maret</option>
            <option value="4">April</option>
        </select>
        <select name="year" id="year" class=" px-4 py-2 rounded-xl border-2 border-blue-600">
            <option value="2024">2024</option>
            <option value="2025">2025</option>
        </select>
        <button class="px-5 py-2 bg-blue-600 rounded-xl text-white">Search</button>
    </form>
    <table class="table-auto w-full relative">
        <thead>
            <tr class="sticky bg-white shadow-md top-0 h-14">
                <th class="border-2 px-3 py-1 border-slate-400 min-w-[300px]">Name</th>
                @foreach ($header as $headerItem)
                    <th class="border-2 px-3 py-1 border-slate-400 min-w-[130px]">{{ $headerItem['tgl_kerja'] }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($dataEmps as $emp)
                <tr class="hover:bg-blue-50 border-b-2">
                    <td class="border-0 border-y-0 border-x-2 px-3 hover:bg-blue-50 border-b-2 py-1 flex flex-col gap-1 bg-white left-12 min-w-[300px]">
                        <h1 class="text-md font-semibold">{{ $emp['nama'] }}</h1>
                        <h1 class="text-sm text-purple-400 line-clamp">{{ $emp['njab'] }}</h1>
                        <h1 class="text-sm text-gray-400">NIP: {{ $emp['nip'] }}</h1>
                    </td>
                    @foreach ($emp['absensi_kehadiran'] as $absensi)
                        @if ($absensi['status'] == 0)
                            <td class=" min-w-[130px] border-y-0 px-3 py-1 text-sm text-center bg-blue-100">
                                <h1>{{ $absensi['masuk'] }}</h1>
                                <h1>{{ $absensi['pulang'] }}</h1>
                            </td>
                        @elseif ($absensi['status'] == 1)
                            <td class=" min-w-[130px] border-y-0 px-3 py-1 text-sm text-center bg-orange-500">
                                <h1>{{ $absensi['masuk'] }}</h1>
                                <h1>{{ $absensi['pulang'] }}</h1>
                            </td>
                        @elseif ($absensi['status'] == 2)
                            <td class=" min-w-[130px] border-y-0 px-3 py-1 text-sm text-center">
                                <h1 class="text-red-500">{{ $absensi['masuk'] }}</h1>
                                <h1>{{ $absensi['pulang'] ?? '-' }}</h1>
                            </td>
                        @elseif ($absensi['status'] == 3)
                            <td class=" min-w-[130px] border-y-0 px-3 py-1 text-sm text-center bg-green-100">
                                <h1 class="">{{ $absensi['masuk'] }}</h1>
                                <h1>{{ $absensi['pulang'] }}</h1>
                            </td>
                        @elseif ($absensi['status'] == 4)
                            <td class=" min-w-[130px] border-y-0 px-3 py-1 text-sm text-center bg-red-500">
                                <h1>{{ $absensi['masuk'] }}</h1>
                                <h1>{{ $absensi['pulang'] }}</h1>
                            </td>
                        @elseif ($absensi['status'] == 5)
                            <td class=" min-w-[130px] border-y-0 px-3 py-1 text-sm text-center">
                                <h1>{{ $absensi['masuk'] }}</h1>
                                <h1>{{ $absensi['pulang'] ?? '-' }}</h1>
                            </td>
                            
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
  </div>
</body>
</html>