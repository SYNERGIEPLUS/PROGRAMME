<div class="p-6 space-y-4">
    <h2 class="text-xl font-bold">Gestion des personnes (X1 à X10)</h2>

    <div key="{{ $personneId ?? 'new' }}" class="grid grid-cols-2 gap-4">
        <select class="border rounded px-3 py-2" wire:model="code">
            <option value="" disabled>-- Choisissez un rôle --</option>
            @for ($i = 1; $i <= 12; $i++)
                <option value="X{{ $i }}">X{{ $i }}</option>
            @endfor
            <option value="Absent">Absent</option>
        </select>
        <input type="text" id="nom" wire:model="nom" placeholder="Nom" class="border rounded px-3 py-2">
        <input type="text" wire:model="telephone" placeholder="Téléphone" class="border rounded px-3 py-2">
        <input type="text" wire:model="role" placeholder="Role ou service" class="border rounded px-3 py-2">
        @if ($isEditing)
            <div class="text-sm text-yellow-600">Mode édition de la personne {{ $nom }}</div>
        @endif
        @error('code')
            <span class="text-red-600 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <div class="flex items-center gap-4 mt-4">
            <button wire:click="save" class="bg-blue-600 text-white px-4 py-2 rounded">
                {{ $isEditing ? 'Modifier' : 'Enregistrer' }}
            </button>

            <button onclick="location.reload()"
                class="flex items-center gap-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded shadow-sm">
                🔄 Actualiser
            </button>
        </div>
    </div>

    <table class="w-full mt-4 border-collapse">
        <thead class="bg-gray-200">
            <tr>
                <th class="border px-4 py-2">Code</th>
                <th class="border px-4 py-2">Nom</th>
                <th class="border px-4 py-2">Téléphone</th>
                <th class="border px-4 py-2">Role</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($personnes as $personne)
                <tr>
                    <td class="border px-4 py-2">
                        @if($editId === $personne->id)
                            <select wire:model="editCode" class="w-full border rounded px-2 py-1">
                                <option value="">-- Choisir un code --</option>
                               
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="X{{ $i }}">X{{ $i }}</option>
                                @endfor
                                    <option value="Absent">Absent</option>
                            </select>
                            @error('editCode')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror

                        @else
                            {{ $personne->code }}
                        @endif
                    </td>

                    <td class="border px-4 py-2">
                        @if($editId === $personne->id)
                            <input type="text" wire:model="editNom" class="w-full border rounded px-2 py-1">
                        @else
                            {{ $personne->nom }}
                        @endif
                    </td>
                    <td class="border px-4 py-2">
                        @if($editId === $personne->id)
                            <input type="text" wire:model="editTelephone" class="w-full border rounded px-2 py-1">
                        @else
                            {{ $personne->telephone }}
                        @endif
                    </td>
                    <td class="border px-4 py-2">
                        @if($editId === $personne->id)
                            <input type="text" wire:model="editRole" class="w-full border rounded px-2 py-1">
                        @else
                            {{ $personne->role }}
                        @endif
                    </td>
                    <td class="border px-4 py-2 text-right">
                        @if($editId === $personne->id)
                            <button wire:click="updateinline" class="text-green-600 hover:underline hidden">Enregistrer</button>
                            <button wire:click="$set('editId', null)" class="text-gray-600 hover:underline ml-2 hidden">Annuler</button>
                            <button wire:click="$set('editId', null)" class="text-gray-600 hover:underline ml-2">Annuler</button>
                            <button wire:click="updateinline" class="text-green-600 hover:underline">Enregistrer</button>

                        @else
                            <button wire:click="editinline({{ $personne->id }})" class="text-blue-600 hover:underline">Modifier</button>
                            <button wire:click="delete({{ $personne->id }})" class="text-red-600 hover:underline ml-2">Supprimer</button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
</div>
