package com.cos790.internetofthings.restaurantbuddy;

import android.app.ProgressDialog;
import android.content.Intent;
import android.os.AsyncTask;
import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.TextView;
import android.widget.Toast;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

public class DetailsActivity2 extends ActionBarActivity {

    private ProgressDialog pDialog;
    JSONParser jsonParser = new JSONParser();
    private static final String TAG_SUCCESS = "type";
    private static final String TAG_MESSAGE = "message";
    private String ID;
    private String restaurant_id;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_details2);

        Intent intent = getIntent();
        ID = intent.getStringExtra(LoginActivity.ID);

        String selected_restaurant_json = intent.getStringExtra(WelcomeActivity.SELECTED_RESTAURANT);
        try {

            String result = selected_restaurant_json.replaceAll("\"","\\\"");
            JSONObject json = new JSONObject(result);

            Log.v("INFO", "HEERRREEEE");

            String id = json.getString("id");
            restaurant_id = json.getString("id");

            String cnty = json.getString("restaurantCountry");
            String cty = json.getString("restaurantCity");
            String str = json.getString("restaurantStreet");
            String name = json.getString("restaurantName");
            String prv = json.getString("restaurantProvince");


//            String logo = json.getString("logo");
//            String lattitude = json.getString("lattitude");
//            String longitude = json.getString("longitude");

            TextView title = (TextView) findViewById(R.id.title);
            title.setText(name);

            TextView city = (TextView) findViewById(R.id.city);
            city.setText("City: " + cty);

            TextView street = (TextView) findViewById(R.id.street);
            street.setText("Street: " + str);

            TextView country = (TextView) findViewById(R.id.country);
            country.setText("Country: " + cnty);

            TextView province = (TextView) findViewById(R.id.province);
            province.setText("Province: " + prv);


        } catch (JSONException e) {
            e.printStackTrace();
        }
    }

    // Delete button click
    public void delete(View view) {
        // TODO: delete place from user list
        Log.v("INFO", "Delete button clicked!");
        new AttemptDeletePlace().execute();
    }

    // Track delivery button click
    public void track_delivery(View view) {
        Log.v("INFO", "Track delivery button clicked!");
        Intent intent = new Intent(this, TrackDeliveryActivity.class);
        intent.putExtra(LoginActivity.ID, ID);
        startActivity(intent);
    }

    class AttemptDeletePlace extends AsyncTask<String, String, String> {
        boolean failure = false;

        @Override
        protected void onPreExecute() {
            super.onPreExecute();
            pDialog = new ProgressDialog(DetailsActivity2.this);
            pDialog.setMessage("Attempting to delete place...");
            pDialog.setIndeterminate(false);
            pDialog.setCancelable(true);
            pDialog.show();
        }

        @Override
        protected String doInBackground(String... args) {
            String success;

            try {
                List<NameValuePair> params = new ArrayList<NameValuePair>();
                params.add(new BasicNameValuePair("user_id", ID));
                params.add(new BasicNameValuePair("restaurant_id", restaurant_id));

                Log.d("request!", "starting");
                JSONObject json = jsonParser.makeHttpRequest(
                        ApplicationConstants.APP_SERVER_delete_user_place, "POST", params);

                success = json.getString(TAG_SUCCESS);
                if (success.equals("SUCCESS")) {
                    Intent intent = new Intent(getBaseContext(), WelcomeActivity.class);
                    intent.putExtra(LoginActivity.ID, ID);
                    Log.v("INFO", "Place deleted successfully");
                    startActivity(intent);
                    finish();

                }else{
                    Log.v("INFO", "Place could not be deleted!");
                    return json.getString(TAG_MESSAGE);
                }
            } catch (JSONException e) {
                e.printStackTrace();
            }

            return null;
        }

        protected void onPostExecute(String file_url) {
            pDialog.dismiss();
            if (file_url != null){
                Toast.makeText(DetailsActivity2.this, file_url, Toast.LENGTH_LONG).show();
            }
        }
    }
}
