<?php

namespace App\Livewire;

use Livewire\Component;
use Carbon\Carbon;

class ProgrameTravail extends Component
{

    public $jours = 15;
    public $personnes = [];
    public $planning = [];

    public $showModalGenerer = false;

    public function mount()
    {
        $this->planning = []; 
    }

    public function genererPlanning()
    {
        $rotation = $this->personnes;
        $total = count($rotation);

        // Initialisation
        $ctxIndex = 0;
        $verifIndex = 1;

        for ($i = 0; $i < $this->jours; $i++) {
            $jour = Carbon::today()->addDays($i)->format('Y-m-d');

            $ctx = $rotation[$ctxIndex % $total];
            $verif = $rotation[$verifIndex % $total];

            // Service Générale = tous sauf CTX et Vérif
            $generale = array_values(array_diff($rotation, [$ctx, $verif]));

            $this->planning[] = [
                'date' => $jour,
                'ctx' => $ctx,
                'verif' => $verif,
                'generale' => $generale,
            ];

            // Le verif de demain est le ctx d’aujourd’hui
            $verifIndex = $ctxIndex;

            // Le ctx de demain passe à la prochaine personne (sauter les 2 affectées)
            $ctxIndex = ($ctxIndex + 1) % $total;

            // Sauter ctxIndex si égal à verifIndex (éviter doublon)
            if ($ctxIndex == $verifIndex) {
                $ctxIndex = ($ctxIndex + 1) % $total;
            }
        }

        $this->showModalGenerer = true;
    }



    public function genere()
    {
        $this->personnes = ['X1','X2','X3','X4','X5','X6','X7','X8','X9','X10'];
        $this->genererPlanning();
    }


    public function render()
    {
        return view('livewire.programe-travail');
    }
}
