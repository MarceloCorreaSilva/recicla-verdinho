<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabela com Tailwind</title>
    <!-- Inclua o link para o arquivo CSS do Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <style>
        /* Estilos comuns */
        body {
            font-family: 'Arial', sans-serif;
            color: #333;
        }

        /* Estilos para a tela */
        .section {
            margin-bottom: 25px;
        }

        /* Estilo da tabela */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        /* Estilo do cabeçalho da tabela */
        .table th {
            background-color: #f2f2f2;
            padding: 10px;
            border: 1px solid #ddd;
        }

        /* Estilo das células da tabela */
        .table td {
            padding: 10px;
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

<body class="bg-gray-100 p-6">

    <!-- <table class="min-w-full bg-white border border-gray-300">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b text-center">Data</th>
                <th class="py-2 px-4 border-b text-center">Garrafa PET</th>
                <th class="py-2 px-4 border-b text-center">Mat. Limpeza</th>
                <th class="py-2 px-4 border-b text-center">Tetra Pak</th>
                <th class="py-2 px-4 border-b text-center">Alumínio</th>
                <th class="py-2 px-4 border-b text-center">Total Unidades</th>
                <th class="py-2 px-4 border-b text-center">Total Verdinhos</th>
            </tr>
        </thead>
        <tbody>
            @php
            $total_materials_anual = 0;
            $total_pet_bottles_anual = 0;
            $total_packaging_of_cleaning_materials_anual = 0;
            $total_tetra_pak_anual = 0;
            $total_aluminum_cans_anual = 0;
            $total_green_coin = 0;
            @endphp

            @foreach($school_classes as $school)
            @php
            $total_materials = $school->total_pet_bottles + $school->total_packaging_of_cleaning_materials + $school->total_tetra_pak + $school->total_aluminum_cans;
            $total_pet_bottles_anual = $total_pet_bottles_anual + $school->total_pet_bottles;
            $total_packaging_of_cleaning_materials_anual = $total_packaging_of_cleaning_materials_anual + $school->total_packaging_of_cleaning_materials;
            $total_tetra_pak_anual = $total_tetra_pak_anual + $school->total_tetra_pak;
            $total_aluminum_cans_anual = $total_aluminum_cans_anual + $school->total_aluminum_cans;
            $total_materials_anual = $total_materials_anual + $total_materials;
            $total_green_coin = $total_green_coin + $school->total_green_coin;
            @endphp
            <tr>
                <td class="py-2 px-4 border-b text-center">{{ $school->day . '/' . $school->month . '/' . $school->year }}</td>
                <td class="py-2 px-4 border-b text-center">{{ number_format($school->total_pet_bottles, 0, '', '.') }}</td>
                <td class="py-2 px-4 border-b text-center">{{ number_format($school->total_packaging_of_cleaning_materials, 0, '', '.') }}</td>
                <td class="py-2 px-4 border-b text-center">{{ number_format($school->total_tetra_pak, 0, '', '.') }}</td>
                <td class="py-2 px-4 border-b text-center">{{ number_format($school->total_aluminum_cans, 0, '', '.') }}</td>
                <td class="py-2 px-4 border-b text-center">{{ number_format($total_materials, 0, '', '.') }}</td>
                <td class="py-2 px-4 border-b text-center">{{ number_format($school->total_green_coin, 0, '', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <td class="py-2 px-4 border-t font-bold text-center text-bold">Total do Mês</td>
            <td class="py-2 px-4 border-t font-bold text-center">{{ number_format($total_pet_bottles_anual, 0, '', '.') }}</td>
            <td class="py-2 px-4 border-t font-bold text-center">{{ number_format($total_packaging_of_cleaning_materials_anual, 0, '', '.') }}</td>
            <td class="py-2 px-4 border-t font-bold text-center">{{ number_format($total_tetra_pak_anual, 0, '', '.') }}</td>
            <td class="py-2 px-4 border-t font-bold text-center">{{ number_format($total_aluminum_cans_anual, 0, '', '.') }}</td>
            <td class="py-2 px-4 border-t font-bold text-center">{{ number_format($total_materials_anual, 0, '', '.') }}</td>
            <td class="py-2 px-4 border-t font-bold text-center">{{ number_format($total_green_coin, 0, '', '.') }}</td>
        </tfoot>
    </table> -->

    @php
    $mes = array('', 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
    @endphp
    @foreach ($report as $keyYear => $year)
    <section class="mb-20">
        @php
        $total_pet_bottles_anual = 0;
        $total_packaging_of_cleaning_materials_anual = 0;
        $total_tetra_pak_anual = 0;
        $total_aluminum_cans_anual = 0;
        $total_materials_anual = 0;
        $total_green_coin_anual = 0;
        @endphp

        @foreach ($year as $keyMonth => $month)
        <table id="{{ $keyYear }}">
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
                    <th>{{ $keyYear }}</th>
                    <th colspan="6">{{ $mes[ intval($keyMonth)] }}</th>
                </tr>
                <tr>
                    <th>Data</th>
                    <th>Garrafa PET</th>
                    <th>Mat. Limpeza</th>
                    <th>Tetra Pak</th>
                    <th>Alumínio</th>
                    <th>Total Unidades</th>
                    <th>Total Verdinhos</th>
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

                $total_pet_bottles_anual = $total_pet_bottles_anual + $total_pet_bottles_month;
                $total_packaging_of_cleaning_materials_anual = $total_packaging_of_cleaning_materials_anual + $total_packaging_of_cleaning_materials_month;
                $total_tetra_pak_anual = $total_tetra_pak_anual + $total_tetra_pak_month;
                $total_aluminum_cans_anual = $total_aluminum_cans_anual + $total_aluminum_cans_month;
                $total_materials_anual = $total_aluminum_cans_anual + $total_aluminum_cans_month;
                $total_green_coin_anual = $total_green_coin_anual + $total_green_coin_month;
                @endphp
                <tr>
                    <td>{{ $day['data'] }}</td>
                    <td>{{ number_format($day['pet_bottles'], 0, '', '.') }}</td>
                    <td>{{ number_format($day['packaging_of_cleaning_materials'], 0, '', '.') }}</td>
                    <td>{{ number_format($day['tetra_pak'], 0, '', '.') }}</td>
                    <td>{{ number_format($day['aluminum_cans'], 0, '', '.') }}</td>
                    <td>{{ number_format($total_materials_day, 0, '', '.') }}</td>
                    <td>{{ number_format($day['green_coin'], 0, '', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <td>Total do Mês</td>
                <td>{{ number_format($total_pet_bottles_month, 0, '', '.') }}</td>
                <td>{{ number_format($total_packaging_of_cleaning_materials_month, 0, '', '.') }}</td>
                <td>{{ number_format($total_tetra_pak_month, 0, '', '.') }}</td>
                <td>{{ number_format($total_aluminum_cans_month, 0, '', '.') }}</td>
                <td>{{ number_format($total_materials_month, 0, '', '.') }}</td>
                <td>{{ number_format($total_green_coin_month, 0, '', '.') }}</td>
            </tfoot>
        </table>
        @endforeach


        <table id="totalGeral{{ $keyYear }}">
            <thead>
                <tr>
                    <th></th>
                    <th>Garrafa PET</th>
                    <th>Mat. Limpeza</th>
                    <th>Tetra Pak</th>
                    <th>Alumínio</th>
                    <th>Total Unidades</th>
                    <th>Total Verdinhos</th>
                </tr>
            </thead>
            <tfoot>
                <td>TOTAL GERAL {{ $keyYear }}</td>
                <td>{{ number_format($total_pet_bottles_anual, 0, '', '.') }}</td>
                <td>{{ number_format($total_packaging_of_cleaning_materials_anual, 0, '', '.') }}</td>
                <td>{{ number_format($total_tetra_pak_anual, 0, '', '.') }}</td>
                <td>{{ number_format($total_aluminum_cans_anual, 0, '', '.') }}</td>
                <td>{{ number_format($total_materials_anual, 0, '', '.') }}</td>
                <td>{{ number_format($total_green_coin_anual, 0, '', '.') }}</td>
            </tfoot>
        </table>
    </section>
    @endforeach
</body>

</html>