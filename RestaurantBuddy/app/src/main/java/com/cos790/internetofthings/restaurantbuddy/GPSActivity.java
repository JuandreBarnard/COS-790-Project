package com.cos790.internetofthings.restaurantbuddy;

import android.content.Intent;
import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;

public class GPSActivity extends ActionBarActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_gps);

        Intent intent = getIntent();
        String order_code = intent.getStringExtra(TrackDeliveryActivity.ORDER_CODE);

        Log.v("INFO", "Order code: " + order_code);
    }
}
