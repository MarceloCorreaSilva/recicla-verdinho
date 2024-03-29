<?php

namespace Database\Seeders;

use App\Models\Financial;
use App\Models\School;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $school01 = School::factory()->create(['city_id' => '1', 'name' => 'Escola Municipal 1', 'limit_per_swap' => 200, 'project_started' => '2024-01-01 00:00:00', 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school01->id,
            'balance' => 2000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);

        $school02 = School::factory()->create(['city_id' => '1', 'name' => 'Escola Municipal 2', 'limit_per_swap' => 200, 'project_started' => '2024-01-01 00:00:00', 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school02->id,
            'balance' => 2000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);

        $school03 = School::factory()->create(['city_id' => '1', 'name' => 'Escola Municipal 3', 'limit_per_swap' => 200, 'project_started' => '2024-01-01 00:00:00', 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school03->id,
            'balance' => 2000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);

        $school04 = School::factory()->create(['city_id' => '1', 'name' => 'Escola Municipal 4', 'limit_per_swap' => 200, 'project_started' => '2024-01-01 00:00:00', 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school04->id,
            'balance' => 2000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);

        $school05 = School::factory()->create(['city_id' => '2', 'name' => 'Escola Municipal 1', 'limit_per_swap' => 200, 'project_started' => '2024-01-01 00:00:00', 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school05->id,
            'balance' => 2000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);

        return;

        $school01 = School::factory()->create(['city_id' => '5102678', 'name' => 'Centro Educacional Paulo Freire', 'limit_per_swap' => 200, 'project_started' => '2020-08-01 00:00:00', 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school01->id,
            'balance' => 5000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
        $school02 = School::factory()->create(['city_id' => '5104104', 'name' => 'Escola Municipal 13 de Maio', 'limit_per_swap' => 200, 'project_started' => '2021-05-26 00:00:00', 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school02->id,
            'balance' => 5000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
        $school03 = School::factory()->create(['city_id' => '5106307', 'name' => 'Escola Municipal 03 de Maio', 'limit_per_swap' => 200, 'project_started' => '2021-07-04 00:00:00', 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school03->id,
            'balance' => 5000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
        $school04 = School::factory()->create(['city_id' => '5007208', 'name' => 'Centro Educacional Criança Esperança VI', 'limit_per_swap' => 200, 'project_started'  => '2021-09-07 00:00:00', 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school04->id,
            'balance' => 5000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
        $school05 = School::factory()->create(['city_id' => '5100201', 'name' => 'Escola Municipal Guarujá', 'limit_per_swap' => 200, 'project_started' => '2022-05-29 00:00:00', 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school05->id,
            'balance' => 5000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
        $school06 = School::factory()->create(['city_id' => '5100201', 'name' => 'Ermindo Mendel', 'limit_per_swap' => 200, 'project_started' => '2023-06-25 00:00:00', 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school06->id,
            'balance' => 5000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
        $school07 = School::factory()->create(['city_id' => '5105580', 'name' => 'Escola Municipal Castro Alves', 'limit_per_swap' => 200, 'project_started' => '2021-10-29 00:00:00', 'project_completed' => '2022-12-31 00:00:00', 'active' => false]);
        Financial::factory()->create([
            'school_id' => $school07->id,
            'balance' => 5000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
        $school08 = School::factory()->create(['city_id' => '5105580', 'name' => 'Escola Municipal Santa Terezinha', 'limit_per_swap' => 200, 'project_started' => '2021-10-29 00:00:00', 'project_completed' => '2022-12-31 00:00:00', 'active' => false]);
        Financial::factory()->create([
            'school_id' => $school08->id,
            'balance' => 5000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
        $school09 = School::factory()->create(['city_id' => '5005400', 'name' => 'Escola Municipal Professora Maurícia Paré Gomes', 'limit_per_swap' => 200, 'project_started' => '2022-04-09 00:00:00', 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school09->id,
            'balance' => 5000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
        $school10 = School::factory()->create(['city_id' => '5003256', 'name' => 'Escola Municipal Vale do Amanhecer', 'limit_per_swap' => 200, 'project_started' => null, 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school10->id,
            'balance' => 5000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
        $school11 = School::factory()->create(['city_id' => '5006200', 'name' => 'Escola Municipal Brincando de Aprender', 'limit_per_swap' => 200, 'project_started' => '2022-04-03 00:00:00', 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school11->id,
            'balance' => 5000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
        $school12 = School::factory()->create(['city_id' => '5006200', 'name' => 'Escola Municipal Arco Iris', 'limit_per_swap' => 200, 'project_started' => '2023-09-21 00:00:00', 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school12->id,
            'balance' => 5000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
        $school13 = School::factory()->create(['city_id' => '5003702', 'name' => 'Escola Municipal Clori Benedetti de Freitas', 'limit_per_swap' => 200, 'project_started' => '2022-06-29 00:00:00', 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school13->id,
            'balance' => 5000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
        $school14 = School::factory()->create(['city_id' => '5000609', 'name' => 'Escola Municipal Professora Maria Bataglin Machado', 'limit_per_swap' => 200, 'project_started' => '2022-06-22 00:00:00', 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school14->id,
            'balance' => 5000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
        $school15 = School::factory()->create(['city_id' => '5000609', 'name' => 'Escola Municipal Antônio Pinto da Silva', 'limit_per_swap' => 200, 'project_started' => '2023-07-12 00:00:00', 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school15->id,
            'balance' => 5000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
        $school16 = School::factory()->create(['city_id' => '5007406', 'name' => 'Escola Municipal José Duailibi', 'limit_per_swap' => 200, 'project_started' => '2022-09-14 00:00:00', 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school16->id,
            'balance' => 5000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
        $school17 = School::factory()->create(['city_id' => '5007406', 'name' => 'Escola Municipal Polo Mariza Ferzelli', 'limit_per_swap' => 200, 'project_started' => '2023-05-31 00:00:00', 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school17->id,
            'balance' => 5000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
        $school18 = School::factory()->create(['city_id' => '5004403', 'name' => 'CEI Professor Olivalto Elias da Silva', 'limit_per_swap' => 200, 'project_started' => '2022-08-21 00:00:00', 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school18->id,
            'balance' => 5000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
        $school19 = School::factory()->create(['city_id' => '5107925', 'name' => 'Escola Municipal Profª Ivete Lourdes Arenhardt', 'limit_per_swap' => 200, 'project_started' => '2022-08-20 00:00:00',  'project_completed' => '2022-12-31 00:00:00', 'active' => false]);
        Financial::factory()->create([
            'school_id' => $school19->id,
            'balance' => 5000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
        $school20 = School::factory()->create(['city_id' => '5107248', 'name' => 'Escola Municipal Selvino Damian Preve', 'limit_per_swap' => 200, 'project_started' => '2022-08-19 00:00:00', 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school20->id,
            'balance' => 5000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
        $school21 = School::factory()->create(['city_id' => '5103056', 'name' => 'Escola Municipal Daniel Titton', 'limit_per_swap' => 200, 'project_started' => '2022-08-10 00:00:00', 'project_completed' => '2022-12-31 00:00:00', 'active' => false]);
        Financial::factory()->create([
            'school_id' => $school21->id,
            'balance' => 5000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
        $school22 = School::factory()->create(['city_id' => '5006275', 'name' => 'Escola Municipal Lizete Rivelli Alpe', 'limit_per_swap' => 200, 'project_started' => '2022-10-20 00:00:00', 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school22->id,
            'balance' => 5000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
        $school23 = School::factory()->create(['city_id' => '5107958', 'name' => 'Centro Municipal de Ensino Fausto Eugênio Masson', 'limit_per_swap' => 200, 'project_started' => '2022-11-23 00:00:00', 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school23->id,
            'balance' => 5000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
        $school24 = School::factory()->create(['city_id' => '5006002', 'name' => 'Escola Ires Brunetto', 'limit_per_swap' => 200, 'project_started' => '2022-09-17 00:00:00', 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school24->id,
            'balance' => 5000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
        $school25 = School::factory()->create(['city_id' => '5006002', 'name' => 'Escola Adenisaldo Araújo de Rezende', 'limit_per_swap' => 200, 'project_started' => '2023-06-03 00:00:00', 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school25->id,
            'balance' => 5000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
        $school26 = School::factory()->create(['city_id' => '5104609', 'name' => 'Escola Municipal Anfilófio de Souza Campos', 'limit_per_swap' => 200, 'project_started' => '2022-09-14 00:00:00', 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school26->id,
            'balance' => 5000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
        $school27 = School::factory()->create(['city_id' => '5104609', 'name' => 'Escola Municipal José Rodrigues da Silva', 'limit_per_swap' => 200, 'project_started' => '2022-09-14 00:00:00', 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school27->id,
            'balance' => 5000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
        $school28 = School::factory()->create(['city_id' => '5103502', 'name' => 'Escola Municipal Brás Maimoni', 'limit_per_swap' => 200, 'project_started' => '2022-11-23 00:00:00', 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school28->id,
            'balance' => 5000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
        $school29 = School::factory()->create(['city_id' => '5106505', 'name' => 'Escola Municipal João Godofredo da Silva', 'limit_per_swap' => 200, 'project_started' => '2023-05-12 00:00:00', 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school29->id,
            'balance' => 5000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
        $school30 = School::factory()->create(['city_id' => '5106505', 'name' => 'Escola Municipal Juscelino Kubitschek de Oliveira', 'limit_per_swap' => 200, 'project_started' => '2023-05-12 00:00:00', 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school30->id,
            'balance' => 5000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
        $school31 = School::factory()->create(['city_id' => '5106109', 'name' => 'Escola Municipal Professora Délia Galdina Duarte', 'limit_per_swap' => 200, 'project_started' => '2023-05-20 00:00:00', 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school31->id,
            'balance' => 5000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
        $school32 = School::factory()->create(['city_id' => '5101605', 'name' => 'Escola Municipal Cuiabá Mirim', 'limit_per_swap' => 200, 'project_started' => '2023-06-13 00:00:00', 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school32->id,
            'balance' => 5000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
        $school33 = School::factory()->create(['city_id' => '5101605', 'name' => 'Escola Municipal Estirão Comprido', 'limit_per_swap' => 200, 'project_started' => '2023-06-13 00:00:00', 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school33->id,
            'balance' => 5000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
        $school34 = School::factory()->create(['city_id' => '5102504', 'name' => 'Escola Municipal Jardim Paraíso', 'limit_per_swap' => 200, 'project_started' => '2023-06-25 00:00:00', 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school34->id,
            'balance' => 5000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
        $school35 = School::factory()->create(['city_id' => '5102702', 'name' => 'Escola Municipal ...', 'limit_per_swap' => 200, 'project_started' => '2023-07-02 00:00:00', 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school35->id,
            'balance' => 5000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
        $school36 = School::factory()->create(['city_id' => '5005707', 'name' => 'Escola Municipal Professor Milton Dias Porto', 'limit_per_swap' => 200, 'project_started' => '2023-07-02 00:00:00', 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school36->id,
            'balance' => 5000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
        $school37 = School::factory()->create(['city_id' => '5002100', 'name' => 'Escola Municipal Jarbas Passarinho', 'limit_per_swap' => 200, 'project_started' => '2023-07-06 00:00:00', 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school37->id,
            'balance' => 5000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
        $school38 = School::factory()->create(['city_id' => '5002407', 'name' => 'Escola Municipal Professor Moacir Franco de Carvalho', 'limit_per_swap' => 200, 'project_started' => '2023-07-13 00:00:00', 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school38->id,
            'balance' => 5000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
        $school39 = School::factory()->create(['city_id' => '5006606', 'name' => 'Escola Municipal João Carlos Pinheiro Marques', 'limit_per_swap' => 200, 'project_started' => '2023-08-09 00:00:00', 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school39->id,
            'balance' => 5000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
        $school40 = School::factory()->create(['city_id' => '5105234', 'name' => 'Escola Municipal ...', 'limit_per_swap' => 200, 'project_started' => '2023-08-16 00:00:00', 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school40->id,
            'balance' => 5000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
        $school41 = School::factory()->create(['city_id' => '5007554', 'name' => 'Escola Municipal Raimundo Cândido de Araújo', 'limit_per_swap' => 200, 'project_started' => '2023-09-02 00:00:00', 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school41->id,
            'balance' => 5000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
        $school42 = School::factory()->create(['city_id' => '5001904', 'name' => 'Escola Municipal Marechal Rondon', 'limit_per_swap' => 200, 'project_started' => '2023-09-03 00:00:00', 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school42->id,
            'balance' => 5000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
        $school43 = School::factory()->create(['city_id' => '5101407', 'name' => 'Escola Municipal Maria Luiza do Nascimento Silva', 'limit_per_swap' => 200, 'project_started' => '2023-09-15 00:00:00', 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school43->id,
            'balance' => 5000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
        $school44 = School::factory()->create(['city_id' => '5003306', 'name' => 'Escola Municipal Escola Municipal Marechal Rondon – Extensão Sílvio Ferreira', 'limit_per_swap' => 200, 'project_started' => '2023-09-28 00:00:00', 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school44->id,
            'balance' => 5000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
        $school45 = School::factory()->create(['city_id' => '5002308', 'name' => 'Escola Municipal Paulo Simões Braga', 'limit_per_swap' => 200, 'project_started' => '2023-10-04 00:00:00', 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school45->id,
            'balance' => 5000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
        $school46 = School::factory()->create(['city_id' => '5005806', 'name' => 'Escola Municipal Guilherme Corrêa da Silva', 'limit_per_swap' => 200, 'project_started' => '2023-10-07 00:00:00', 'active' => true]);
        Financial::factory()->create([
            'school_id' => $school46->id,
            'balance' => 5000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
    }
}
