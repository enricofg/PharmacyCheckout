<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;


class ReceitasSeeder extends Seeder
{
    private $contadorReceitas = 0;
    public function run()
    {
        $this->command->line("");
        $this->command->line("##################################################################################");
        $this->command->line("A criar receitas");
        $this->command->line("##################################################################################");

        DB::table('medicamento_receita')->truncate();
        DB::table('receitas')->truncate();

        $faker = Factory::create('pt_PT');

        $day = Carbon::now()->subDays(60);
        $day2 = Carbon::now()->subDays(15);
        for ($i = 0; $i < 58; $i++) {
            $day = $day->addDays(1);
            $totalDay = rand(2, 6);
            $this->command->info("A criar $totalDay receitas para o dia {$day->format('Y-m-d')}");
            for ($j = 0; $j < $totalDay; $j++) {
                $this->criarUmaReceita($faker, $this->getRandomCliente(), $day, $day >= $day2);
            }
        }
    }

    private function criarUmaReceita(Generator $faker, $cliente, $day, $latestDays)
    {
        $createdAt = $day->copy();
        $start = $faker->dateTimeBetween($createdAt->format('Y-m-d H:i:s'),  $createdAt->addDays(1)->format('Y-m-d H:i:s'));
        $d1 = (new Carbon($start->format(DATE_ISO8601)))->addMinutes(100);
        $d2 = (new Carbon($start->format(DATE_ISO8601)))->addMinutes(2800);

        $end = $faker->dateTimeBetween($d1->format('Y-m-d H:i:s'), $d2->format('Y-m-d H:i:s'));
        $d1 = (new Carbon($end->format(DATE_ISO8601)))->addMinutes(1);
        $d2 = (new Carbon($end->format(DATE_ISO8601)))->addMinutes(100);
        $updated_at = $faker->dateTimeBetween($d1->format('Y-m-d H:i:s'), $d2->format('Y-m-d H:i:s'));

        $now = now();
        $createdAt = $createdAt > $now ? $now : $createdAt;
        $start = $start > $now ? $now : $start;
        $end = $end > $now ? $now : $end;
        $updated_at = $updated_at > $now ? $now : $updated_at;

        $randomNumber = rand(1, 60);
        $estado_receita = $latestDays && $randomNumber > 20 ? 'A' : 'F';
        $estado_receita = $randomNumber < 4 ? 'R' : $estado_receita;
        $farmaceutico_responsavel = $estado_receita == 'A' ? null : $this->getRandomFarmaceutico();
        $receita = [
            'cliente_id' => $cliente,
            'data' => $day->format('Y-m-d'),
            'total' => 0,
            'estado_receita' => $estado_receita,
            'farmaceutico_id' => $farmaceutico_responsavel,
            'created_at' => $createdAt,
            'updated_at' => $updated_at
        ];
        $newIDReceita = DB::table('receitas')->insertGetId($receita);
        $totalMedicamentos = Arr::random([1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 3, 3, 3, 3, 4, 4, 4, 5, 5, 6, 7, 8]);
        $arrayMedicamentos = $this->getRandomMedicamentos($totalMedicamentos);
        $total = 0;
        $medicamento_receitas = [];
        foreach ($arrayMedicamentos as $medicamento) {
            $qtd = Arr::random([1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 3, 3, 4, 5]);
            $preco_un = round($medicamento->preco, 2);
            $total += round($qtd * $preco_un, 2);
            $medicamento_receitas[] = [
                'receita_id' => $newIDReceita,
                'medicamento_id' => $medicamento->id,
                'qtd' => $qtd,
                'preco_un' => $preco_un
            ];
        }
        DB::table('medicamento_receita')->insert($medicamento_receitas);
        DB::table('receitas')->where('id', $newIDReceita)->update(['total' => $total]);
    }

    private function getRandomCliente()
    {
        static $clientes;
        $clientes = $clientes != null ? $clientes : DB::table('users')->where('tipo_user', 'C')->pluck('id');
        return $clientes->random();
    }

    private function getRandomFarmaceutico()
    {
        static $farmaceuticos;
        $farmaceuticos = $farmaceuticos != null ? $farmaceuticos : DB::table('users')->where('tipo_user', 'F')->pluck('id');
        return $farmaceuticos->random();
    }

    private function getRandomMedicamentos($totalMedicamentos)
    {
        static $medicamentos;
        $medicamentos = $medicamentos != null ? $medicamentos : DB::table('medicamentos')->whereNull('deleted_at')->get();
        return $medicamentos->random($totalMedicamentos);
    }
}
