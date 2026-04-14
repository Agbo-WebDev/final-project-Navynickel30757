<?php
namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ListingController extends Controller
{
    public function index() {
        $listings = Listing::where('status', 'available')->get();
        return view('closet.index', compact('listings'));
    }


    public function store(Request $request) {
        $request->validate(['title' => 'required|max:50',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048']);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('listings', 'public');
        }

        Listing::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::id(),
            'status' => 'available',
            'image' => $imagePath
        ]);

        return back()->with('success', 'Item posted!');
    }

    public function manage() {
        $myListings = Listing::where('user_id', Auth::id())
            ->with(['requests.borrower'])
            ->latest()
            ->get();

        return view('lend.index', compact('myListings'));
    }

    public function update(Request $request, $id)
    {
        $listing = Listing::findOrFail($id);

        if ($listing->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|max:50',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $listing->title = $request->title;
        $listing->description = $request->description;

        if ($request->hasFile('image')) {
            if($listing->image){
                Storage::disk('public')->delete($listing->image);
            }
            $listing->image = $request->file('image')->store('listings', 'public');
        }

        $listing->save();

        return back()->with('success', 'Item updated successfully!');
    }

    public function destroy($id) {
        $listing = Listing::findOrFail($id);

        if ($listing->user_id !== Auth::id()) { abort(403); }

        if($listing->image){
            Storage::disk('public')->delete($listing->image);
        }

        $listing->delete();

        return back()->with('success', 'Item deleted successfully.');
    }
}
