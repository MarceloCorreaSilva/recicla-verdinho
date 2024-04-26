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

<body class="bg-gray-100 p-6">

    <!-- Cabeçalho -->
    <div class="header">
        <h1 class="text-2xl font-bold mb-4 text-center">Trocas dia {{ date('d/m/Y', strtotime($date)) }}</h1>
        <p class="py-2 text-right">Data: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
    </div>

    <section class="mb-6">
        <table class="table">
            @php
            $total_pet_bottles = 0;
            $total_packaging_of_cleaning_materials = 0;
            $total_tetra_pak = 0;
            $total_aluminum_cans = 0;
            $total_materials = 0;
            $total_green_coin = 0;
            @endphp

            <thead>
                <tr>
                    <th class="text-center text-xs" style="width: 20%;">Estudante</th>
                    <th class="text-center text-xs" style="width: 13.33%;">Garrafa PET</th>
                    <th class="text-center text-xs" style="width: 13.33%;">Mat. Limpeza</th>
                    <th class="text-center text-xs" style="width: 13.33%;">Tetra Pak</th>
                    <th class="text-center text-xs" style="width: 13.33%;">Alumínio</th>
                    <th class="text-center text-xs" style="width: 13.33%;">Total Unidades</th>
                    <th class="text-center text-xs" style="width: 13.33%;">Total Verdinhos</th>
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
                <tr>
                    <td class="text-center text-xs">{{ $swap->student->name }}</td>
                    <td class="text-center text-xs">{{ number_format($swap->pet_bottles, 0, '', '.') }}</td>
                    <td class="text-center text-xs">{{ number_format($swap->packaging_of_cleaning_materials, 0, '', '.') }}</td>
                    <td class="text-center text-xs">{{ number_format($swap->tetra_pak, 0, '', '.') }}</td>
                    <td class="text-center text-xs">{{ number_format($swap->aluminum_cans, 0, '', '.') }}</td>
                    <td class="text-center text-xs">{{ number_format($totalMaterials, 0, '', '.') }}</td>
                    <td class="text-center text-xs">{{ number_format($swap->green_coin, 0, '', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <td class="text-center text-xs font-bold text-bold"></td>
                <td class="text-center text-xs font-bold text-bold">{{ number_format($total_pet_bottles, 0, '', '.') }}</td>
                <td class="text-center text-xs font-bold text-bold">{{ number_format($total_packaging_of_cleaning_materials, 0, '', '.') }}</td>
                <td class="text-center text-xs font-bold text-bold">{{ number_format($total_tetra_pak, 0, '', '.') }}</td>
                <td class="text-center text-xs font-bold text-bold">{{ number_format($total_aluminum_cans, 0, '', '.') }}</td>
                <td class="text-center text-xs font-bold text-bold">{{ number_format($total_materials, 0, '', '.') }}</td>
                <td class="text-center text-xs font-bold text-bold">{{ number_format($total_green_coin, 0, '', '.') }}</td>
            </tfoot>
        </table>
    </section>
</body>

</html>