<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Generator;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class MedicamentosSeeder extends Seeder
{
    private $totalMedicamentos = 0;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('medicamentos')->truncate();

        $contadorGlobal = 0;

        $this->command->line("");
        $this->command->line("##################################################################################");
        $this->command->line("Criar Medicamentos");
        $this->command->line("##################################################################################");

        $faker = Factory::create('pt_PT');
        $this->totalMedicamentos = count(Medicamentos::$list);
        $bloco = [];
        foreach (Medicamentos::$list as $medicamento) {
            $contadorGlobal++;
            $bloco[] = $this->addMedicamento($faker, $medicamento);
            if ($contadorGlobal % 100 == 0) {
                DB::table('medicamentos')->insert($bloco);
                $bloco = [];
                $this->command->info("Criado Medicamento $contadorGlobal de um total de " . $this->totalMedicamentos);
            }
        }
        if (count($bloco) > 0) {
            DB::table('medicamentos')->insert($bloco);
        }
        DB::table('medicamentos')->where('nome', 'like', '%Gener%')->update(['generico' => true]);
        $this->command->info("Criado Medicamento $contadorGlobal de um total de " . $this->totalMedicamentos);
    }

    private function addMedicamento(Generator $faker, $dadosMedicamento)
    {
        $createdAt = Carbon::now()->subDays(600);
        $deletedAt = null;
        if ($dadosMedicamento[2]) {
            $deletedAt = $faker->dateTimeBetween($createdAt);
        }
        return [
            'nome' => $dadosMedicamento[0],
            'preco' => $dadosMedicamento[1],
            'generico' => false,
            'created_at' => $createdAt,
            'updated_at' => $faker->dateTimeBetween($createdAt),
            'deleted_at' => $deletedAt
        ];
    }
}
