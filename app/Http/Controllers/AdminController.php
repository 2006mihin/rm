<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;

class AdminController extends Controller
{
    public function index()
    {
        // Counts
        $totalUsers = User::count(); // counts all users
        $totalCustomers = User::where('role', 'customer')->count();
        $totalAdmins = User::where('role', 'admin')->count();

        $totalProducts = Product::count();
        $totalOrders = Order::count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalCustomers',
            'totalAdmins',
            'totalProducts',
            'totalOrders'
        ));
    }

    public function products()
    {
        return view('admin.products');
    }

    public function orders()
    {
        return view('admin.orders');
    }
}
