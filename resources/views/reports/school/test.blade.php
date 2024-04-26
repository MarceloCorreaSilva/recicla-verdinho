<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatorio</title>

    <style>
        /* Estilos comuns */
        body {
            font-family: 'Arial', sans-serif;
            color: #333;
        }

        /* Estilo da tabela */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        /* Estilo do cabeçalho da tabela */
        .table th {
            background-color: #f2f2f2;
            padding: 3px;
            border: 1px solid #ddd;
        }

        /* Estilo das células da tabela */
        .table td {
            padding: 2px;
            border: 1px solid #ddd;
        }

        /* Estilo das células da tabela alternadas */
        .table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>

@php
$mes = array('', 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
@endphp

<body class="bg-gray-100 p-6">

    <!-- Cabeçalho -->
    <div class="header">
        <h1 class="text-2xl font-bold mb-4 text-center">{{ $record->name }}</h1>
        <p class="py-2 text-right">Data: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
    </div>

    @foreach ($report['report'] as $keyYear => $year)
    @php
    $reportAnual = $report['reportAnual'];
    $total_pet_bottles_anual = $reportAnual[$keyYear]['pet_bottles'];
    $total_packaging_of_cleaning_materials_anual = $reportAnual[$keyYear]['packaging_of_cleaning_materials'];
    $total_tetra_pak_anual = $reportAnual[$keyYear]['tetra_pak'];
    $total_aluminum_cans_anual = $reportAnual[$keyYear]['aluminum_cans'];
    $total_materials_anual = $total_pet_bottles_anual + $total_packaging_of_cleaning_materials_anual + $total_tetra_pak_anual + $total_aluminum_cans_anual;
    $total_green_coin_anual = $reportAnual[$keyYear]['green_coin'];
    @endphp

    @foreach ($year as $keyMonth => $month)
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" id="{{ $keyYear }}">
            @php
            $total_pet_bottles_month = 0;
            $total_packaging_of_cleaning_materials_month = 0;
            $total_tetra_pak_month = 0;
            $total_aluminum_cans_month = 0;
            $total_materials_month = 0;
            $total_green_coin_month = 0;
            @endphp
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="text-center text-sm">{{ $keyYear }}</th>
                    <th scope="col" class="text-center text-sm" colspan="6">{{ $mes[ intval($keyMonth)] }}</th>
                </tr>
                <tr>
                    <th scope="col" class="text-center text-xs" style="width: 20%;">Data</th>
                    <th scope="col" class="text-center text-xs" style="width: 13.33%;">Garrafa PET</th>
                    <th scope="col" class="text-center text-xs" style="width: 13.33%;">Mat. Limpeza</th>
                    <th scope="col" class="text-center text-xs" style="width: 13.33%;">Tetra Pak</th>
                    <th scope="col" class="text-center text-xs" style="width: 13.33%;">Alumínio</th>
                    <th scope="col" class="text-center text-xs" style="width: 13.33%;">Total Unidades</th>
                    <th scope="col" class="text-center text-xs" style="width: 13.33%;">Total Verdinhos</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($month as $keyDay => $day)
                @php
                $total_materials_day = $day['pet_bottles'] + $day['packaging_of_cleaning_materials'] + $day['tetra_pak'] + $day['aluminum_cans'];
                $total_pet_bottles_month = $total_pet_bottles_month + $day['pet_bottles'];
                $total_packaging_of_cleaning_materials_month = $total_packaging_of_cleaning_materials_month + $day['packaging_of_cleaning_materials'];
                $total_tetra_pak_month = $total_tetra_pak_month + $day['tetra_pak'];
                $total_aluminum_cans_month = $total_aluminum_cans_month + $day['aluminum_cans'];
                $total_materials_month = $total_materials_month + $total_materials_day;
                $total_green_coin_month = $total_green_coin_month + $day['green_coin'];
                @endphp
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="text-center text-xs font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $day['data'] }}
                    </th>
                    <td class="px-1 py-1 text-center text-xs">{{ number_format($day['pet_bottles'], 0, '', '.') }}</td>
                    <td class="px-1 py-1 text-center text-xs">{{ number_format($day['packaging_of_cleaning_materials'], 0, '', '.') }}</td>
                    <td class="px-1 py-1 text-center text-xs">{{ number_format($day['tetra_pak'], 0, '', '.') }}</td>
                    <td class="px-1 py-1 text-center text-xs">{{ number_format($day['aluminum_cans'], 0, '', '.') }}</td>
                    <td class="px-1 py-1 text-center text-xs">{{ number_format($total_materials_day, 0, '', '.') }}</td>
                    <td class="px-1 py-1 text-center text-xs">{{ number_format($day['green_coin'], 0, '', '.') }}</td>
                </tr>
                @endforeach
            </tbody>

            <tfoot>
                <tr class="font-semibold text-gray-900 dark:text-white">
                    <th scope="row" class="text-center text-xs">
                        Total do Mês
                    </th>
                    <td class="px-1 py-1 text-center text-xs font-bold text-bold">{{ number_format($total_pet_bottles_month, 0, '', '.') }}</td>
                    <td class="px-1 py-1 text-center text-xs font-bold text-bold">{{ number_format($total_packaging_of_cleaning_materials_month, 0, '', '.') }}</td>
                    <td class="px-1 py-1 text-center text-xs font-bold text-bold">{{ number_format($total_tetra_pak_month, 0, '', '.') }}</td>
                    <td class="px-1 py-1 text-center text-xs font-bold text-bold">{{ number_format($total_aluminum_cans_month, 0, '', '.') }}</td>
                    <td class="px-1 py-1 text-center text-xs font-bold text-bold">{{ number_format($total_materials_month, 0, '', '.') }}</td>
                    <td class="px-1 py-1 text-center text-xs font-bold text-bold">{{ number_format($total_green_coin_month, 0, '', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
    @endforeach

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" id="totalGeral{{ $keyYear }}">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="text-center text-xs" style="width: 20%;"></th>
                    <th scope="col" class="text-center text-xs" style="width: 13.33%;">Garrafa PET</th>
                    <th scope="col" class="text-center text-xs" style="width: 13.33%;">Mat. Limpeza</th>
                    <th scope="col" class="text-center text-xs" style="width: 13.33%;">Tetra Pak</th>
                    <th scope="col" class="text-center text-xs" style="width: 13.33%;">Alumínio</th>
                    <th scope="col" class="text-center text-xs" style="width: 13.33%;">Total Unidades</th>
                    <th scope="col" class="text-center text-xs" style="width: 13.33%;">Total Verdinhos</th>
                </tr>
            </thead>

            <tfoot>
                <tr class="font-semibold text-gray-900 dark:text-white">
                    <th scope="row" class="text-center text-xs">
                        TOTAL GERAL {{ $keyYear }}
                    </th>
                    <td class="px-1 py-1 text-center text-xs font-bold text-bold">{{ number_format($total_pet_bottles_anual, 0, '', '.') }}</td>
                    <td class="px-1 py-1 text-center text-xs font-bold text-bold">{{ number_format($total_packaging_of_cleaning_materials_anual, 0, '', '.') }}</td>
                    <td class="px-1 py-1 text-center text-xs font-bold text-bold">{{ number_format($total_tetra_pak_anual, 0, '', '.') }}</td>
                    <td class="px-1 py-1 text-center text-xs font-bold text-bold">{{ number_format($total_aluminum_cans_anual, 0, '', '.') }}</td>
                    <td class="px-1 py-1 text-center text-xs font-bold text-bold">{{ number_format($total_materials_anual, 0, '', '.') }}</td>
                    <td class="px-1 py-1 text-center text-xs font-bold text-bold">{{ number_format($total_green_coin_anual, 0, '', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
    @endforeach
</body>

</html>