<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Affiche tous les utilisateurs sauf celui connecté et exclut les super admins pour les admins
    public function index()
    {
        // Récupérer tous les utilisateurs sauf l'utilisateur connecté et exclure les super admins pour les admins
        $users = User::where('id', '!=', Auth::id())
                     ->when(Auth::user()->role === 'ROLE_ADMIN', function ($query) {
                         return $query->where('role', '!=', 'ROLE_SUPER_ADMIN');
                     })
                     ->get();
    
        return view('users.index', compact('users'));
    }

    // Affiche le formulaire de modification d'un utilisateur
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $currentUser = Auth::user();

        // Vérifie si l'utilisateur est un admin et essaie de modifier un super admin
        if ($currentUser->role === 'ROLE_ADMIN' && $user->role === 'ROLE_SUPER_ADMIN') {
            return redirect()->route('users.index')->with('error', 'Les administrateurs ne peuvent pas modifier un super admin.');
        }

        return view('users.edit', compact('user'));
    }

    // Met à jour le profil d'un utilisateur (nom et email)
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
        ]);

        $user = User::findOrFail($id);
        $currentUser = Auth::user();

        // Vérifie si l'utilisateur est un admin et essaie de mettre à jour un super admin
        if ($currentUser->role === 'ROLE_ADMIN' && $user->role === 'ROLE_SUPER_ADMIN') {
            return redirect()->route('users.index')->with('error', 'Les administrateurs ne peuvent pas mettre à jour un super admin.');
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            // Si c'est un super admin, on ne change pas son rôle sans une validation préalable
            'role' => $request->role ?? $user->role, 
        ]);

        return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    // Supprime un utilisateur
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $currentUser = Auth::user();

        // Empêche les admins de supprimer un super admin
        if ($user->role === 'ROLE_SUPER_ADMIN') {
            return redirect()->route('users.index')->with('error', 'Les administrateurs ne peuvent pas supprimer un super admin.');
        }

        // On ne peut pas supprimer l'utilisateur connecté
        if ($user->id === Auth::id()) {
            return redirect()->route('users.index')->with('error', 'Vous ne pouvez pas vous supprimer.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé avec succès.');
    }
}
