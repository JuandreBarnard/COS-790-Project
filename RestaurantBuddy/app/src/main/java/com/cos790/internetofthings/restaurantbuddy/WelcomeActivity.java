package com.cos790.internetofthings.restaurantbuddy;

import android.app.Activity;
import android.content.Intent;
import android.app.ProgressDialog;
import android.content.Context;
import android.location.Location;
import android.location.LocationManager;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.google.android.gms.common.ConnectionResult;
import com.google.android.gms.common.GooglePlayServicesClient;
import com.google.android.gms.common.GooglePlayServicesUtil;
import com.google.android.gms.location.LocationClient;
import com.google.android.gms.location.LocationListener;
import com.google.android.gms.location.LocationRequest;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.LinkedList;
import java.util.List;

public class WelcomeActivity extends Activity implements GooglePlayServicesClient.ConnectionCallbacks,GooglePlayServicesClient.OnConnectionFailedListener,LocationListener {

    Context applicationContext;
    private ProgressDialog pDialog;
    private CustomAdapter adapter;
    private ListView list;
    JSONParser jsonParser = new JSONParser();
    private JSONArray data;
    private static final String TAG_SUCCESS = "type";
    private static final String TAG_MESSAGE = "message";
    private LocationClient locationclient;
    private LocationRequest locationrequest;
    private LocationManager mLocationManager;
    private Location loc;
    private String ID;
    public final static String SELECTED_RESTAURANT = "com.cos790.internetofthings.restaurantbuddy.WelcomeActivity.SELECTED_RESTAURANT";

