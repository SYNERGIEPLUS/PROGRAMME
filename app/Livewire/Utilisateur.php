<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Permission;
use App\Models\Permission_user;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Gate;
// use Illuminate\Support\Facades\Hash;

class Utilisateur extends Component
{


    public $utilisateur, $name, $email, $adresse ;

    public $showConfirmationModalUser = false;
    public $userIdToDelete, $userId;

    public $showModalPermiss = false;

    public $permissions = [
        'utilisateur' => false,
    ];

    public function mount()
        {
            $this->utilisateur = User::all();
        }

    public function closeNotification()
    {
        session()->forget('message'); // Supprime le message de session
        session()->forget('error'); // Supprime l'erreur de session
    }

    public function confirmDelete($id)
    {
        $this->showConfirmationModalUser = true;
        $this->userIdToDelete = $id; // On stocke l'ID à supprimer
    }

    public function managePermission($id)
    {
        $this->userId = $id;

        $user = User::findOrFail($id);

        // Récupère les noms des permissions associées
        $userPermissions = $user->permissions->pluck('name')->toArray();

        // dd($userPermissions); // ← Ajoute ceci temporairement

        // Marque comme true les permissions que l'utilisateur a
        foreach ($userPermissions as $perm) {
            if (array_key_exists($perm, $this->permissions)) {
                $this->permissions[$perm] = true;
            }
        }
       // dd($this->permissions); 
        $this->showModalPermiss = true;
    }


    public function delete()
    {
            // Fermer le modal après la suppression
            $this->showConfirmationModalUser = false;

            if ($this->userIdToDelete) {
            // Supprimer la maison en utilisant l'ID
            User::find($userIdToDelete)->delete();
            session()->flash('success', 'utilisateur supprimé avec succès.');
            $this->utilisateur = User::all();
        }
        session()->flash('success', 'Maison supprimée avec succès.');
    }

    //Section gestion des permission
     public function show($id)
        {
            $this->userId = $id;
            $permission = Permission::firstOrCreate(['id' => $id]);
            $this->permissions = $permission->only(array_keys($this->permissions));
        }

    public function save()
    {
        $user = User::findOrFail($this->userId);

        // Supprimer toutes les permissions actuelles
        $user->permissions()->detach();

        // Récupérer les permissions activées
        $selectedPermissions = array_keys(array_filter($this->permissions));

        //dd($selectedPermissions);

        // Chercher les IDs des permissions sélectionnées
        $permissionIds = Permission::whereIn('name', $selectedPermissions)->pluck('id')->toArray();

        // Attacher les nouvelles permissions
        $user->permissions()->attach($permissionIds);

        $this->utilisateur = User::all();

        session()->flash('message', 'Permissions mises à jour avec succès.');
        $this->showModalPermiss = false;
    }

//Section gestion des permission

    public function render()
    {
        return view('livewire.utilisateur');
    }

}
