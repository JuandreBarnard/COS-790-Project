package com.cos790.internetofthings.restaurantbuddy;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Iterator;
import java.util.List;
import java.util.Map;
import java.util.Map.Entry;

import android.app.Activity;
import android.app.PendingIntent;
import android.content.Intent;
import android.location.Location;
import android.os.Bundle;
import android.os.StrictMode;
import android.support.v4.app.FragmentActivity;
import android.util.Log;
import android.view.View;
import android.widget.Toast;

import com.google.android.gms.common.ConnectionResult;
import com.google.android.gms.common.GooglePlayServicesClient;
import com.google.android.gms.common.GooglePlayServicesUtil;
import com.google.android.gms.location.LocationClient;
import com.google.android.gms.location.LocationListener;
import com.google.android.gms.location.LocationRequest;
import com.google.android.gms.maps.CameraUpdate;
import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.SupportMapFragment;
import com.google.android.gms.maps.model.BitmapDescriptorFactory;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.LatLngBounds;
import com.google.android.gms.maps.model.Marker;
import com.google.android.gms.maps.model.MarkerOptions;
import com.cos790.internetofthings.restaurantbuddy.LatLngInterpolator.LinearFixed;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

public class GPSActivity extends FragmentActivity implements GooglePlayServicesClient.ConnectionCallbacks,GooglePlayServicesClient.OnConnectionFailedListener,LocationListener{

    // Google Map
    private GoogleMap googleMap;
    private HashMap markersHashMap;
    private Iterator<Entry> iter;
    private CameraUpdate cu;
    private CustomMarker customMarkerOne, customMarkerTwo;
    String User_ID;
    String order_number;
    private static final String TAG_SUCCESS = "type";
    private static final String TAG_MESSAGE = "message";
    JSONParser jsonParser = new JSONParser();
    Location loc;

