<?php

namespace App\Http\Controllers;

use App\Models\BorrowRequest;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowRequestController extends Controller
{

    public function store(Request $request, $listingId) {
        BorrowRequest::create([
            'listing_id' => $listingId,
            'borrower_id' => Auth::id(),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'requested'
        ]);

        return redirect('/closet')->with('success', 'Request sent to the owner!');
    }

    public function destroy($id)
    {
        $request = BorrowRequest::findOrFail($id);

        if ($request->borrower_id !== Auth::id() || $request->status !== 'requested') {
            abort(403, 'You cannot cancel this request.');
        }

        $request->delete();

        return back()->with('success', 'Request cancelled.');
    }

    public function index() {
        $requests = BorrowRequest::where('borrower_id', Auth::id())
            ->with('listing')
            ->latest()
            ->get();

        return view('lend.index', compact('requests'));
    }

    public function approve($id) {
        $borrowRequest = BorrowRequest::findOrFail($id);

        $borrowRequest->update(['status' => 'approved']);

        $borrowRequest->listing->update(['status' => 'borrowed']);

        return back()->with('success', 'You have approved the request!');
    }

    public function reject($id) {

        $request = \App\Models\BorrowRequest::findOrFail($id);

        $request->update(['status' => 'rejected']);

        return back()->with('success', 'Request declined.');
    }

    public function return($id) {

        $request = BorrowRequest::findOrFail($id);

        if ($request->listing->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->update(['status' => 'returned']);
        $request->listing->update(['status' => 'available']);

        return back()->with('success', 'Item returned!');
    }

    public function requests()
    {
        $requests = BorrowRequest::where('borrower_id', Auth::id())
            ->with(['listing.owner'])
            ->get();

        return view('borrow.index', compact('requests'));
    }
}
