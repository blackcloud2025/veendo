@extends('layout')

@section('Titulo','profile.')

@section('styles')
@vite('resources/css/profile.css')
@endsection

@section('Contenido')



    <div class="containerprf">
        <h1>Perfil de Usuario</h1>
        
        <div class="grid">
            <!-- Información del Usuario -->
            <div class="card">
                <div class="card-header">
                    <h2>Información del Usuario</h2>
                </div>
                <div class="card-content">
                    <div class="user-info">
                        <div class="avatar">
                            <img src="/placeholder.svg" alt="Juan Pérez" />
                        </div>
                        <div>
                            <p class="user-name">Juan Pérez</p>
                            <p class="user-email">juan@example.com</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cambio de Contraseña -->
            <div class="card">
                <div class="card-header">
                    <h2>Cambiar Contraseña</h2>
                </div>
                <div class="card-content">
                    <form id="password-form">
                        <div class="form-group">
                            <label for="new-password">Nueva Contraseña</label>
                            <input type="password" id="new-password" required>
                        </div>
                        <div class="form-group">
                            <label for="confirm-password">Confirmar Contraseña</label>
                            <input type="password" id="confirm-password" required>
                        </div>
                        <button type="submit" class="btn">Cambiar Contraseña</button>
                    </form>
                </div>
            </div>

            <!-- Eliminación de Perfil -->
            <div class="card span-2">
                <div class="card-header">
                    <h2>Eliminar Perfil</h2>
                    <p style="color: var(--text-color);">Esta acción es irreversible. Por favor, asegúrate de que realmente quieres eliminar tu perfil.</p>
                </div>
                <div class="card-footer">
                    <button class="btn btn-danger" id="delete-profile">Eliminar Perfil</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación -->
    <div class="modal" id="confirm-modal">
        <div class="modal-content">
            <h2>¿Estás absolutamente seguro?</h2>
            <p>Esta acción no se puede deshacer. Esto eliminará permanentemente tu cuenta y removerá tus datos de nuestros servidores.</p>
            <div class="modal-actions">
                <button class="btn" id="cancel-delete">Cancelar</button>
                <button class="btn btn-danger" id="confirm-delete">Sí, eliminar mi cuenta</button>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    @vite('resources/js/profile.js')
@endsection