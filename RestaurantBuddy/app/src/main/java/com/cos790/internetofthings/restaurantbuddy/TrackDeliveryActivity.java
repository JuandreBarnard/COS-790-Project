package com.cos790.internetofthings.restaurantbuddy;

import android.content.Intent;
import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.EditText;

public class TrackDeliveryActivity extends ActionBarActivity {

    private String ID;
    private EditText order_code;
    public final static String ORDER_CODE = "com.cos790.internetofthings.restaurantbuddy.RegisterActivity.ORDER_CODE";


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_track_delivery);

        Intent intent = getIntent();
        ID = intent.getStringExtra(LoginActivity.ID);
    }

    // Track button click
    public void track(View view) {
        Log.v("INFO", "Track button clicked!");

        order_code = (EditText)findViewById(R.id.order_code);
        String oc = order_code.getText().toString();

        Intent intent = new Intent(this, GPSActivity.class);
        intent.putExtra(LoginActivity.ID, ID);
        intent.putExtra(ORDER_CODE, oc);
        startActivity(intent);
    }
}
