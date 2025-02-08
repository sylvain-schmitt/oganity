<x-app-layout>
<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Utilisateurs') }}
        </h2>
    </x-slot>
    <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Liste des utilisateurs</h1>
    <table class="table">
        <thead>
            <tr class="p-6 text-gray-900 dark:text-gray-100">
                <th>Nom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr class="p-6 text-gray-900 dark:text-gray-100">
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if ($user->role === 'ROLE_USER')
                            Utilisateur
                        @elseif ($user->role === 'ROLE_ADMIN')
                            Administrateur
                        @elseif ($user->role === 'ROLE_SUPER_ADMIN')
                            Super Admin
                        @endif
                    </td>
                    <td>
                        {{-- Vérification du rôle de l'utilisateur connecté --}}
                        @if(Auth::user()->role === 'ROLE_SUPER_ADMIN')
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Modifier</a>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                        @elseif(Auth::user()->role === 'ROLE_ADMIN' && $user->role !== 'ROLE_SUPER_ADMIN')
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Modifier</a>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-app-layout>
