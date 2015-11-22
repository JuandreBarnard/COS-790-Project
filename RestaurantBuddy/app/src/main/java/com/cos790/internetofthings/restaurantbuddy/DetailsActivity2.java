package com.cos790.internetofthings.restaurantbuddy;

import android.content.Intent;
import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.TextView;

import org.json.JSONException;
import org.json.JSONObject;

public class DetailsActivity2 extends ActionBarActivity {

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

            int id = Integer.parseInt(json.getString("id"));
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

    // Delete button click
    public void delete(View view) {
        // TODO: delete place from user list
        Log.v("INFO", "Delete button clicked!");
    }

    // Track delivery button click
    public void track_delivery(View view) {
        Log.v("INFO", "Track delivery button clicked!");
        Intent intent = new Intent(this, TrackDeliveryActivity.class);
        intent.putExtra(LoginActivity.ID, ID);
        startActivity(intent);
    }
}
