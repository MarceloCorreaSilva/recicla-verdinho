<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatorio</title>
    <!-- Inclua o link para o arquivo CSS do Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

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

        /* Estilos para impressão */
        @media print {
            body {
                background-color: white;
            }

            .section {
                margin-bottom: 0;
            }

            .table {
                background-color: white;
            }

            .table th,
            .table td {
                border: 1px solid #ddd;
            }
        }
    </style>
</head>
@php
$mes = array('', 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
@endphp

<body class="bg-gray-100 p-6">

    <!-- Cabeçalho -->
    <div class="header">
        <h1 class="text-2xl font-bold mb-4 text-center">{{ $school->name }}</h1>
        <p class="py-2 text-right">Data: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
    </div>

    @foreach ($report as $keyYear => $year)
    <section class="mb-6">
        @php
        $total_pet_bottles_anual = $reportAnual[$keyYear]['pet_bottles'];
        $total_packaging_of_cleaning_materials_anual = $reportAnual[$keyYear]['packaging_of_cleaning_materials'];
        $total_tetra_pak_anual = $reportAnual[$keyYear]['tetra_pak'];
        $total_aluminum_cans_anual = $reportAnual[$keyYear]['aluminum_cans'];
        $total_materials_anual = $total_pet_bottles_anual + $total_packaging_of_cleaning_materials_anual + $total_tetra_pak_anual + $total_aluminum_cans_anual;
        $total_green_coin_anual = $reportAnual[$keyYear]['green_coin'];
        @endphp

        @foreach ($year as $keyMonth => $month)
        <table class="table" id="{{ $keyYear }}">
            @php
            $total_pet_bottles_month = 0;
            $total_packaging_of_cleaning_materials_month = 0;
            $total_tetra_pak_month = 0;
            $total_aluminum_cans_month = 0;
            $total_materials_month = 0;
            $total_green_coin_month = 0;
            @endphp
            <thead>
                <tr>
                    <th class="text-center text-sm">{{ $keyYear }}</th>
                    <th class="text-center text-sm" colspan="6">{{ $mes[ intval($keyMonth)] }}</th>
                </tr>
                <tr>
                    <th class="text-center text-xs" style="width: 20%;">Data</th>
                    <th class="text-center text-xs" style="width: 13.33%;">Garrafa PET</th>
                    <th class="text-center text-xs" style="width: 13.33%;">Mat. Limpeza</th>
                    <th class="text-center text-xs" style="width: 13.33%;">Tetra Pak</th>
                    <th class="text-center text-xs" style="width: 13.33%;">Alumínio</th>
                    <th class="text-center text-xs" style="width: 13.33%;">Total Unidades</th>
                    <th class="text-center text-xs" style="width: 13.33%;">Total Verdinhos</th>
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
                <tr>
                    <td class="text-center text-xs">{{ $day['data'] }}</td>
                    <td class="text-center text-xs">{{ number_format($day['pet_bottles'], 0, '', '.') }}</td>
                    <td class="text-center text-xs">{{ number_format($day['packaging_of_cleaning_materials'], 0, '', '.') }}</td>
                    <td class="text-center text-xs">{{ number_format($day['tetra_pak'], 0, '', '.') }}</td>
                    <td class="text-center text-xs">{{ number_format($day['aluminum_cans'], 0, '', '.') }}</td>
                    <td class="text-center text-xs">{{ number_format($total_materials_day, 0, '', '.') }}</td>
                    <td class="text-center text-xs">{{ number_format($day['green_coin'], 0, '', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <td class="text-center text-xs font-bold text-bold">Total do Mês</td>
                <td class="text-center text-xs font-bold text-bold">{{ number_format($total_pet_bottles_month, 0, '', '.') }}</td>
                <td class="text-center text-xs font-bold text-bold">{{ number_format($total_packaging_of_cleaning_materials_month, 0, '', '.') }}</td>
                <td class="text-center text-xs font-bold text-bold">{{ number_format($total_tetra_pak_month, 0, '', '.') }}</td>
                <td class="text-center text-xs font-bold text-bold">{{ number_format($total_aluminum_cans_month, 0, '', '.') }}</td>
                <td class="text-center text-xs font-bold text-bold">{{ number_format($total_materials_month, 0, '', '.') }}</td>
                <td class="text-center text-xs font-bold text-bold">{{ number_format($total_green_coin_month, 0, '', '.') }}</td>
            </tfoot>
        </table>
        @endforeach


        <table class="table" id="totalGeral{{ $keyYear }}">
            <thead>
                <tr>
                    <th class="text-center text-xs" style="width: 20%;"></th>
                    <th class="text-center text-xs" style="width: 13.33%;">Garrafa PET</th>
                    <th class="text-center text-xs" style="width: 13.33%;">Mat. Limpeza</th>
                    <th class="text-center text-xs" style="width: 13.33%;">Tetra Pak</th>
                    <th class="text-center text-xs" style="width: 13.33%;">Alumínio</th>
                    <th class="text-center text-xs" style="width: 13.33%;">Total Unidades</th>
                    <th class="text-center text-xs" style="width: 13.33%;">Total Verdinhos</th>
                </tr>
            </thead>
            <tfoot>
                <td class="text-center text-xs font-bold text-bold">TOTAL GERAL {{ $keyYear }}</td>
                <td class="text-center text-xs font-bold text-bold">{{ number_format($total_pet_bottles_anual, 0, '', '.') }}</td>
                <td class="text-center text-xs font-bold text-bold">{{ number_format($total_packaging_of_cleaning_materials_anual, 0, '', '.') }}</td>
                <td class="text-center text-xs font-bold text-bold">{{ number_format($total_tetra_pak_anual, 0, '', '.') }}</td>
                <td class="text-center text-xs font-bold text-bold">{{ number_format($total_aluminum_cans_anual, 0, '', '.') }}</td>
                <td class="text-center text-xs font-bold text-bold">{{ number_format($total_materials_anual, 0, '', '.') }}</td>
                <td class="text-center text-xs font-bold text-bold">{{ number_format($total_green_coin_anual, 0, '', '.') }}</td>
            </tfoot>
        </table>
    </section>
    @endforeach
</body>

</html>