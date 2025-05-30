<?php

namespace App\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\ProgrammeTravail; // Assurez-vous que le modèle est correctement importé
use App\Models\Personnes; // Assurez-vous que le modèle est correctement importé

class ProgrameTravail extends Component
{

    public $jours = 15;
    public $personnes = [];
    public $planning = [];
    public $Date=null;
    public $groupe;
    public $canGenerate = false;

    public $groupes = [];
    public $groupeSelectionne;
    public $planningGroupe = [];
    public $showModalDetails = false;


    public $showModalGenerer = false;

    public function mount()
    {
        $this->planning = []; 

        $this->personnes = Personnes::pluck('nom', 'code')->toArray();

        $this->groupes = ProgrammeTravail::select('groupe')
            ->groupBy('groupe')
            ->orderByRaw('MIN(created_at) DESC') // Ou DESC pour les plus récents d'abord
            ->pluck('groupe')
            ->toArray();

    }

    public function rafraichir()
    {
        $this->reset(); // Réinitialise toutes les propriétés publiques
        $this->mount(); // Recharge les données comme au chargement initial
    }

    public function voirGroupe($groupe)
    {
        $this->groupeSelectionne = $groupe;
         //dd($groupe); // ← Ajoute ceci temporairement
        $this->planningGroupe = ProgrammeTravail::where('groupe', $groupe)
            ->orderBy('date')
            ->get()
            ->toArray();

        $this->showModalDetails = true;
    }

    public function fermerModal()
    {
        $this->showModalGenerer = false;
        $this->Date = Carbon::today()->format('Y-m-d'); // Réinitialiser la date
    }


    public function genererPlanning()
    {
        $rotation = array_filter($this->personnes, function ($value, $key) {
            return $key !== 'Absent';
        }, ARRAY_FILTER_USE_BOTH);

        $codes = array_keys($rotation);
        $total = count($codes);

        $debut = Carbon::parse($this->Date);
        $this->planning = [];

        $ctxIndex = 0;
        $verifIndex = 1;

        $ctxHier = null;
        $verifHier = null;

        for ($i = 0; $i < $this->jours; $i++) {
            $jour = $debut->copy()->addDays($i)->format('Y-m-d');

            if ($i == 0) {
                // Jour 0 : ctx et verif fixes
                $ctx = $codes[$ctxIndex % $total];
                $verif = $codes[$verifIndex % $total];
            } else {
                // verif du jour = ctx d'hier
                $verif = $ctxHier;

                // Pour ctx du jour : exclure ctxHier, verifHier, et verif (qui est ctxHier)
                $exclusCtx = [$ctxHier, $verifHier, $verif];
                $exclusCtx = array_unique($exclusCtx);

                // Chercher le prochain ctx possible (qui ne soit pas dans les exclus)
                $tentatives = 0;
                do {
                    $ctxIndex = ($ctxIndex + 1) % $total;
                    $ctxCandidate = $codes[$ctxIndex];
                    $tentatives++;
                    if ($tentatives > $total) {
                        // sécurité si pas trouvé : break pour éviter boucle infinie
                        break;
                    }
                } while (in_array($ctxCandidate, $exclusCtx));

                $ctx = $ctxCandidate;
            }

            // Préparer service générale
            // Exclure ctx et verif du jour
            $exclusGenerale = [$ctx, $verif];
            $generale = [];

            // Ajouter verifHier dans générale s'il n'est pas ctx ou verif aujourd'hui
            if ($verifHier && !in_array($verifHier, $exclusGenerale)) {
                $generale[] = $verifHier;
            }

            // Compléter service générale avec le reste des personnes dispo
            $restants = array_values(array_diff($codes, array_merge($exclusGenerale, $generale)));
            $generale = array_merge($generale, $restants);

            // Ajouter la journée au planning
            $this->planning[] = [
                'date' => $jour,
                'ctx' => $ctx,
                'verif' => $verif,
                'generale' => $generale,
            ];

            // Mémoriser pour le lendemain
            $ctxHier = $ctx;
            $verifHier = $verif;
        }

        $this->showModalGenerer = true;
    }




    public function updated($property)
    {
        $this->canGenerate = !empty($this->groupe);
    }

    public function confirmerSuppression($groupe)
    {
        ProgrammeTravail::where('groupe', $groupe)->delete();

        $this->mount(); // Recharger les données initiales

        $this->reset(['planningGroupe', 'groupeSelectionne', 'showModalDetails']);

        session()->flash('message', 'Programme supprimé avec succès.');
    }

    public function save()
    {
        if (empty($this->groupe)) {
            $this->groupe = 'Programme du ' 
                . Carbon::parse($this->Date)->format('d-m-Y') 
                . ' au ' 
                . Carbon::parse($this->Date)->addDays($this->jours - 1)->format('d-m-Y');
        }

        foreach ($this->planning as $jour) {
            ProgrammeTravail::create([
                'groupe' => $this->groupe,
                'date' => $jour['date'],
                'ctx' => $this->personnes[$jour['ctx']] ?? $jour['ctx'],
                'verif' => $this->personnes[$jour['verif']] ?? $jour['verif'],
                'generale' => array_map(fn($code) => $this->personnes[$code] ?? $jour['generale'], $jour['generale']), // JSON si casté
            ]);
        }

        session()->flash('message', 'Programme enregistré avec succès.');

        // Réinitialiser les données du formulaire
        $this->reset(['showModalGenerer', 'planning', 'Date', 'groupe']);
        
        // Optionnel : remettre à jour groupeSelectionne si tu veux afficher les détails juste après
        // $this->groupeSelectionne = $this->groupe;
        // $this->loadPlanningForGroup(); // ou la méthode équivalente
        $this->resetInputFields();
        $this->mount(); // Recharger les données initiales
    }


    public function genere()
    {
        $debut = Carbon::parse($this->Date);
        $this->planning = []; 
        $this->personnes =  Personnes::pluck('nom', 'code')->toArray();
        $this->genererPlanning();
    }

    public function resetInputFields()
    {
        $this->Date = null; 
        $this->ctx = '';
        $this->verif = '';
    }


    public function render()
    {
        return view('livewire.programe-travail');
    }
}
