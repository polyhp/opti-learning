<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Affiche le contenu du panier.
     */
    public function index()
    {
        $cartIds = session('cart', []);
        
        $courses = [];
        if (!empty($cartIds)) {
            $courses = Course::whereIn('id', $cartIds)->with('formateur.user', 'category')->get();
        }
        
        $total = collect($courses)->sum('price');
        
        return view('cart.index', compact('courses', 'total'));
    }

    /**
     * Ajoute une formation au panier.
     */
    public function add(Request $request, Course $course)
    {
        $cart = session('cart', []);
        
        if (!in_array($course->id, $cart)) {
            $cart[] = $course->id;
            session(['cart' => $cart]);
            $message = 'Formation ajoutée au panier avec succès.';
            $status = 'success';
        } else {
            $message = 'Cette formation est déjà dans votre panier.';
            $status = 'info';
        }
        
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'cart_count' => count($cart),
                'message' => $message
            ]);
        }

        return redirect()->back()->with($status, $message);
    }

    /**
     * Retire une formation du panier.
     */
    public function remove(Request $request, Course $course)
    {
        $cart = session('cart', []);
        
        if (($key = array_search($course->id, $cart)) !== false) {
            unset($cart[$key]);
            session(['cart' => array_values($cart)]);
        }
        
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'cart_count' => count(session('cart', [])),
                'message' => 'Formation retirée du panier.'
            ]);
        }

        return redirect()->route('cart.index', [], 303)->with('success', 'Formation retirée du panier.');
    }
}
