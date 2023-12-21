<?php

namespace Database\Seeders;

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
        School::factory()->create(['city_id' => '5102678', 'name' => 'Centro Educacional Paulo Freire', 'project_started' => '2020-08-01 00:00:00', 'active' => true]);
        School::factory()->create(['city_id' => '5104104', 'name' => 'Escola Municipal 13 de Maio', 'project_started' => '2021-05-26 00:00:00', 'active' => true]);
        School::factory()->create(['city_id' => '5106307', 'name' => 'Escola Municipal 03 de Maio', 'project_started' => '2021-07-04 00:00:00', 'active' => true]);
        School::factory()->create(['city_id' => '5007208', 'name' => 'Centro Educacional Criança Esperança VI', 'project_started'  => '2021-09-07 00:00:00', 'active' => true]);
        School::factory()->create(['city_id' => '5100201', 'name' => 'Escola Municipal Guarujá', 'project_started' => '2022-05-29 00:00:00', 'active' => true]);
        School::factory()->create(['city_id' => '5100201', 'name' => 'Ermindo Mendel', 'project_started' => '2023-06-25 00:00:00', 'active' => true]);
        School::factory()->create(['city_id' => '5105580', 'name' => 'Escola Municipal Castro Alves', 'project_started' => '2021-10-29 00:00:00', 'project_completed' => '2022-12-31 00:00:00', 'active' => false]);
        School::factory()->create(['city_id' => '5105580', 'name' => 'Escola Municipal Santa Terezinha', 'project_started' => '2021-10-29 00:00:00', 'project_completed' => '2022-12-31 00:00:00', 'active' => false]);
        School::factory()->create(['city_id' => '5005400', 'name' => 'Escola Municipal Professora Maurícia Paré Gomes', 'project_started' => '2022-04-09 00:00:00', 'active' => true]);
        School::factory()->create(['city_id' => '5003256', 'name' => 'Escola Municipal Vale do Amanhecer', 'project_started' => null, 'active' => true]);
        School::factory()->create(['city_id' => '5006200', 'name' => 'Escola Municipal Brincando de Aprender', 'project_started' => '2022-04-03 00:00:00', 'active' => true]);
        School::factory()->create(['city_id' => '5006200', 'name' => 'Escola Municipal Arco Iris', 'project_started' => '2023-09-21 00:00:00', 'active' => true]);
        School::factory()->create(['city_id' => '5003702', 'name' => 'Escola Municipal Clori Benedetti de Freitas', 'project_started' => '2022-06-29 00:00:00', 'active' => true]);
        School::factory()->create(['city_id' => '5000609', 'name' => 'Escola Municipal Professora Maria Bataglin Machado', 'project_started' => '2022-06-22 00:00:00', 'active' => true]);
        School::factory()->create(['city_id' => '5000609', 'name' => 'Escola Municipal Antônio Pinto da Silva', 'project_started' => '2023-07-12 00:00:00', 'active' => true]);
        School::factory()->create(['city_id' => '5007406', 'name' => 'Escola Municipal José Duailibi', 'project_started' => '2022-09-14 00:00:00', 'active' => true]);
        School::factory()->create(['city_id' => '5007406', 'name' => 'Escola Municipal Polo Mariza Ferzelli', 'project_started' => '2023-05-31 00:00:00', 'active' => true]);
        School::factory()->create(['city_id' => '5004403', 'name' => 'CEI Professor Olivalto Elias da Silva', 'project_started' => '2022-08-21 00:00:00', 'active' => true]);
        School::factory()->create(['city_id' => '5107925', 'name' => 'Escola Municipal Profª Ivete Lourdes Arenhardt', 'project_started' => '2022-08-20 00:00:00',  'project_completed' => '2022-12-31 00:00:00', 'active' => false]);
        School::factory()->create(['city_id' => '5107248', 'name' => 'Escola Municipal Selvino Damian Preve', 'project_started' => '2022-08-19 00:00:00', 'active' => true]);
        School::factory()->create(['city_id' => '5103056', 'name' => 'Escola Municipal Daniel Titton', 'project_started' => '2022-08-10 00:00:00', 'project_completed' => '2022-12-31 00:00:00', 'active' => false]);
        School::factory()->create(['city_id' => '5006275', 'name' => 'Escola Municipal Lizete Rivelli Alpe', 'project_started' => '2022-10-20 00:00:00', 'active' => true]);
        School::factory()->create(['city_id' => '5107958', 'name' => 'Centro Municipal de Ensino Fausto Eugênio Masson', 'project_started' => '2022-11-23 00:00:00', 'active' => true]);
        School::factory()->create(['city_id' => '5006002', 'name' => 'Escola Ires Brunetto', 'project_started' => '2022-09-17 00:00:00', 'active' => true]);
        School::factory()->create(['city_id' => '5006002', 'name' => 'Escola Adenisaldo Araújo de Rezende', 'project_started' => '2023-06-03 00:00:00', 'active' => true]);
        School::factory()->create(['city_id' => '5104609', 'name' => 'Escola Municipal Anfilófio de Souza Campos', 'project_started' => '2022-09-14 00:00:00', 'active' => true]);
        School::factory()->create(['city_id' => '5104609', 'name' => 'Escola Municipal José Rodrigues da Silva', 'project_started' => '2022-09-14 00:00:00', 'active' => true]);
        School::factory()->create(['city_id' => '5103502', 'name' => 'Escola Municipal Brás Maimoni', 'project_started' => '2022-11-23 00:00:00', 'active' => true]);
        School::factory()->create(['city_id' => '5106505', 'name' => 'Escola Municipal João Godofredo da Silva', 'project_started' => '2023-05-12 00:00:00', 'active' => true]);
        School::factory()->create(['city_id' => '5106505', 'name' => 'Escola Municipal Juscelino Kubitschek de Oliveira', 'project_started' => '2023-05-12 00:00:00', 'active' => true]);
        School::factory()->create(['city_id' => '5106109', 'name' => 'Escola Municipal Professora Délia Galdina Duarte', 'project_started' => '2023-05-20 00:00:00', 'active' => true]);
        School::factory()->create(['city_id' => '5101605', 'name' => 'Escola Municipal Cuiabá Mirim', 'project_started' => '2023-06-13 00:00:00', 'active' => true]);
        School::factory()->create(['city_id' => '5101605', 'name' => 'Escola Municipal Estirão Comprido', 'project_started' => '2023-06-13 00:00:00', 'active' => true]);
        School::factory()->create(['city_id' => '5102504', 'name' => 'Escola Municipal Jardim Paraíso', 'project_started' => '2023-06-25 00:00:00', 'active' => true]);
        School::factory()->create(['city_id' => '5102702', 'name' => 'Escola Municipal ...', 'project_started' => '2023-07-02 00:00:00', 'active' => true]);
        School::factory()->create(['city_id' => '5005707', 'name' => 'Escola Municipal Professor Milton Dias Porto', 'project_started' => '2023-07-02 00:00:00', 'active' => true]);
        School::factory()->create(['city_id' => '5002100', 'name' => 'Escola Municipal Jarbas Passarinho', 'project_started' => '2023-07-06 00:00:00', 'active' => true]);
        School::factory()->create(['city_id' => '5002407', 'name' => 'Escola Municipal Professor Moacir Franco de Carvalho', 'project_started' => '2023-07-13 00:00:00', 'active' => true]);
        School::factory()->create(['city_id' => '5006606', 'name' => 'Escola Municipal João Carlos Pinheiro Marques', 'project_started' => '2023-08-09 00:00:00', 'active' => true]);
        School::factory()->create(['city_id' => '5105234', 'name' => 'Escola Municipal ...', 'project_started' => '2023-08-16 00:00:00', 'active' => true]);
        School::factory()->create(['city_id' => '5007554', 'name' => 'Escola Municipal Raimundo Cândido de Araújo', 'project_started' => '2023-09-02 00:00:00', 'active' => true]);
        School::factory()->create(['city_id' => '5001904', 'name' => 'Escola Municipal Marechal Rondon', 'project_started' => '2023-09-03 00:00:00', 'active' => true]);
        School::factory()->create(['city_id' => '5101407', 'name' => 'Escola Municipal Maria Luiza do Nascimento Silva', 'project_started' => '2023-09-15 00:00:00', 'active' => true]);
        School::factory()->create(['city_id' => '5003306', 'name' => 'Escola Municipal Escola Municipal Marechal Rondon – Extensão Sílvio Ferreira', 'project_started' => '2023-09-28 00:00:00', 'active' => true]);
        School::factory()->create(['city_id' => '5002308', 'name' => 'Escola Municipal Paulo Simões Braga', 'project_started' => '2023-10-04 00:00:00', 'active' => true]);
        School::factory()->create(['city_id' => '5005806', 'name' => 'Escola Municipal Guilherme Corrêa da Silva', 'project_started' => '2023-10-07 00:00:00', 'active' => true]);
    }
}
