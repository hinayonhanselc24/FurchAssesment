<?php

namespace App\Http\Controllers;

use App\Models\Webinar;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class WebinarController extends Controller
{
    // Display all webinars
    public function index()
    {
        $webinars = Webinar::all();
        return view('webinars.index', compact('webinars'));
    }

    // Show the form to create a new webinar
    public function create()
    {
        return view('webinars.create');
    }

    // Store a new webinar
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'event' => 'required|date',
        ]);

        Webinar::create($request->all());

        return redirect()->route('webinars.index')->with('success', 'Webinar created successfully.');
    }


    // Show the form to edit an existing webinar
    public function edit(Webinar $webinar)
    {
        return view('webinars.edit', compact('webinar'));
    }

    // Update an existing webinar
    public function update(Request $request, Webinar $webinar)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $webinar->update($request->all());

        // Optionally, update the webinar via GoToWebinar API
        $this->updateGotoWebinar($webinar);

        return redirect()->route('webinars.index');
    }

    // Delete a webinar
    public function destroy(Webinar $webinar)
    {
        $webinar->delete();

        // Optionally, delete the webinar via GoToWebinar API
        $this->deleteGotoWebinar($webinar);

        return redirect()->route('webinars.index');
    }

    // Interact with GoToWebinar API to create a webinar
    public function createGotoWebinar($id)
    {
        $webinar = Webinar::findOrFail($id);

        $client = new Client();
        $url = 'https://api.getgo.com/G2W/rest/v2/organizers/' . env('GOTOWEBINAR_ORGANIZER_KEY') . '/webinars';

        try {
            $response = $client->post($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('GOTOWEBINAR_ACCESS_TOKEN'),
                    'Content-Type'  => 'application/json',
                ],
                'json' => [
                    'subject'       => $webinar->name,
                    'description'   => $webinar->description,
                    'times'         => [[
                        'startTime' => $webinar->event,
                        'endTime'   => date('Y-m-d\TH:i:s', strtotime($webinar->event . ' +1 hour'))
                    ]],
                    'timeZone'      => 'UTC',
                ],
            ]);

            $responseData = json_decode($response->getBody(), true);

            // Save GoToWebinar ID for future reference
            $webinar->goto_webinar_id = $responseData['webinarKey'];
            $webinar->save();

            return redirect()->route('webinars.index')->with('success', 'Webinar successfully created in GoToWebinar!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create webinar in GoToWebinar: ' . $e->getMessage());
        }
    }

    public function getGotoWebinar($id)
    {
        // Find the webinar in your database
        $webinar = Webinar::findOrFail($id);

        // Check if the webinar has already been created in GoToWebinar
        if (!$webinar->goto_webinar_id) {
            return redirect()->route('webinars.index')->with('error', 'This webinar has not been created in GoToWebinar yet.');
        }

        // Fetch data from GoToWebinar API (example using Guzzle HTTP client)
        $client = new Client();
        $response = $client->get('https://api.getgo.com/G2W/api/organizers/' . $webinar->goto_webinar_id . '/webinars');

        // Decode the response to get the data
        $webinarData = json_decode($response->getBody()->getContents(), true);

        // Pass the data to a view to display it
        return view('webinars.goto_webinar', compact('webinar', 'webinarData'));
    }

    public function getAllGotoWebinars()
    {
        // Create a new Guzzle client
        $client = new Client();

        // Replace 'your_api_key' with the correct API key or OAuth token
        $response = $client->get('https://api.getgo.com/G2W/api/organizers/aa31d961-6dc9-4c6e-94d3-341768ce5ebb/webinars');

        // Decode the JSON response from the GoToWebinar API
        $webinars = json_decode($response->getBody()->getContents(), true);

        // Check if webinars are returned, if not show an error
        if (empty($webinars)) {
            return redirect()->route('webinars.index')->with('error', 'No webinars found in GoToWebinar.');
        }

        // Pass the webinars data to a view
        return view('webinars.all_goto_webinars', compact('webinars'));
    }

    // Update a webinar via GoToWebinar API
    protected function updateGotoWebinar($webinar)
    {
        // You can add similar logic to update webinar details on GoToWebinar.
    }

    // Delete a webinar via GoToWebinar API
    protected function deleteGotoWebinar($webinar)
    {
        // Implement logic to delete a webinar from GoToWebinar API
    }
}
