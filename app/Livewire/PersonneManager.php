<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Personnes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class PersonneManager extends Component
{
    public $code, $nom, $telephone, $role;
    public $editingId = null;

    public $editId = null;
    public $editCode, $editNom, $editTelephone, $editRole;

    public $personneId = null;
    public $isEditing = false;

    public $codesDisponibles = [];

    public function mount()
    {
        $this->codesDisponibles = Personnes::pluck('code')->unique()->toArray(); // ou selon ta logique
    }

    public function save()
    {
        $rules = [
            'nom' => 'required|string',
            'telephone' => 'nullable|string',
            'code' => 'required|string',
            'role' => 'nullable|string',
        ];

        if ($this->code !== 'Absent') {
            if ($this->isEditing && $this->personneId) {
                $rules['code'] .= '|unique:personnes,code,' . $this->personneId;
            } else {
                $rules['code'] .= '|unique:personnes,code';
            }
        }

        $this->validate($rules);

        if ($this->isEditing && $this->personneId) {
            Personnes::findOrFail($this->personneId)->update([
                'nom' => $this->nom,
                'telephone' => $this->telephone,
                'code' => $this->code,
                'role' => $this->role,
            ]);
            session()->flash('success', 'Personne mise à jour.');
        } else {
            Personnes::create([
                'nom' => $this->nom,
                'telephone' => $this->telephone,
                'code' => $this->code,
                'role' => $this->role,
            ]);
            session()->flash('success', 'Personne enregistrée.');
        }

        $this->resetInputFields();
    }



    public function resetInputFields()
        {
            $this->nom = '';
            $this->telephone = '';
            $this->role = '';
            $this->code = '';
        }

    public function edit($id)
    {
        $personne = Personnes::findOrFail($id);

        $this->personneId = $personne->id;
        $this->nom = $personne->nom;
        $this->telephone = $personne->telephone;
        $this->code = $personne->code;
        $this->role = $personne->role;

        $this->isEditing = true;
    }

    public function editinline($id)
    {
        $personne = Personnes::findOrFail($id);
        $this->editId = $id;
        $this->editCode = $personne->code;
        $this->editNom = $personne->nom;
        $this->editTelephone = $personne->telephone;
        $this->editRole = $personne->role;
    }

    public function updateinline()
    {
        // Vérifier si un autre utilisateur a déjà ce code
        $existe = Personnes::where('code', $this->editCode)
            ->where('id', '!=', $this->editId)
            ->exists();

        if ($existe) {
            $this->addError('editCode', 'Ce code est déjà attribué.');
            return;
        }

        // Mise à jour
        $personne = Personnes::findOrFail($this->editId);
        $personne->update([
            'code' => $this->editCode,
            'nom' => $this->editNom,
            'telephone' => $this->editTelephone,
            'role' => $this->editRole,
        ]);

        // Réinitialiser les champs d'édition
        $this->reset(['editId', 'editCode', 'editNom', 'editTelephone', 'editRole']);
    }


    public function test()
    {
        dd('Livewire fonctionne !');
    }


    public function delete($id)
    {
        Personnes::destroy($id);
    }

    public function resetInput()
    {
        $this->reset(['editingId', 'code', 'nom', 'telephone', 'role']);
    }

    public function render()
    {
        return view('livewire.personne-manager', [
            'personnes' => Personnes::orderBy('code')->get(),
        ]);
    }

}
