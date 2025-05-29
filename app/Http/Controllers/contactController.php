<?php

namespace App\Http\Controllers;

use App\Models\tbl_contact;
use Illuminate\Http\Request;

class contactController extends Controller
{
    public function index(){
        $count = 0 ; 
        $contacts = tbl_contact::all();
        return view('admin.contact', compact('contacts' ,'count'));

    }
    public function create(){
        return view('page.contact');
    }
    public function store(Request $request){
       

         $contact = tbl_contact::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'message'=>$request->message,

         ]);
         return redirect()->back()->with('success', 'sent successfully!');
    }
    public function view($id){
        $contact = tbl_contact::findOrFail($id);
        return view('admin.show-contact', compact('contact'));
    }
   public function delete($id){
    $contact = tbl_contact::findOrFail($id);
    $contact->delete();
    return redirect()->back()->with('success', 'Deleted successfully!');
   }

}
