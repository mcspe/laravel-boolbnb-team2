<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Apartment;
use App\Models\Service;


class ApartmentServiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $apartments = Apartment::all();
      $services = Service::all();

      foreach ($apartments as $apt) {
        $apt->services()->attach(1);
        $apt->services()->attach(3);
        $apt->services()->attach(4);
        $apt->services()->attach(5);
        $apt->services()->attach(7);

        $excludedIds = [1, 3, 4, 5, 7]; // Gli ID che vuoi escludere dalla ricerca
        $selectedIds = [];

        // Genera un numero casuale tra 1 e 10 per il numero di iterazioni del ciclo for
        $iterations = mt_rand(1, 10);

        for ($j = 0; $j < $iterations; $j++) {
          // Aggiungi un controllo per evitare di selezionare due volte lo stesso ID
          $service = Service::whereNotIn('id', array_merge($excludedIds, $selectedIds))
            ->inRandomOrder()
            ->first();

          if ($service && !in_array($service->id, $selectedIds)) {
              $selectedIds[] = $service->id;
          } else {
              // Qui puoi gestire il caso in cui non ci sono più record disponibili dopo l'esclusione.
              // Ad esempio, puoi terminare il ciclo o gestire diversamente il flusso dell'applicazione.
              break;
          }
        }

        // Ora puoi accedere agli ID selezionati nel ciclo
        foreach ($selectedIds as $service_id) {
          $apt->services()->attach($service_id);
        }
      }
    }
}
