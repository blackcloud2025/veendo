@extends('layout')

@section('Titulo','profile.')

@section('styles')
    @vite('resources/css/profile.css')
@endsection

@section('Contenido')
<title>Mi Perfil</title>
<div class="container">
        <!-- Cabecera del Perfil -->
        <div class="card">
            <div class="profile-header">
                <div class="profile-info">
                    <h1>{{ $user->name }}</h1>
                    <p>{{ $user->email }}</p>
                    <span class="badge">{{ ucfirst($user->role) }}</span>
                </div>
            </div>
        </div>

        <!-- Contenido Principal -->
        <div class="card">
            <div class="tabs">
                <button class="tab-button active" data-tab="profile">Información del Perfil</button>
                <button class="tab-button" data-tab="edit">Editar Perfil</button>
            </div>

            <!-- Vista de Información -->
            <div id="profile-tab" class="tab-content active">
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Nombre Completo</div>
                        <div class="info-value">{{ $user->name }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Correo Electrónico</div>
                        <div class="info-value">{{ $user->email }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Rol</div>
                        <div class="info-value">{{ ucfirst($user->role) }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Miembro desde</div>
                        <div class="info-value">{{ $user->created_at->format('d/m/Y') }}</div>
                    </div>
                </div>
            </div>

             <!-- Formulario de Edición -->
             <div id="edit-tab" class="tab-content">
                <form action="{{ route('miperfil.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label class="form-label" for="name">Nombre</label>
                        <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $user->name) }}">
                        @error('name')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="email">Correo Electrónico</label>
                        <input type="email" id="email" name="email" class="form-input" value="{{ old('email', $user->email) }}">
                        @error('email')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="role">Rol</label>
                        <select id="role" name="role" class="form-input">
                            <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>Usuario</option>
                            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Administrador</option>
                        </select>
                        @error('role')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password">Nueva Contraseña</label>
                        <input type="password" id="password" name="password" class="form-input">
                        <p class="info-label">Dejar en blanco para mantener la contraseña actual</p>
                        @error('password')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password_confirmation">Confirmar Nueva Contraseña</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-input">
                    </div>

                    <div style="text-align: right;">
                        <button type="submit" class="button button-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>

            <!-- Zona de Peligro -->
            <div class="danger-zone">
                <h3>Zona de Peligro</h3>
                <div class="danger-box">
                    <div class="danger-box-text">
                        <h4>Eliminar Cuenta</h4>
                        <p>Una vez que elimines tu cuenta, no hay vuelta atrás. Por favor, estás seguro.</p>
                    </div>
                    <form action="{{ route('miperfil.destroy', $user) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="button button-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar tu cuenta?')">
                            Eliminar Cuenta
                        </button>
                    </form>
                </div>
            </div>
        </div>

        
    </div>
@endsection

@section('scripts')
    @vite('resources/js/profile.js')
@endsection