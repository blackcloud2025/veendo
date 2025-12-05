<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;

class OrdersController extends Controller
{
    /**
     * Display a listing of orders
     * - Users: ver sus propias órdenes
     * - Admin: ver todas las órdenes
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($this->isAdmin($user)) {
            // Admin ve todas las órdenes
            $orders = Order::with('user')->paginate(15);
        } else {
            // Usuario normal ve solo sus órdenes
            $orders = Order::where('user_id', $user->id)->paginate(15);
        }

        return view('orders.index', compact('orders'));
    }

    /**
     * Show a single order
     */
    public function show($id)
    {
        $order = Order::with('user')->findOrFail($id);

        // Verificar autorización
        if (!$this->canViewOrder($order)) {
            abort(403, 'No autorizado');
        }

        return view('orders.show', compact('order'));
    }

    /**
     * Show the edit form (solo admin)
     */
    public function edit($id)
    {
        $order = Order::findOrFail($id);

        // Solo admin puede editar
        if (!$this->isAdmin(Auth::user())) {
            abort(403, 'Solo administradores pueden editar órdenes');
        }

        $statuses = ['pendiente', 'procesando', 'completado', 'cancelado'];
        
        return view('orders.edit', compact('order', 'statuses'));
    }

    /**
     * Update order status (solo admin)
     */
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        // Solo admin puede editar
        if (!$this->isAdmin(Auth::user())) {
            abort(403, 'Solo administradores pueden editar órdenes');
        }

        $validated = $request->validate([
            'status' => 'required|in:pendiente,procesando,completado,cancelado',
        ]);

        $order->update($validated);

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Orden actualizada correctamente');
    }

    /**
     * Delete order (solo admin)
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        // Solo admin puede eliminar
        if (!$this->isAdmin(Auth::user())) {
            abort(403, 'Solo administradores pueden eliminar órdenes');
        }

        $order->delete();

        return redirect()->route('orders.index')
            ->with('success', 'Orden eliminada correctamente');
    }

    /**
     * Download PDF de la orden
     */
    public function downloadPdf($id)
    {
        $order = Order::findOrFail($id);

        // Verificar autorización
        if (!$this->canViewOrder($order)) {
            abort(403, 'No autorizado');
        }

        // Renderizar la vista
        $html = View::make('ticket-pdf', ['order' => $order])->render();

        // Generar PDF
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->stream('orden-' . $order->id . '.pdf');
    }

    /**
     * Verificar si el usuario es admin
     */
    private function isAdmin($user)
    {
        return $user && ($user->role === 'admin' || $user->role === 'administrator');
    }

    /**
     * Verificar si el usuario puede ver la orden
     */
    private function canViewOrder($order)
    {
        $user = Auth::user();
        
        if (!$user) {
            return false;
        }

        // Admin puede ver cualquier orden
        if ($this->isAdmin($user)) {
            return true;
        }

        // Usuario solo puede ver sus propias órdenes
        return $order->user_id === $user->id;
    }
}
