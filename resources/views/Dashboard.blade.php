@extends('layout')

@section('titulo', 'Dashboard')

@section('styles')
    @vite('resources/css/dashboard.css')
@endsection

@section('Contenido')
<div class="container">
    <h1 class="mb-4">Dashboard Administrativo</h1>
    
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    Gestión de Usuarios
                </div>
                <div class="card-body">
                    @if(isset($users) && $users->count() > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Rol</th>
                                    <th>Productos</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ ucfirst($user->role) }}</td>
                                    <td>{{ $user->userProducts->count() }}</td>
                                    <td>
                                        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-primary">Editar</a>
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario y todos sus productos?')">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No hay usuarios para mostrar.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

