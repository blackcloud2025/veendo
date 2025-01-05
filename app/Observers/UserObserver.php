<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        //
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //borra los productos de usuarios borrados
        
        // Obtener todos los productos del usuario
        $products = Product::where('user_id', $user->id)->get();

        foreach ($products as $product) {
            // Eliminar imágenes
            foreach ($product->images as $image) {
                Storage::disk('public\poduct_images')->delete($image->image_path);
                $image->delete();
            }
            
            // Eliminar producto
            $product->delete();
        }
    }
   
}