    @Override
  protected void onCreate(Bundle state) {
      super.onCreate(state);
      setContentView(R.layout.activity_welcome);
      Intent intent = getIntent();
      ID = intent.getStringExtra(LoginActivity.ID);

      applicationContext = getApplicationContext();
      list = (ListView) findViewById(R.id.list);
        int resp = GooglePlayServicesUtil.isGooglePlayServicesAvailable(this);
        if(resp == ConnectionResult.SUCCESS){
            locationclient = new LocationClient(this,this,this);
            locationclient.connect();
        }
        else{
            Toast.makeText(this, "Google Play Service Error " + resp, Toast.LENGTH_LONG).show();

        }

        new AttemptRestSearch().execute();




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


        /*if(locationclient!=null && locationclient.isConnected()) {
            locationrequest = LocationRequest.create();
            locationrequest.setInterval(100);
            locationclient.requestLocationUpdates(locationrequest, this);
        }*/
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
            loc = location;
            new AttemptRestSearch().execute();
            //txtLocationRequest.setText(location.getLatitude() + "," + location.getLongitude());
        }

    }
    @Override
    public void onRestart() {
        super.onRestart();
        //Refresh your stuff here
        list = (ListView) findViewById(R.id.list);
        new AttemptRestSearch().execute();
    }

  class AttemptRestSearch extends AsyncTask<String, String, String> {
      /**
       * Before starting background thread Show Progress Dialog
       */
        boolean failure = false;

        @Override
        protected void onPreExecute() {
            super.onPreExecute();
            pDialog = new ProgressDialog(WelcomeActivity.this);
            pDialog.setMessage("Retrieving list...");
            pDialog.setIndeterminate(false);
            pDialog.setCancelable(true);
            pDialog.show();
        }

        @Override
        protected String doInBackground(String... args) {
            // TODO Auto-generated method stub
            // Check for success tag
            String success;

            try {
                // Building Parameters
                List<NameValuePair> params = new ArrayList<>();
                params.add(new BasicNameValuePair("id", ID));

                Log.d("request!", "starting");
                // getting product details by making HTTP request

                // TODO: change back to user_places
                JSONObject json = jsonParser.makeHttpRequest(
                        ApplicationConstants.APP_SERVER_user_places, "POST", params);

                // check your log for json response
                Log.d("List attempt", json.toString());

                // json success tag
                success = json.getString(TAG_SUCCESS);
                if (success.equals("SUCCESS")) {
                    /*Intent intent = new Intent(getBaseContext(), WelcomeActivity.class);
                    intent.putExtra(USERNAME, username);

                    startActivity(intent);
                    Log.d("Login Successful!", json.toString());
                    //Intent i = new Intent(WelcomeActivity.this, ReadComments.class);
                    finish();*/
                    //startActivity(i);
                    data = json.getJSONArray("data");
                    List<String> ids = new LinkedList<>();
                    List<String> images = new LinkedList<>();
                    List<String> values = new LinkedList<>();
                    List<String> lat = new LinkedList<>();
                    List<String> lon = new LinkedList<>();
                    for(int i=0;i<data.length();i++)
                    {

                        JSONObject b = data.getJSONObject(i);


                        ids.add(b.getString("id"));

                        images.add(b.getString("logo"));

                        values.add(b.getString("restaurantName"));
                        lat.add(b.getString("lattitude"));
                        lon.add(b.getString("longitude"));

                    }
                    //listofurls = image_urls.toArray(new String[image_urls.size()]);

                    String[] id = new String[ids.size()];
                    /*String temp = null;
                    for(int i = 0; i< ids.size() ;i++)
                        for(int j = 0; j< ids.size()-1;j++)
                        {
                        if(distFrom(Float.parseFloat(lat.get(j)), Float.parseFloat(lon.get(j)), Float.parseFloat(lat.get(j+1)),Float.parseFloat(lon.get(j+1)))>0)
                        {

                        }
                        }*/

                        id = ids.toArray(new String[ids.size()]);
                        String[] a = values.toArray(new String[values.size()]);
                        String[] img = images.toArray(new String[images.size()]);

                        adapter = new CustomAdapter(applicationContext, id, a, img);



                } else {
                    Log.d("Login Failure!", json.getString(TAG_MESSAGE));
                    return json.getString(TAG_MESSAGE);

                }
            } catch (JSONException e) {
                e.printStackTrace();
            }

            return null;

        }

        /**
         * After completing background task Dismiss the progress dialog
         **/
        protected void onPostExecute(String file_url) {
            // Dismiss the dialog once product deleted
            pDialog.dismiss();
            if (file_url != null) {
                Toast.makeText(WelcomeActivity.this, file_url, Toast.LENGTH_LONG).show();
            }
            if(adapter != null) {
                list.setAdapter(adapter);
            }

            // List item onclick
            list.setOnItemClickListener(new AdapterView.OnItemClickListener() {
                @Override
                public void onItemClick(AdapterView<?> parent, View view, int position, long arg) {
                    String id = ((TextView) view.findViewById(R.id.id)).getText().toString();
                    JSONObject selected_restaurant = null;

                    try {
                        for (int i = 0; i < data.length(); i++) {

                            JSONObject b = data.getJSONObject(i);
                            if (b.getString("id").equals(id)) {
                                selected_restaurant = b;
                                break;
                            }
                        }
                    } catch (Exception e) {
                        Log.v("ERROR", e.toString());
                    }

                    Log.v("INFO", "Selected restaurant: " + selected_restaurant.toString());
                    details_view(selected_restaurant);

                }
            });
        }
    }

    //Add place activity
    public void add_place_view(View view) {
        Log.v("INFO", "Add place button clicked!");
        Intent intent = new Intent(this, AddPlaceActivity.class);
        intent.putExtra(LoginActivity.ID, ID);
        startActivity(intent);

    }

    // Details activity
    public void details_view(JSONObject selected_item) {
        Intent intent = new Intent(this, DetailsActivity2.class);
        intent.putExtra(SELECTED_RESTAURANT, selected_item.toString());
        intent.putExtra(LoginActivity.ID, ID);
        startActivity(intent);
    }

    public static float distFrom(float lat1, float lng1, float lat2, float lng2) {
        double earthRadius = 6371000; //meters
        double dLat = Math.toRadians(lat2-lat1);
        double dLng = Math.toRadians(lng2-lng1);
        double a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                Math.cos(Math.toRadians(lat1)) * Math.cos(Math.toRadians(lat2)) *
                        Math.sin(dLng/2) * Math.sin(dLng/2);
        double c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        float dist = (float) (earthRadius * c);

        return dist;
    }
    
}