    private LocationClient locationclient;
    private LocationRequest locationrequest;
    private Intent mIntentService;
    private PendingIntent mPendingIntent;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_gps_activity);

        if (android.os.Build.VERSION.SDK_INT > 9) {
            StrictMode.ThreadPolicy policy = new StrictMode.ThreadPolicy.Builder().permitAll().build();
            StrictMode.setThreadPolicy(policy);
        }
        /* intent.putExtra(LoginActivity.ID, ID);
        intent.putExtra(ORDER_CODE, oc);*/
            Intent intent = getIntent();
         User_ID = intent.getStringExtra(LoginActivity.ID);
         order_number = intent.getStringExtra(TrackDeliveryActivity.ORDER_CODE);


        String success;

        try {
            List<NameValuePair> params = new ArrayList<NameValuePair>();
            params.add(new BasicNameValuePair("delivery_man_id", User_ID));
            params.add(new BasicNameValuePair("order_number", order_number));



            Log.d("request!", "starting");
            JSONObject json = jsonParser.makeHttpRequest(
                    ApplicationConstants.APP_SERVER_get_delivery_man_gps, "POST", params);

            success = json.getString(TAG_SUCCESS);
            if (success.equals("SUCCESS")) {

                JSONArray data = json.getJSONArray("data");
                JSONObject b = data.getJSONObject(0);
                Log.v("INFO", "got position");

                double lat =  Double.parseDouble(b.getString("lattitude"));
                double lon =  Double.parseDouble(b.getString("longitude"));
                customMarkerTwo = new CustomMarker("markerTwo",lat, lon);



            }else{
                Log.v("ERROR", json.getString(TAG_MESSAGE));
                Toast.makeText(GPSActivity.this, "Order number is incorrect", Toast.LENGTH_LONG).show();
                finish();
            }
        } catch (JSONException e) {
            Log.v("ERROR",e.toString());
        }

            int resp = GooglePlayServicesUtil.isGooglePlayServicesAvailable(this);
            if(resp == ConnectionResult.SUCCESS){
                locationclient = new LocationClient(this,this,this);
                locationclient.connect();
            }
            else{
                Toast.makeText(this, "Google Play Service Error " + resp, Toast.LENGTH_LONG).show();

            }
        try{
            // Loading map


        } catch (Exception e) {
            e.printStackTrace();
        }
    }
    private String TAG = this.getClass().getSimpleName();
    @Override
    protected void onDestroy() {
        super.onDestroy();
        if(locationclient!=null)
            locationclient.disconnect();
    }

    @Override
    public void onConnected(Bundle connectionHint) {
        Log.i(TAG, "onConnected");
        //txtConnectionStatus.setText("Connection Status : Connected");

        if(locationclient!=null && locationclient.isConnected()) {
            locationrequest = LocationRequest.create();
            locationrequest.setInterval(100);
            locationclient.requestLocationUpdates(locationrequest, this);
        }
    }

    @Override
    public void onDisconnected() {
        Log.i(TAG, "onDisconnected");
        //txtConnectionStatus.setText("Connection Status : Disconnected");

    }

    @Override
    public void onConnectionFailed(ConnectionResult result) {
        Log.i(TAG, "onConnectionFailed");
        //txtConnectionStatus.setText("Connection Status : Fail");

    }

    @Override
    public void onLocationChanged(Location location) {
        if(location!=null){
            Log.i(TAG, "Location Request :" + location.getLatitude() + "," + location.getLongitude());
            //txtLocationRequest.setText(location.getLatitude() + "," + location.getLongitude());
            loc =location;
            initilizeMap();
            initializeUiSettings();
            initializeMapLocationSettings();
            initializeMapTraffic();
            initializeMapType();
            initializeMapViewSettings();
        }

    }

    @Override
    protected void onResume() {
        super.onResume();
        // initilizeMap();
    }

    private void initilizeMap() {

        googleMap = ((SupportMapFragment) getSupportFragmentManager().findFragmentById(R.id.mapFragment)).getMap();

        // check if map is created successfully or not
        if (googleMap == null) {
            Toast.makeText(getApplicationContext(), "Sorry! unable to create maps", Toast.LENGTH_SHORT).show();
        }

        (findViewById(R.id.mapFragment)).getViewTreeObserver().addOnGlobalLayoutListener(
                new android.view.ViewTreeObserver.OnGlobalLayoutListener() {

                    @Override
                    public void onGlobalLayout() {
                        if (android.os.Build.VERSION.SDK_INT >= 16) {
                            (findViewById(R.id.mapFragment)).getViewTreeObserver().removeOnGlobalLayoutListener(this);
                        } else {
                            (findViewById(R.id.mapFragment)).getViewTreeObserver().removeGlobalOnLayoutListener(this);
                        }
                        setCustomMarkerOnePosition();
                        setCustomMarkerTwoPosition();
                    }
                });
    }

    void setCustomMarkerOnePosition() {
        if(locationclient!=null && locationclient.isConnected()) {


            customMarkerOne = new CustomMarker("markerOne", loc.getLatitude(), loc.getLongitude());
            addMarker(customMarkerOne);
        }
    }

    void setCustomMarkerTwoPosition() {
        //addMarker(customMarkerTwo);

    }

    public void startAnimation(View v) {
        //animateMarker(customMarkerOne, new LatLng(loc.getLatitude(), loc.getLongitude()));
    }

    public void zoomToMarkers(View v) {
        zoomAnimateLevelToFitMarkers(120);
    }

    public void animateBack(View v) {
        //animateMarker(customMarkerOne, new LatLng(loc.getLatitude(), loc.getLongitude()));
    }

    public void initializeUiSettings() {
        googleMap.getUiSettings().setCompassEnabled(true);
        googleMap.getUiSettings().setRotateGesturesEnabled(false);
        googleMap.getUiSettings().setTiltGesturesEnabled(true);
        googleMap.getUiSettings().setZoomControlsEnabled(true);
        googleMap.getUiSettings().setMyLocationButtonEnabled(true);
    }

    public void initializeMapLocationSettings() {
        googleMap.setMyLocationEnabled(true);
    }

    public void initializeMapTraffic() {
        googleMap.setTrafficEnabled(true);
    }

    public void initializeMapType() {
        googleMap.setMapType(GoogleMap.MAP_TYPE_NORMAL);
    }


    public void initializeMapViewSettings() {
        googleMap.setIndoorEnabled(true);
        googleMap.setBuildingsEnabled(false);
    }


    //this is method to help us set up a Marker that stores the Markers we want to plot on the map
    public void setUpMarkersHashMap() {
        if (markersHashMap == null) {
            markersHashMap = new HashMap();
        }
    }

    //this is method to help us add a Marker into the hashmap that stores the Markers
    public void addMarkerToHashMap(CustomMarker customMarker, Marker marker) {
        setUpMarkersHashMap();
        markersHashMap.put(customMarker, marker);
    }

    //this is method to help us find a Marker that is stored into the hashmap
    public Marker findMarker(CustomMarker customMarker) {
        iter = markersHashMap.entrySet().iterator();
        while (iter.hasNext()) {
            Map.Entry mEntry = (Map.Entry) iter.next();
            CustomMarker key = (CustomMarker) mEntry.getKey();
            if (customMarker.getCustomMarkerId().equals(key.getCustomMarkerId())) {
                Marker value = (Marker) mEntry.getValue();
                return value;
            }
        }
        return null;
    }


    //this is method to help us add a Marker to the map
    public void addMarker(CustomMarker customMarker) {
        MarkerOptions markerOption = new MarkerOptions().position(
                new LatLng(customMarker.getCustomMarkerLatitude(), customMarker.getCustomMarkerLongitude())).icon(
                BitmapDescriptorFactory.defaultMarker());

        Marker newMark = googleMap.addMarker(markerOption);
        addMarkerToHashMap(customMarker, newMark);
    }

    //this is method to help us remove a Marker
    public void removeMarker(CustomMarker customMarker) {
        if (markersHashMap != null) {
            if (findMarker(customMarker) != null) {
                findMarker(customMarker).remove();
                markersHashMap.remove(customMarker);
            }
        }
    }

    //this is method to help us fit the Markers into specific bounds for camera position
    public void zoomAnimateLevelToFitMarkers(int padding) {
        LatLngBounds.Builder b = new LatLngBounds.Builder();
        iter = markersHashMap.entrySet().iterator();

        while (iter.hasNext()) {
            Map.Entry mEntry = (Map.Entry) iter.next();
            CustomMarker key = (CustomMarker) mEntry.getKey();
            LatLng ll = new LatLng(key.getCustomMarkerLatitude(), key.getCustomMarkerLongitude());
            b.include(ll);
        }
        LatLngBounds bounds = b.build();

        // Change the padding as per needed
        cu = CameraUpdateFactory.newLatLngBounds(bounds, padding);
        googleMap.animateCamera(cu);
    }

    //this is method to help us move a Marker.
    public void moveMarker(CustomMarker customMarker, LatLng latlng) {
        if (findMarker(customMarker) != null) {
            findMarker(customMarker).setPosition(latlng);
            customMarker.setCustomMarkerLatitude(latlng.latitude);
            customMarker.setCustomMarkerLongitude(latlng.longitude);
        }
    }

    //this is method to animate the Marker. There are flavours for all Android versions
    public void animateMarker(CustomMarker customMarker, LatLng latlng) {
        if (findMarker(customMarker) != null) {

            LatLngInterpolator latlonInter = new LinearFixed();
            latlonInter.interpolate(20,
                    new LatLng(customMarker.getCustomMarkerLatitude(), customMarker.getCustomMarkerLongitude()), latlng);

            customMarker.setCustomMarkerLatitude(latlng.latitude);
            customMarker.setCustomMarkerLongitude(latlng.longitude);

            if (android.os.Build.VERSION.SDK_INT >= 14) {
                MarkerAnimation.animateMarkerToICS(findMarker(customMarker), new LatLng(customMarker.getCustomMarkerLatitude(),
                        customMarker.getCustomMarkerLongitude()), latlonInter);
            } else if (android.os.Build.VERSION.SDK_INT >= 11) {
                MarkerAnimation.animateMarkerToHC(findMarker(customMarker), new LatLng(customMarker.getCustomMarkerLatitude(),
                        customMarker.getCustomMarkerLongitude()), latlonInter);
            } else {
                MarkerAnimation.animateMarkerToGB(findMarker(customMarker), new LatLng(customMarker.getCustomMarkerLatitude(),
                        customMarker.getCustomMarkerLongitude()), latlonInter);
            }
        }
    }


    /*@Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_gps);

        Intent intent = getIntent();
        String order_code = intent.getStringExtra(TrackDeliveryActivity.ORDER_CODE);

        Log.v("INFO", "Order code: " + order_code);
    }*/
}
