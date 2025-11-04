<?php

namespace App\Http\Controllers;

use \App\Models\Contact;
use \App\Models\BlogPost;

class DashboardController extends Controller
{
    public function index()
    {
        // Get the 7 most recent contacts
        $recentContacts = Contact::orderBy('created_at', 'desc')
            ->take(7)
            ->get();

        // Count total contacts and pending contacts
        $totalContacts = Contact::count();
        $totalArticles = BlogPost::count();

        return view('admin.dashboards.index', compact('recentContacts', 'totalContacts',  'totalArticles'));
    }
}
