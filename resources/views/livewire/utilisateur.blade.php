<div class="bg-white p-4 rounded shadow">

    <!-- Notifications -->
    <x:notify-messages />

    <h3 class="text-lg font-semibold mb-4">Gestion des utilisateurs</h3>

        @if($showConfirmationModalUser)
            <div class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50 z-50">
                <div class="bg-white p-6 rounded shadow-md">
                    <h3 class="text-lg font-semibold">Confirmer la suppression</h3>
                    <p>Êtes-vous sûr de vouloir supprimer cet utilisateur ?</p>
                    <div class="mt-4 flex justify-end space-x-4">
                        <button wire:click="$set('showConfirmationModalUser', false)" class="bg-gray-300 text-gray-800 px-4 py-2 rounded">Annuler</button>
                        <button wire:click="delete" class="bg-red-500 text-white px-4 py-2 rounded">Confirmer</button>
                    </div>
                </div>
            </div>
        @endif

        @if($showModalPermiss)
            <!-- Bouton Permissions -->
            <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white p-6 rounded shadow-md w-full max-w-md">
                    <h2 class="text-xl font-bold mb-4">Gérer les permissions</h2>
                    @foreach($permissions as $key => $value)
                        <div class="flex items-center mb-2">
                            <input type="checkbox" wire:model="permissions.{{ $key }}" class="mr-2">
                            <label>{{ ucfirst(str_replace('_', ' ', $key)) }}</label>
                        </div>
                    @endforeach
                    <div class="mt-4 flex justify-end space-x-2">
                        <button wire:click="$set('showModalPermiss', false)" class="px-4 py-2 bg-gray-300 rounded">Annuler</button>
                        <button wire:click="save" class="px-4 py-2 bg-blue-600 text-white rounded">Enregistrer</button>
                    </div>
                </div>
            </div>
        @endif

        <div class="space-y-4">
            <!-- Table à gauche -->
            <div class="table-auto w-full border border-gray-300 rounded-md shadow-sm">
                <table class="table-auto w-full">
                    <thead>
                        <tr class="bg-gray-600 text-white text-left">
                            <th class="px-4 py-3 border-b">Nom</th>
                            <th class="px-4 py-3 border-b">Email</th>
                            <th class="px-4 py-3 border-b">Type</th>
                            <th class="px-4 py-3 border-b">Creer le</th>
                            <th class="px-4 py-3 border-b">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($utilisateur ?? [] as $users)
                            <tr class="hover:bg-gray-100">
                                <td class="px-4 py-3 border-b">{{ $users->name }}</td>
                                <td class="px-4 py-3 border-b">{{ $users->email }}</td>
                                <td class="px-4 py-3 border-b">
                                    @if($users->type == 'admin')
                                        <span class="bg-green-500 text-white px-2 py-1 rounded">Admin</span>
                                    @else
                                        <span class="bg-blue-500 text-white px-2 py-1 rounded">Utilisateur</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 border-b">{{ $users->created_at }}</td>
                                <td class="px-4 py-3 border-b space-y-2">
                                    <!-- Bouton Supprimer -->
                                    <div class="flex space-x-2">
                                        <!-- Bouton Supprimer -->
                                        <button wire:click="confirmDelete({{ $users->id }})"
                                            class="flex items-center bg-red-500 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded shadow text-sm">
                                            <i class="fas fa-trash-alt mr-2"></i>
                                            Supprimer
                                        </button>

                                        @if($users->type == 'user')
                                            <button wire:click="managePermission({{ $users->id }})"
                                                class="flex items-center bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow text-sm">
                                                <i class="fas fa-user-shield mr-2"></i>
                                                Permission
                                            </button>
                                        @endif
                                        
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

</div>
