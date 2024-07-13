package com.example.eventsfinder;

import androidx.appcompat.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.util.Log;

import com.android.volley.RequestQueue;
import com.android.volley.toolbox.Volley;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.SupportMapFragment;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.MarkerOptions;
import com.google.gson.Gson;
import java.util.Vector;

public class MapsActivity extends AppCompatActivity implements OnMapReadyCallback {

    private GoogleMap mMap;
    Vector<MarkerOptions> markerOptions;
    private String URL = "https://fd5a-202-58-91-32.ngrok-free.app/EventsFinder/all.php";
    RequestQueue requestQueue;
    Gson gson;
    Events[] events;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_maps);

        SupportMapFragment mapFragment = (SupportMapFragment) getSupportFragmentManager()
                .findFragmentById(R.id.map);
        if (mapFragment != null) {
            mapFragment.getMapAsync(this);
        }

        requestQueue = Volley.newRequestQueue(this);
        gson = new Gson();
        markerOptions = new Vector<>();

        fetchEvents();
    }

    @Override
    public void onMapReady(GoogleMap googleMap) {
        mMap = googleMap;

        View customView = getLayoutInflater().inflate(R.layout.custom_info_contents, null);
        CustomInfoWindowAdapter adapter = new CustomInfoWindowAdapter(customView);
        mMap.setInfoWindowAdapter(adapter);

        // Add markers if they were fetched before the map was ready
        if (!markerOptions.isEmpty()) {
            for (MarkerOptions markerOption : markerOptions) {
                mMap.addMarker(markerOption);
            }
            LatLng firstEventLocation = markerOptions.get(0).getPosition();
            mMap.moveCamera(CameraUpdateFactory.newLatLngZoom(firstEventLocation, 10));
        }
    }

    private void fetchEvents() {
        StringRequest stringRequest = new StringRequest(URL, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                events = gson.fromJson(response, Events[].class);
                for (Events event : events) {
                    Log.d("Event", "Name: " + event.getEvent_name() + ", Lat: " + event.getLatitude() + ", Lng: " + event.getLongitude());
                    LatLng eventLocation = new LatLng(event.getLatitude(), event.getLongitude());
                    String title = event.getEvent_name();
                    String snippet = "Date: " + event.getSchedule_date() + "\nTime: " + event.getSchedule_time();
                    markerOptions.add(new MarkerOptions().position(eventLocation).title(title).snippet(snippet));
                }
                if (mMap != null) {
                    for (MarkerOptions markerOption : markerOptions) {
                        mMap.addMarker(markerOption);
                    }
                    if (!markerOptions.isEmpty()) {
                        LatLng firstEventLocation = markerOptions.get(0).getPosition();
                        mMap.moveCamera(CameraUpdateFactory.newLatLngZoom(firstEventLocation, 10));
                    }
                }
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                // Handle the error
                error.printStackTrace();
            }
        });

        requestQueue.add(stringRequest);
    }
}

class Event {
    private double latitude;
    private double longitude;
    private String event_name;
    private String schedule_date;
    private String schedule_time;

    public double getLatitude() {
        return latitude;
    }

    public double getLongitude() {
        return longitude;
    }

    public String getEvent_name() {
        return event_name;
    }

    public String getSchedule_date() {
        return schedule_date;
    }

    public String getSchedule_time() {
        return schedule_time;
    }
}

