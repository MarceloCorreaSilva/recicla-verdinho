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

<body class="bg-gray-100 p-6">

    <!-- Cabeçalho -->
    <div class="header">
        <h1 class="text-2xl font-bold mb-4 text-center">Trocas dia {{ date('d/m/Y', strtotime($date)) }}</h1>
        <p class="py-2 text-right">Data: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" id="">
            @php
            $total_pet_bottles = 0;
            $total_packaging_of_cleaning_materials = 0;
            $total_tetra_pak = 0;
            $total_aluminum_cans = 0;
            $total_materials = 0;
            $total_green_coin = 0;
            @endphp

            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="text-center text-xs" style="width: 20%;">Estudante</th>
                    <th scope="col" class="text-center text-xs" style="width: 13.33%;">Garrafa PET</th>
                    <th scope="col" class="text-center text-xs" style="width: 13.33%;">Mat. Limpeza</th>
                    <th scope="col" class="text-center text-xs" style="width: 13.33%;">Tetra Pak</th>
                    <th scope="col" class="text-center text-xs" style="width: 13.33%;">Alumínio</th>
                    <th scope="col" class="text-center text-xs" style="width: 13.33%;">Total Unidades</th>
                    <th scope="col" class="text-center text-xs" style="width: 13.33%;">Total Verdinhos</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($swaps as $swap)
                @php
                $totalMaterials = $swap->pet_bottles + $swap->packaging_of_cleaning_materials + $swap->tetra_pak + $swap->aluminum_cans;

                $total_pet_bottles += $swap->pet_bottles;
                $total_packaging_of_cleaning_materials += $swap->packaging_of_cleaning_materials;
                $total_tetra_pak += $swap->tetra_pak;
                $total_aluminum_cans += $swap->aluminum_cans;
                $total_materials += $totalMaterials;
                $total_green_coin += $swap->green_coin;
                @endphp
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="text-left text-xs px-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $swap->student->name }}
                    </th>
                    <td class="px-1 py-1 text-center text-xs">{{ number_format($swap->pet_bottles, 0, '', '.') }}</td>
                    <td class="px-1 py-1 text-center text-xs">{{ number_format($swap->packaging_of_cleaning_materials, 0, '', '.') }}</td>
                    <td class="px-1 py-1 text-center text-xs">{{ number_format($swap->tetra_pak, 0, '', '.') }}</td>
                    <td class="px-1 py-1 text-center text-xs">{{ number_format($swap->aluminum_cans, 0, '', '.') }}</td>
                    <td class="px-1 py-1 text-center text-xs">{{ number_format($totalMaterials, 0, '', '.') }}</td>
                    <td class="px-1 py-1 text-center text-xs">{{ number_format($swap->green_coin, 0, '', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-semibold text-gray-900 dark:text-white">
                    <th scope="row" class="text-center text-xs"></th>
                    <td class="px-1 py-1 text-center text-xs font-bold text-bold">{{ number_format($total_pet_bottles, 0, '', '.') }}</td>
                    <td class="px-1 py-1 text-center text-xs font-bold text-bold">{{ number_format($total_packaging_of_cleaning_materials, 0, '', '.') }}</td>
                    <td class="px-1 py-1 text-center text-xs font-bold text-bold">{{ number_format($total_tetra_pak, 0, '', '.') }}</td>
                    <td class="px-1 py-1 text-center text-xs font-bold text-bold">{{ number_format($total_aluminum_cans, 0, '', '.') }}</td>
                    <td class="px-1 py-1 text-center text-xs font-bold text-bold">{{ number_format($total_materials, 0, '', '.') }}</td>
                    <td class="px-1 py-1 text-center text-xs font-bold text-bold">{{ number_format($total_green_coin, 0, '', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>