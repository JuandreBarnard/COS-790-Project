package com.cos790.internetofthings.restaurantbuddy;

import android.app.ProgressDialog;
import android.content.Intent;
import android.os.AsyncTask;
import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.TextView;
import android.widget.Toast;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

public class DetailsActivity extends ActionBarActivity {

    private ProgressDialog pDialog;
    JSONParser jsonParser = new JSONParser();
    private static final String TAG_SUCCESS = "type";
    private static final String TAG_MESSAGE = "message";
    private String ID;
    private String restaurant_id;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_details);

        Intent intent = getIntent();
        ID = intent.getStringExtra(LoginActivity.ID);

        String selected_restaurant_json = intent.getStringExtra(AddPlaceActivity.SELECTED_RESTAURANT);
        try {

            String result = selected_restaurant_json.replaceAll("\"","\\\"");
            JSONObject json = new JSONObject(result);

            String id = json.getString("id");
            restaurant_id = json.getString("id");
            String logo = json.getString("logo");
            String lattitude = json.getString("id");
            String longitude = json.getString("logo");
            String description = json.getString("restaurantDescription");
            String country = json.getString("restaurantCountry");
            String city = json.getString("restaurantCity");
            String street = json.getString("restaurantStreet");
            String name = json.getString("restaurantName");
            String province = json.getString("restaurantProvince");

            TextView title = (TextView) findViewById(R.id.title);
            title.setText(name);

        } catch (JSONException e) {
            e.printStackTrace();
        }
    }

    // Add place button click
    public void add_place(View view) {
        Log.v("INFO", "Add button clicked! ");
        new AttemptAddPlace().execute();
    }

    class AttemptAddPlace extends AsyncTask<String, String, String> {
        boolean failure = false;

        @Override
        protected void onPreExecute() {
            super.onPreExecute();
            pDialog = new ProgressDialog(DetailsActivity.this);
            pDialog.setMessage("Attempting to add place...");
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
                        ApplicationConstants.APP_SERVER_create_user_place, "POST", params);

                success = json.getString(TAG_SUCCESS);
                if (success.equals("SUCCESS")) {
                    Intent intent = new Intent(getBaseContext(), WelcomeActivity.class);
                    intent.putExtra(LoginActivity.ID, ID);
                    Log.v("INFO", "Place added successfully");
                    startActivity(intent);
                    finish();

                }else{
                    Log.v("INFO", "Place could not be added!");
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
                Toast.makeText(DetailsActivity.this, file_url, Toast.LENGTH_LONG).show();
            }
        }
    }


}


