<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::all();
        return view('contacts.index', compact('contacts'));
    }

    public function form($id = null)
    {
        $contact = $id ? Contact::findOrFail($id) : null;
        return view('contacts.form', compact('contact'));
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required',
    ]);

    $formattedPhone =$request->phone;

    Contact::create([
        'name' => $request->name,
        'phone' => $formattedPhone,
    ]);

    return response()->json(['message' => 'Contact created']);
}

    public function edit($id)
    {
        return response()->json(Contact::findOrFail($id));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required',
    ]);

    $contact = Contact::findOrFail($id);
    $formattedPhone = $request->phone;

    $contact->update([
        'name' => $request->name,
        'phone' => $formattedPhone,
    ]);

    return response()->json(['success' => true]);
}

    public function destroy($id)
    {
        Contact::destroy($id);
        return response()->json(['message' => 'Contact deleted']);
    }

    public function importXml(Request $request)
    {
        $request->validate([
            'xml_file' => 'required|file',
        ]);

        try {
            $xmlString = file_get_contents($request->file('xml_file')->getRealPath());
            $xml = simplexml_load_string($xmlString, "SimpleXMLElement", LIBXML_NOCDATA);

            if (!$xml) {
                return back()->withErrors(['xml_file' => 'Invalid XML format.']);
            }

            $contactsArray = json_decode(json_encode($xml), true);
            $entries = $contactsArray['contact'] ?? [];

            if (isset($entries['name'])) {
                $entries = [$entries]; // wrap single entry
            }

            foreach ($entries as $entry) {
                Contact::create([
                    'name' => $entry['name'] ?? 'Unknown',
                    'phone' => $entry['phone'] ?? '',
                ]);
            }

            return redirect()->route('contacts.index')->with('success', 'Contacts imported successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['xml_file' => 'Import failed: ' . $e->getMessage()]);
        }
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');

        if (!empty($ids)) {
            Contact::whereIn('id', $ids)->delete();
            return response()->json(['message' => 'Contacts deleted']);
        }

        return response()->json(['error' => 'No contact IDs provided.'], 400);
    }
}
