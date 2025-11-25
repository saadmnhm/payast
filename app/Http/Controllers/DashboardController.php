<?php

namespace App\Http\Controllers;

use \App\Models\Contact;
use \App\Models\Piece;
class DashboardController extends Controller
{
    public function index()
    {
        $recentContacts = Contact::orderBy('created_at', 'desc')
            ->take(7)
            ->get();

        $totalContacts = Contact::count();
        $totalpieces = Piece::count(); 

        return view('admin.dashboards.index', compact('recentContacts', 'totalContacts','totalpieces'));
    }   
}
