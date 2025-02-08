<x-app-layout>
    <h1>Modifier l'utilisateur {{ $user->name }}</h1>

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nom</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>

        @if(Auth::user()->role === 'ROLE_SUPER_ADMIN')
            <div class="form-group">
                <label for="role">Rôle</label>
                <select name="role" class="form-control">
                    <option value="ROLE_USER" {{ $user->role == 'ROLE_USER' ? 'selected' : '' }}>Utilisateur</option>
                    <option value="ROLE_ADMIN" {{ $user->role == 'ROLE_ADMIN' ? 'selected' : '' }}>Administrateur</option>
                    <option value="ROLE_SUPER_ADMIN" {{ $user->role == 'ROLE_SUPER_ADMIN' ? 'selected' : '' }}>Super Admin</option>
                </select>
            </div>
        @endif

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</x-app-layout>
